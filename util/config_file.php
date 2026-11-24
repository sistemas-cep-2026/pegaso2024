<?php
/*
 * util/config_file.php
 * ============================================================================
 * SUBIDA, VALIDACIÓN Y ELIMINACIÓN DE ARCHIVOS PARA TODO PEGASO (PDF, fotos, ...)
 *
 * Reglas de este archivo
 *   - Solo funciones con prefijo u_file_ (mismo estilo que util.php). Sin clases.
 *   - No imprime nada, no usa sesión ni base de datos. Los permisos de negocio
 *     (quién puede subir/eliminar, bloqueos, qué campo de la BD se actualiza)
 *     siguen viviendo en cada endpoint.
 *   - El archivo se mueve/convierte con util/class_upload.php (clase Upload).
 *   - Ante cualquier problema lanza Exception con mensaje en español, para que
 *     el endpoint lo capture con su try/catch habitual.
 *   - Compatible con PHP 7.1+ (no usa sintaxis exclusiva de PHP 8).
 *
 * DÓNDE SE CONFIGURA TODO (tipo, tamaño, ruta, formatos)
 *   Solo en u_file_perfiles(). Para un tipo nuevo se agrega un perfil ahí.
 *
 * USO TÍPICO EN UN ENDPOINT (ej.: tramite/exp_file_update.php)
 *
 *   require_once(dirname(__DIR__) . "/util/config_file.php");   // incluye class_upload.php
 *
 *   u_file_verificar_post();                                    // detecta post_max_size excedido
 *   $nombre = u_file_subir($_FILES['file_adjunto'], 'pdf', 'TRAM_' . $c_expediente, array('max_nombre' => 30));
 *   ...                                                          // guardar $nombre en la BD
 *   u_file_eliminar('pdf', $nombre);                             // borrar (p. ej. si falló la BD)
 *
 * USO TÍPICO EN LA PANTALLA (HTML)
 *
 *   <input type="file" name="file_adjunto" accept="<?php echo u_file_accept('pdf'); ?>">
 *   Máximo tamaño de archivo <?php echo u_file_texto_limite('pdf'); ?>
 *   <a href="<?php echo u_file_url('pdf', $nombre); ?>">Ver PDF</a>
 * ============================================================================
 */
require_once(__DIR__ . "/class_upload.php");

/*
 * Carpeta FÍSICA de los PDF de Trámite: unidad D: del servidor, FUERA de la carpeta web del proyecto.
 *   - Como no es pública, los PDF no se abren por URL directa: los entrega tramite/exp_file_ver.php
 *     (que exige sesión iniciada).
 *   - La cuenta con la que corre Apache/IIS debe tener permiso de modificar D:\file_tramites
 *     (y, si php.ini define open_basedir, esa ruta debe estar incluida).
 *   - Para otra ruta (p. ej. una PC de desarrollo sin unidad D:) defina FILE_TRAMITES_DIR en
 *     util/config.php ANTES de cargar este archivo. Con '' se usa la carpeta file_tramites dentro del
 *     proyecto y los enlaces vuelven a ser directos.
 */
if (!defined('FILE_TRAMITES_DIR')) {
    define('FILE_TRAMITES_DIR', 'D:/file_tramites');
}

/*
 * Carpeta FÍSICA de las fotos de colegiados (solo lectura desde PEGASO: las sube otro proceso).
 *   - Puede ser una unidad local ('D:/fotos') o una ruta de red UNC ('//192.168.88.9/fotos').
 *   - Se define en util/config.php ANTES de cargar este archivo. Vacío = perfil sin carpeta.
 *   - Igual que los PDF: la cuenta del servicio Apache necesita permiso de LECTURA en esa carpeta.
 */
if (!defined('FOTOS_DIR')) {
    define('FOTOS_DIR', '');
}

/*
 * Carpeta FÍSICA de las fichas del colegiado: <cep>.pdf con toda su documentación. Solo lectura.
 *   Ej.: '//192.168.88.9/fichas'. Se define en util/config.php. Vacío = perfil sin carpeta.
 *   Datos personales sensibles: los entrega comun/api_ficha.php (sesión o enlace firmado con tipo 'ficha').
 */
if (!defined('FICHAS_DIR')) {
    define('FICHAS_DIR', '');
}

/*
 * Carpeta FÍSICA de las imágenes de certificados de capacitación (fondo del diploma de asistente y ponente).
 *   Ej.: '//192.168.88.9/capacitacion/certificados'. Se define en util/config.php.
 *   PEGASO SUBE y BORRA aquí: la cuenta de Apache necesita permiso de MODIFICAR.
 *   Vacío = se sigue usando capacitacion/img dentro del proyecto (como antes).
 *   Las imágenes antiguas que aún estén en capacitacion/img se siguen mostrando (ver u_file_certificado_ruta()).
 */
if (!defined('CERTIFICADOS_DIR')) {
    define('CERTIFICADOS_DIR', '');
}

/*
 * Vigencia máxima (segundos) de un enlace firmado para otros sistemas (portal del colegiado,
 * buscador público). Un enlace con vencimiento mayor se rechaza aunque la firma sea correcta.
 */
if (!defined('U_FILE_API_MAX_SEG')) {
    define('U_FILE_API_MAX_SEG', 3600);
}

/**
 * Perfiles de archivo del proyecto. ÚNICO lugar donde se definen tipo, tamaño y ruta.
 *
 * Claves de cada perfil:
 *   etiqueta     texto corto para pantallas ("PDF", "JPG o PNG")
 *   extensiones  extensiones permitidas (minúsculas, sin punto)
 *   mimes        tipos MIME permitidos (se verifica el contenido real, no solo el nombre)
 *   max_bytes    tamaño máximo en bytes
 *   carpeta      carpeta destino RELATIVA a la raíz del proyecto (la que contiene util/).
 *                null = la debe indicar quien llama con $opciones['carpeta'].
 *   ruta_base    (opcional) carpeta ABSOLUTA fuera del proyecto, ej. 'D:/file_tramites'.
 *                Si tiene valor MANDA sobre 'carpeta'. Vacío/ausente = se usa 'carpeta'.
 *   visor        (opcional) script PHP que entrega el archivo cuando está en una carpeta no pública
 *                (ruta_base). Sin visor, o sin ruta_base, el enlace es directo: url(carpeta/archivo).
 *   sobrescribir true  = si ya existe un archivo con ese nombre lo reemplaza
 *                false = agrega _1, _2, ... (nunca pisa un archivo existente)
 *   imagen       null para archivos que no son imagen. Para imágenes (opcional):
 *                  convertir ('jpeg'), calidad (0-100), ancho, alto, recortar (true)
 *   msg_formato / msg_tamano / msg_invalido   mensajes propios (opcionales)
 */
function u_file_perfiles()
{
    return array(

        // PDF del expediente (módulo Trámite). Se guarda en file_tramites/.
        'pdf' => array(
            'etiqueta'     => 'PDF',
            'extensiones'  => array('pdf'),
            'mimes'        => array('application/pdf'),
            'max_bytes'    => 5 * 1024 * 1024,
            'carpeta'      => 'file_tramites',            // solo se usa si FILE_TRAMITES_DIR = ''
            'ruta_base'    => FILE_TRAMITES_DIR,          // D:/file_tramites
            'visor'        => 'tramite/exp_file_ver.php', // entrega el PDF validando la sesión
            'sobrescribir' => false,
            'imagen'       => null,
            'msg_formato'  => 'Solo se permiten archivos en formato PDF.',
            'msg_invalido' => 'El archivo subido no es un PDF válido.',
        ),

        // Foto del perfil de usuario (seguridad/perfil_subir_foto.php).
        // Mismos valores que usa hoy ese script: 300 KB, JPG/PNG, 300x400 recortada, JPEG calidad 85.
        'foto_perfil' => array(
            'etiqueta'     => 'JPG o PNG',
            'extensiones'  => array('jpg', 'jpeg', 'png'),
            'mimes'        => array('image/jpeg', 'image/png'),
            'max_bytes'    => 300 * 1024,
            'carpeta'      => 'images/user',
            'sobrescribir' => true,
            'imagen'       => array('convertir' => 'jpeg', 'calidad' => 85, 'ancho' => 300, 'alto' => 400, 'recortar' => true),
            'msg_formato'  => 'Formato no permitido. Solo se aceptan JPG, JPEG o PNG.',
            'msg_tamano'   => 'La imagen supera el límite de 300 KB.',
            'msg_invalido' => 'El archivo subido no es una imagen válida.',
        ),

        // Foto del colegiado (<num_documento>.jpg o .png). Solo lectura: la entrega comun/api_foto.php.
        'foto_colegiado' => array(
            'etiqueta'     => 'JPG o PNG',
            'extensiones'  => array('jpg', 'png'),
            'mimes'        => array('image/jpeg', 'image/png'),
            'max_bytes'    => 2 * 1024 * 1024,
            'carpeta'      => null,
            'ruta_base'    => FOTOS_DIR,
            'visor'        => 'comun/api_foto.php',
            'sobrescribir' => false,
            'imagen'       => null,
        ),

        // Ficha del colegiado (<cep>.pdf). Solo lectura: la entrega comun/api_ficha.php.
        'ficha_colegiado' => array(
            'etiqueta'     => 'PDF',
            'extensiones'  => array('pdf'),
            'mimes'        => array('application/pdf'),
            'max_bytes'    => 50 * 1024 * 1024,
            'carpeta'      => null,
            'ruta_base'    => FICHAS_DIR,
            'visor'        => 'comun/api_ficha.php',
            'sobrescribir' => false,
            'imagen'       => null,
        ),

        // Imagen de certificado de capacitación (cap_eventos.img_asistente / img_ponente).
        // Se sube con capacitacion/eve_update_file.php y se muestra con comun/api_certificado.php.
        'certificado' => array(
            'etiqueta'     => 'JPG o PNG',
            'extensiones'  => array('jpg', 'jpeg', 'png'),
            'mimes'        => array('image/jpeg', 'image/png'),
            'max_bytes'    => 5 * 1024 * 1024,
            'carpeta'      => 'capacitacion/img',          // solo se usa si CERTIFICADOS_DIR = ''
            'ruta_base'    => CERTIFICADOS_DIR,
            'visor'        => 'comun/api_certificado.php',
            'sobrescribir' => false,
            'imagen'       => array('convertir' => 'jpeg', 'calidad' => 85),
            'msg_formato'  => 'Formato no permitido. Solo se aceptan JPG, JPEG o PNG.',
            'msg_invalido' => 'El archivo subido no es una imagen válida.',
        ),

        // Imagen genérica sin redimensionar (ej.: fondos de certificado). SIN USO TODAVÍA:
        // los valores son una propuesta; ajústelos al adoptarlo. La carpeta la indica quien llama.
        'imagen' => array(
            'etiqueta'     => 'JPG o PNG',
            'extensiones'  => array('jpg', 'jpeg', 'png'),
            'mimes'        => array('image/jpeg', 'image/png'),
            'max_bytes'    => 2 * 1024 * 1024,
            'carpeta'      => null,
            'sobrescribir' => false,
            'imagen'       => array('convertir' => 'jpeg', 'calidad' => 85),
            'msg_formato'  => 'Formato no permitido. Solo se aceptan JPG, JPEG o PNG.',
            'msg_invalido' => 'El archivo subido no es una imagen válida.',
        ),

        /* PLANTILLA para un tipo nuevo (copiar, descomentar y ajustar):
        'mi_tipo' => array(
            'etiqueta'     => 'XLSX',
            'extensiones'  => array('xlsx'),
            'mimes'        => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
            'max_bytes'    => 5 * 1024 * 1024,
            'carpeta'      => 'file_mi_modulo',
            'sobrescribir' => false,
            'imagen'       => null,
        ),
        */
    );
}

/**
 * Devuelve el perfil $tipo completo (con valores por defecto). Lanza Exception si no existe.
 */
function u_file_perfil($tipo)
{
    $perfiles = u_file_perfiles();
    $tipo = (string) $tipo;
    if (!isset($perfiles[$tipo])) {
        throw new Exception("Tipo de archivo no configurado: " . $tipo);
    }
    $defecto = array(
        'etiqueta'     => '',
        'extensiones'  => array(),
        'mimes'        => array(),
        'max_bytes'    => 0,
        'carpeta'      => null,
        'ruta_base'    => '',
        'visor'        => '',
        'sobrescribir' => false,
        'imagen'       => null,
        'msg_formato'  => null,
        'msg_tamano'   => null,
        'msg_invalido' => null,
    );
    return array_merge($defecto, $perfiles[$tipo]);
}

/* ---------------------------------------------------------------------------
 * Textos y datos para la pantalla
 * ------------------------------------------------------------------------- */

/**
 * Bytes -> texto corto: 5242880 => "5Mb", 307200 => "300Kb".
 */
function u_file_tamano_texto($bytes)
{
    $bytes = (float) $bytes;
    if ($bytes >= 1048576) {
        $mb = round($bytes / 1048576, 1);
        return rtrim(rtrim(number_format($mb, 1, '.', ''), '0'), '.') . 'Mb';
    }
    return round($bytes / 1024) . 'Kb';
}

/** Límite del perfil en texto: u_file_texto_limite('pdf') => "5Mb". */
function u_file_texto_limite($tipo)
{
    $p = u_file_perfil($tipo);
    return u_file_tamano_texto($p['max_bytes']);
}

/** Etiqueta corta del perfil: u_file_etiqueta('pdf') => "PDF". */
function u_file_etiqueta($tipo)
{
    $p = u_file_perfil($tipo);
    return $p['etiqueta'];
}

/** Valor para el atributo accept del <input type="file">: ".pdf,application/pdf". */
function u_file_accept($tipo)
{
    $p = u_file_perfil($tipo);
    $accept = array();
    foreach ($p['extensiones'] as $ext) {
        $accept[] = '.' . $ext;
    }
    foreach ($p['mimes'] as $mime) {
        $accept[] = $mime;
    }
    return implode(',', $accept);
}

/**
 * Enlace para abrir el archivo.
 *   - Perfil con ruta_base + visor (el 'pdf' en D:): enlace al visor con el nombre cifrado con s_crypt(),
 *       u_file_url('pdf', 'TRAM_123.pdf') => .../tramite/exp_file_ver.php?f=<cifrado>
 *     (el cifrado depende de la sesión: el enlace solo sirve para el usuario que tiene la pantalla abierta).
 *   - Si no: enlace directo a la carpeta pública del proyecto,
 *       u_file_url('foto_perfil', 'a.jpeg') => .../images/user/a.jpeg
 */
function u_file_url($tipo, $nombre, $carpeta = null)
{
    $p = u_file_perfil($tipo);
    $nombre = basename(str_replace('\\', '/', (string) $nombre));
    $directo = ($carpeta !== null && $carpeta !== '');

    if (!$directo && trim((string) $p['ruta_base']) !== '' && trim((string) $p['visor']) !== '') {
        $clave = function_exists('s_crypt') ? s_crypt($nombre, 'in') : $nombre;
        $ruta = u_file_ruta_relativa_valida($p['visor']) . '?f=' . rawurlencode((string) $clave);
    } else {
        $rel = u_file_ruta_relativa_valida($directo ? $carpeta : $p['carpeta']);
        $ruta = $rel . '/' . rawurlencode($nombre);
    }
    return function_exists('url') ? url($ruta) : $ruta;
}

/* ---------------------------------------------------------------------------
 * Límites del servidor (php.ini)
 * ------------------------------------------------------------------------- */

/** "40M", "512K", "2G" o "1048576" -> bytes. 0 = sin límite / no definido. */
function u_file_ini_bytes($valor)
{
    $valor = trim((string) $valor);
    if ($valor === '') {
        return 0;
    }
    $numero = (float) $valor;
    $sufijo = strtolower(substr($valor, -1));
    if ($sufijo === 'g') {
        $numero *= 1073741824;
    } elseif ($sufijo === 'm') {
        $numero *= 1048576;
    } elseif ($sufijo === 'k') {
        $numero *= 1024;
    }
    return (int) $numero;
}

/** Menor entre upload_max_filesize y post_max_size, en bytes (0 = sin límite). */
function u_file_limite_servidor()
{
    $limites = array();
    $archivo = u_file_ini_bytes(ini_get('upload_max_filesize'));
    $post    = u_file_ini_bytes(ini_get('post_max_size'));
    if ($archivo > 0) {
        $limites[] = $archivo;
    }
    if ($post > 0) {
        $limites[] = $post;
    }
    return empty($limites) ? 0 : min($limites);
}

/**
 * Si el envío superó post_max_size, PHP vacía $_POST y $_FILES y el endpoint solo ve
 * "parámetros faltantes". Llamar a esta función ANTES de leer $_REQUEST para dar el mensaje correcto.
 */
function u_file_verificar_post()
{
    $longitud = isset($_SERVER['CONTENT_LENGTH']) ? (int) $_SERVER['CONTENT_LENGTH'] : 0;
    $metodo   = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : '';
    if ($metodo === 'POST' && $longitud > 0 && empty($_POST) && empty($_FILES)) {
        $limite = u_file_limite_servidor();
        throw new Exception("El archivo supera el tamaño permitido por el servidor" .
            ($limite > 0 ? " (" . u_file_tamano_texto($limite) . " como máximo)." : "."));
    }
}

function u_file_ruta_relativa_valida($relativa)
{
    $normal = str_replace('\\', '/', trim((string) $relativa));
    // Una ruta de red (\\servidor\carpeta) NO es relativa: sin este control quedaría como "servidor/carpeta" dentro del proyecto
    if (strpos($normal, '//') === 0) {
        throw new Exception("Carpeta de archivos no válida.");
    }
    $relativa = trim($normal, "/ \t\n\r\0\x0B");
    if ($relativa === '' || strpos($relativa, '..') !== false || strpos($relativa, ':') !== false || strpos($relativa, "\0") !== false) {
        throw new Exception("Carpeta de archivos no válida.");
    }
    return $relativa;
}

function u_file_ruta_absoluta_valida($ruta, $es_windows = null)
{
    if ($es_windows === null) {
        $es_windows = (DIRECTORY_SEPARATOR === '\\');
    }
    $ruta = rtrim(str_replace('\\', '/', trim((string) $ruta)), '/');
    if ($ruta === '' || strpos($ruta, '..') !== false || strpos($ruta, "\0") !== false) {
        throw new Exception("Carpeta de archivos no válida.");
    }
    // Ruta de red UNC (\\servidor\recurso[\carpeta]): solo en Windows, servidor y recurso obligatorios.
    $es_unc = (preg_match('#^//[A-Za-z0-9._-]+/[A-Za-z0-9$._ -]+(/[^/]+)*$#', $ruta) === 1);
    if ($es_unc) {
        if (!$es_windows) {
            throw new Exception("Carpeta de archivos no válida: la ruta no corresponde a este servidor.");
        }
        return $ruta;
    }
    if (strpos($ruta, '//') === 0) {
        throw new Exception("Carpeta de archivos no válida.");
    }
    $es_unidad = (preg_match('#^[A-Za-z]:/[^/]#', $ruta) === 1);
    $es_unix   = (strlen($ruta) > 1 && $ruta[0] === '/');
    if (($es_unidad && !$es_windows) || (!$es_unidad && !$es_unix) || ($es_unix && $es_windows)) {
        throw new Exception("Carpeta de archivos no válida: la ruta no corresponde a este servidor.");
    }
    return $ruta;
}

function u_file_carpeta($tipo, $carpeta = null, $crear = true)
{
    $p = u_file_perfil($tipo);
    $explicita = ($carpeta !== null && $carpeta !== '');
    $base_abs  = $explicita ? '' : trim((string) $p['ruta_base']);

    if ($base_abs !== '') {
        $destino = str_replace('/', DIRECTORY_SEPARATOR, u_file_ruta_absoluta_valida($base_abs));
    } else {
        $relativa = $explicita ? $carpeta : $p['carpeta'];
        if ($relativa === null || $relativa === '') {
            throw new Exception("El tipo de archivo '" . $tipo . "' no tiene carpeta definida.");
        }
        $relativa = u_file_ruta_relativa_valida($relativa);

        $raiz = realpath(dirname(__DIR__));
        if ($raiz === false) {
            throw new Exception("No se pudo resolver la carpeta de archivos.");
        }
        $destino = $raiz . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativa);
    }

    if (!is_dir($destino)) {
        if (!$crear) {
            return null;
        }
        if (!@mkdir($destino, 0775, $base_abs === '') && !is_dir($destino)) {
            error_log("config_file: no se pudo crear la carpeta " . $destino);
            throw new Exception("No se pudo crear la carpeta de archivos.");
        }
    }
    $real = realpath($destino);
    if ($real === false) {
        throw new Exception("No se pudo resolver la carpeta de archivos.");
    }
    if ($crear && !is_writable($real)) {
        error_log("config_file: sin permiso de escritura en " . $real);
        throw new Exception("La carpeta de archivos no tiene permiso de escritura.");
    }
    return $real . DIRECTORY_SEPARATOR;
}

function u_file_nombre_seguro($texto)
{
    return preg_replace('/[^A-Za-z0-9_\-]/', '', (string) $texto);
}

function u_file_detectar_mime($ruta)
{
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = finfo_file($finfo, $ruta);
            finfo_close($finfo);
            return is_string($mime) ? $mime : '';
        }
    }
    if (function_exists('mime_content_type')) {
        $mime = @mime_content_type($ruta);
        return is_string($mime) ? $mime : '';
    }
    return '';
}

function u_file_validar($archivo, $tipo)
{
    $p = u_file_perfil($tipo);

    if (
        !is_array($archivo) || !isset($archivo['error'], $archivo['tmp_name'], $archivo['name'], $archivo['size'])
        || is_array($archivo['error']) || is_array($archivo['name'])
    ) {
        throw new Exception("Error al subir el archivo.");
    }

    $error = (int) $archivo['error'];
    if ($error !== UPLOAD_ERR_OK) {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $limite = u_file_limite_servidor();
                throw new Exception("El archivo supera el tamaño permitido por el servidor" .
                    ($limite > 0 ? " (" . u_file_tamano_texto($limite) . " como máximo)." : "."));
            case UPLOAD_ERR_NO_FILE:
                throw new Exception("No se seleccionó ningún archivo.");
            case UPLOAD_ERR_PARTIAL:
                throw new Exception("El archivo se subió de forma incompleta. Intente nuevamente.");
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
            case UPLOAD_ERR_EXTENSION:
                throw new Exception("El servidor no pudo guardar el archivo temporal.");
            default:
                throw new Exception("Error al subir el archivo.");
        }
    }

    $tamano = (int) $archivo['size'];
    if ($tamano <= 0) {
        throw new Exception("El archivo está vacío.");
    }
    if ($tamano > (int) $p['max_bytes']) {
        throw new Exception($p['msg_tamano'] ? $p['msg_tamano']
            : "El archivo supera el tamaño máximo permitido (" . u_file_tamano_texto($p['max_bytes']) . ").");
    }

    $ext = strtolower(pathinfo((string) $archivo['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $p['extensiones'], true)) {
        throw new Exception($p['msg_formato'] ? $p['msg_formato']
            : "Formato no permitido. Solo se aceptan: " . strtoupper(implode(', ', $p['extensiones'])) . ".");
    }

    $mime = u_file_detectar_mime($archivo['tmp_name']);
    if ($mime === '') {
        throw new Exception("No se pudo verificar el tipo de archivo.");
    }
    $mensaje_invalido = $p['msg_invalido'] ? $p['msg_invalido'] : "El archivo subido no es válido.";
    if (!in_array($mime, $p['mimes'], true)) {
        throw new Exception($mensaje_invalido);
    }
    if (is_array($p['imagen']) && @getimagesize($archivo['tmp_name']) === false) {
        throw new Exception($mensaje_invalido);
    }

    return array(
        'ext'             => $ext,
        'mime'            => $mime,
        'size'            => $tamano,
        'nombre_original' => basename(str_replace('\\', '/', (string) $archivo['name'])),
    );
}

/* ---------------------------------------------------------------------------
 * Subir / eliminar
 * ------------------------------------------------------------------------- */

function u_file_subir($archivo, $tipo, $nombre_base, $opciones = array())
{
    $p    = u_file_perfil($tipo);
    $info = u_file_validar($archivo, $tipo);

    $base = u_file_nombre_seguro($nombre_base);
    if ($base === '') {
        throw new Exception("Nombre de archivo no válido.");
    }

    $max_nombre = isset($opciones['max_nombre']) ? (int) $opciones['max_nombre'] : 0;
    if ($max_nombre > 0 && strlen($base) + 1 + strlen($info['ext']) > $max_nombre) {
        throw new Exception("El nombre del archivo generado supera los " . $max_nombre . " caracteres.");
    }

    $carpeta = u_file_carpeta($tipo, isset($opciones['carpeta']) ? $opciones['carpeta'] : null);
    $sobrescribir = isset($opciones['sobrescribir']) ? (bool) $opciones['sobrescribir'] : (bool) $p['sobrescribir'];

    $uploader = new Upload($archivo);
    if (!$uploader->uploaded) {
        throw new Exception("Error en el archivo: " . $uploader->error);
    }

    $uploader->file_new_name_body = $base;
    $uploader->file_overwrite     = $sobrescribir;
    $uploader->mime_check         = true;
    $uploader->allowed            = $p['mimes'];
    $uploader->file_max_size      = (int) $p['max_bytes'];

    if (is_array($p['imagen'])) {
        $im = $p['imagen'];
        if (!empty($im['convertir'])) {
            $uploader->image_convert = $im['convertir'];
        }
        if (!empty($im['calidad'])) {
            $uploader->jpeg_quality = (int) $im['calidad'];
        }
        if (!empty($im['ancho']) && !empty($im['alto'])) {
            $uploader->image_resize = true;
            $uploader->image_x      = (int) $im['ancho'];
            $uploader->image_y      = (int) $im['alto'];
            if (!empty($im['recortar'])) {
                $uploader->image_ratio_crop = true;
            }
        }
    }

    $uploader->Process($carpeta);
    if (!$uploader->processed) {
        $detalle = $uploader->error;
        $uploader->clean();
        throw new Exception("Error al procesar archivo: " . $detalle);
    }

    $nombre_final = $uploader->file_dst_name;
    $uploader->clean();
    if ($max_nombre > 0 && strlen($nombre_final) > $max_nombre) {
        @unlink($carpeta . $nombre_final);
        throw new Exception("El nombre del archivo generado supera los " . $max_nombre . " caracteres.");
    }

    return $nombre_final;
}
function u_file_eliminar($tipo, $nombre, $carpeta = null)
{
    $ruta = u_file_ruta($tipo, $nombre, $carpeta);
    if ($ruta === null) {
        return false;
    }
    if (!@unlink($ruta)) {
        throw new Exception("No se pudo eliminar el archivo del servidor.");
    }
    return true;
}

function u_file_ruta($tipo, $nombre, $carpeta = null)
{
    $p = u_file_perfil($tipo);
    $nombre = basename(str_replace('\\', '/', trim((string) $nombre)));
    if ($nombre === '' || $nombre === '.' || $nombre === '..') {
        throw new Exception("Nombre del archivo no proporcionado.");
    }
    $ext = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
    if (!in_array($ext, $p['extensiones'], true)) {
        throw new Exception("El archivo no corresponde al tipo permitido.");
    }

    $dir = u_file_carpeta($tipo, $carpeta, false);
    if ($dir === null) {
        return null;
    }
    $ruta = $dir . $nombre;
    return is_file($ruta) ? $ruta : null;
}

/**
 * Envía el archivo al navegador.
 *   $cache_seg  0 (por defecto) = sin caché, como siempre.
 *               > 0 = el navegador lo guarda ese tiempo y lo revalida con ETag (responde 304 si no cambió).
 */
function u_file_servir($tipo, $nombre, $descargar = false, $cache_seg = 0, $carpeta = null)
{
    $p = u_file_perfil($tipo);
    $ruta = u_file_ruta($tipo, $nombre, $carpeta);
    if ($ruta === null) {
        throw new Exception("El archivo no existe.");
    }
    $mime = u_file_detectar_mime($ruta);
    if ($mime === '' && in_array('application/pdf', $p['mimes'], true)) {
        $fh = @fopen($ruta, 'rb');
        if ($fh) {
            $mime = (fread($fh, 5) === '%PDF-') ? 'application/pdf' : '';
            fclose($fh);
        }
    }
    if (!in_array($mime, $p['mimes'], true)) {
        throw new Exception("El archivo no es válido.");
    }
    $tam = @filesize($ruta);
    if ($tam === false) {
        throw new Exception("No se pudo leer el archivo.");
    }

    if (function_exists('session_status') && session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    @ini_set('zlib.output_compression', '0');
    if (function_exists('apache_setenv')) {
        @apache_setenv('no-gzip', '1');
    }
    header_remove('Pragma');
    header_remove('Expires');

    $cache_seg = (int) $cache_seg;
    if ($cache_seg > 0) {
        $etag = '"' . md5(basename($ruta) . '|' . $tam . '|' . @filemtime($ruta)) . '"';
        header('ETag: ' . $etag);
        header('Cache-Control: private, max-age=' . $cache_seg);
        $si_cambio = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim((string) $_SERVER['HTTP_IF_NONE_MATCH']) : '';
        if ($si_cambio !== '' && $si_cambio === $etag) {
            http_response_code(304);
            return true;
        }
    } else {
        header('Cache-Control: private, max-age=0, must-revalidate');
    }

    $nombre_visible = preg_replace('/[^A-Za-z0-9_.\-]/', '_', basename($ruta));
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . $tam);
    header('Content-Disposition: ' . ($descargar ? 'attachment' : 'inline') . '; filename="' . $nombre_visible . '"');
    header('X-Content-Type-Options: nosniff');
    header('Accept-Ranges: none');

    $fh = @fopen($ruta, 'rb');
    if ($fh === false) {
        error_log("config_file: no se pudo abrir para lectura " . $ruta);
        return false;
    }
    while (!feof($fh)) {
        $trozo = fread($fh, 262144);
        if ($trozo === false) {
            break;
        }
        echo $trozo;
        flush();
    }
    fclose($fh);
    return true;
}

function u_file_buscar_pdf_expediente($row, &$buscados)
{
    $buscados = [];
    $cc  = (int) ($row['cc_docrecibidos'] ?? 0);
    $exp = preg_replace('/[^A-Za-z0-9]/', '', trim((string) ($row['c_expediente'] ?? '')));

    $nombres = [];
    foreach (array('documento_enviado', 'file_adjunto') as $campo) {
        $n = trim((string) ($row[$campo] ?? ''));
        if ($n !== '') {
            $nombres[] = $n;
        }
    }
    if ($exp !== '') {
        $nombres[] = 'TRAM_' . $exp . '.pdf';
    }

    try {
        $dir = u_file_carpeta('pdf', null, false);
    } catch (Throwable $e) {
        $dir = null;
    }
    if ($dir !== null) {
        $patrones = [];
        if ($cc > 0) {
            $patrones[] = $cc . '_*.pdf';
        }
        if ($exp !== '') {
            $patrones[] = 'TRAM_' . $exp . '*.pdf';
        }
        foreach ($patrones as $patron) {
            $buscados[] = $patron;
            $hallados = glob($dir . $patron);
            if ($hallados) {
                usort($hallados, function ($a, $b) {
                    return filemtime($b) - filemtime($a);
                });
                foreach ($hallados as $h) {
                    $nombres[] = basename($h);
                }
            }
        }
    }

    foreach (array_unique($nombres) as $nombre) {
        if (strtolower(substr($nombre, -4)) !== '.pdf') {
            continue;
        }
        $buscados[] = $nombre;
        try {
            if (u_file_ruta('pdf', $nombre) !== null) {
                return u_file_url('pdf', $nombre);
            }
        } catch (Throwable $e) {
        }
    }
    return null;
}

/* ---------------------------------------------------------------------------
 * Repositorio del colegiado: fotos (<num_documento>.jpg|.png) y fichas (<cep>.pdf).
 * Lo usan comun/api_foto.php y comun/api_ficha.php.
 * ------------------------------------------------------------------------- */

/**
 * Normaliza y valida un identificador (DNI, CE, CEP): solo letras y números, 4 a 15 caracteres.
 * Devuelve el id en mayúsculas o '' si no es válido. Evita que se pida otro archivo del servidor.
 */
function u_file_id_valido($id)
{
    $id = strtoupper(trim((string) $id));
    return preg_match('/^[A-Z0-9]{4,15}$/', $id) === 1 ? $id : '';
}

/**
 * Nombre del archivo de foto del colegiado que existe en el repositorio (.jpg primero, luego .png),
 * o null si no hay foto o la carpeta no está configurada.
 */
function u_file_foto_colegiado_nombre($num_documento)
{
    $id = u_file_id_valido($num_documento);
    if ($id === '') {
        return null;
    }
    foreach (array('jpg', 'png') as $ext) {
        try {
            if (u_file_ruta('foto_colegiado', $id . '.' . $ext) !== null) {
                return $id . '.' . $ext;
            }
        } catch (Throwable $e) {
            return null;
        }
    }
    return null;
}

/**
 * Valida un número de CEP: solo dígitos, 1 a 8. Devuelve el CEP sin espacios o '' si no es válido.
 */
function u_file_cep_valido($cep)
{
    $cep = trim((string) $cep);
    return preg_match('/^[0-9]{1,8}$/', $cep) === 1 ? $cep : '';
}

/**
 * Nombre de la ficha (<cep>.pdf) que existe en el repositorio, o null.
 * Prueba el CEP tal como llega, con 6 dígitos (025412) y sin ceros a la izquierda (25412),
 * porque el CEP se guarda y se escribe de las dos formas.
 */
function u_file_ficha_colegiado_nombre($cep)
{
    $cep = u_file_cep_valido($cep);
    if ($cep === '') {
        return null;
    }
    $sin_ceros = ltrim($cep, '0');
    $candidatos = array_unique(array($cep, str_pad($sin_ceros, 6, '0', STR_PAD_LEFT), $sin_ceros));
    foreach ($candidatos as $c) {
        if ($c === '') {
            continue;
        }
        try {
            if (u_file_ruta('ficha_colegiado', $c . '.pdf') !== null) {
                return $c . '.pdf';
            }
        } catch (Throwable $e) {
            return null;
        }
    }
    return null;
}

/* ---------------------------------------------------------------------------
 * Certificados de capacitación (cap_eventos.img_asistente / img_ponente)
 * ------------------------------------------------------------------------- */

/** Nombre de imagen de certificado válido (sin rutas): letras, números, _ - . y extensión permitida; '' si no. */
function u_file_certificado_nombre_valido($nombre)
{
    $nombre = trim((string) $nombre);
    if ($nombre === '' || strtoupper($nombre) === 'NULL' || preg_match('/^[A-Za-z0-9_\-]+\.(jpg|jpeg|png)$/i', $nombre) !== 1) {
        return '';
    }
    return $nombre;
}

/**
 * Dónde está el archivo: array('carpeta' => null|'capacitacion/img') o null si no existe.
 * Primero el repositorio (CERTIFICADOS_DIR); si no está, la carpeta antigua capacitacion/img del proyecto.
 */
function u_file_certificado_ubicar($nombre)
{
    $nombre = u_file_certificado_nombre_valido($nombre);
    if ($nombre === '') {
        return null;
    }
    $opciones = array(null);
    if (trim((string) CERTIFICADOS_DIR) !== '') {
        $opciones[] = 'capacitacion/img';
    }
    foreach ($opciones as $carpeta) {
        try {
            if (u_file_ruta('certificado', $nombre, $carpeta) !== null) {
                return array('carpeta' => $carpeta);
            }
        } catch (Throwable $e) {
        }
    }
    return null;
}

/** URL para <img src> o para ver el certificado. '' si el nombre no es válido. */
function u_file_certificado_url($nombre)
{
    $nombre = u_file_certificado_nombre_valido($nombre);
    return $nombre === '' ? '' : u_file_url('certificado', $nombre);
}

/**
 * Sistemas externos autorizados a pedir archivos con enlace firmado.
 * Se leen de util/api_clientes.php (NO versionado; ver util/api_clientes.ejemplo.php):
 *   return array('portal' => array('clave' => '<64 hex>', 'tipos' => array('foto', 'ficha')), ...);
 */
function u_file_api_clientes()
{
    static $clientes = null;
    if ($clientes === null) {
        $archivo = __DIR__ . '/api_clientes.php';
        $clientes = is_file($archivo) ? include $archivo : array();
        if (!is_array($clientes)) {
            $clientes = array();
        }
    }
    return $clientes;
}

/** Firma HMAC-SHA256 de un enlace. Los otros sistemas deben calcularla exactamente igual. */
function u_file_api_firma($clave, $cliente, $tipo, $id, $vence)
{
    return hash_hmac('sha256', $cliente . '|' . $tipo . '|' . $id . '|' . (int) $vence, (string) $clave);
}

/**
 * Valida un enlace firmado (?c=<cliente>&id=<id>&e=<vence unix>&s=<firma>) para el $tipo
 * ('foto', 'ficha' o 'certificado'). Devuelve el id normalizado; lanza Exception si no es válido.
 */
function u_file_api_verificar($tipo)
{
    $cliente = isset($_GET['c']) ? (string) $_GET['c'] : '';
    $id      = u_file_id_valido(isset($_GET['id']) ? $_GET['id'] : '');
    $vence   = isset($_GET['e']) ? (int) $_GET['e'] : 0;
    $firma   = isset($_GET['s']) ? strtolower((string) $_GET['s']) : '';

    $clientes = u_file_api_clientes();
    if ($cliente === '' || !isset($clientes[$cliente]) || !is_array($clientes[$cliente])) {
        throw new Exception("Acceso no autorizado.");
    }
    $conf  = $clientes[$cliente];
    $clave = isset($conf['clave']) ? (string) $conf['clave'] : '';
    $tipos = isset($conf['tipos']) && is_array($conf['tipos']) ? $conf['tipos'] : array();
    if (strlen($clave) < 32 || !in_array($tipo, $tipos, true)) {
        throw new Exception("Acceso no autorizado.");
    }
    $ahora = time();
    if ($id === '' || $vence < $ahora || $vence > $ahora + U_FILE_API_MAX_SEG) {
        throw new Exception("Enlace no válido o vencido.");
    }
    if (!hash_equals(u_file_api_firma($clave, $cliente, $tipo, $id, $vence), $firma)) {
        throw new Exception("Acceso no autorizado.");
    }
    return $id;
}

