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

/* ---------------------------------------------------------------------------
 * Rutas
 * ------------------------------------------------------------------------- */

/**
 * Valida una carpeta RELATIVA a la raíz del proyecto: sin "..", sin unidad (C:) ni rutas absolutas.
 * Devuelve la ruta normalizada con "/" y sin barras en los extremos.
 */
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

/**
 * Valida una carpeta ABSOLUTA: unidad de Windows ("D:/file_tramites") o ruta Unix ("/mnt/archivos").
 * Rechaza "..", rutas de red (\\servidor\...) y unidades de Windows si el servidor no es Windows
 * (en Linux "D:/x" sería una carpeta relativa llamada "D:"). Devuelve la ruta con "/" y sin barra final.
 * $es_windows solo se pasa en pruebas; por defecto se detecta con DIRECTORY_SEPARATOR.
 */
function u_file_ruta_absoluta_valida($ruta, $es_windows = null)
{
    if ($es_windows === null) {
        $es_windows = (DIRECTORY_SEPARATOR === '\\');
    }
    $ruta = rtrim(str_replace('\\', '/', trim((string) $ruta)), '/');
    if ($ruta === '' || strpos($ruta, '..') !== false || strpos($ruta, "\0") !== false || strpos($ruta, '//') === 0) {
        throw new Exception("Carpeta de archivos no válida.");
    }
    $es_unidad = (preg_match('#^[A-Za-z]:/[^/]#', $ruta) === 1);
    $es_unix   = (strlen($ruta) > 1 && $ruta[0] === '/');
    if (($es_unidad && !$es_windows) || (!$es_unidad && !$es_unix) || ($es_unix && $es_windows)) {
        throw new Exception("Carpeta de archivos no válida: la ruta no corresponde a este servidor.");
    }
    return $ruta;
}

/**
 * Ruta absoluta (con separador final) de la carpeta del perfil $tipo.
 * Si no existe la crea (salvo $crear = false, en cuyo caso devuelve null).
 * La raíz es la carpeta que contiene util/ (igual que u_src()).
 */
function u_file_carpeta($tipo, $carpeta = null, $crear = true)
{
    $p = u_file_perfil($tipo);
    $explicita = ($carpeta !== null && $carpeta !== '');
    $base_abs  = $explicita ? '' : trim((string) $p['ruta_base']);

    if ($base_abs !== '') {
        // Carpeta ABSOLUTA fuera del proyecto (ej. D:/file_tramites). Se crea solo el último nivel:
        // si la unidad no existe, mkdir falla y no se escribe en otro lugar.
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
        // Ruta absoluta: sin crear niveles intermedios (recursivo solo dentro del proyecto)
        if (!@mkdir($destino, 0775, $base_abs === '') && !is_dir($destino)) {
            error_log("config_file: no se pudo crear la carpeta " . $destino);
            throw new Exception("No se pudo crear la carpeta de archivos.");
        }
    }
    // realpath solo funciona con carpetas que existen: por eso se resuelve DESPUÉS de crearla
    $real = realpath($destino);
    if ($real === false) {
        throw new Exception("No se pudo resolver la carpeta de archivos.");
    }
    // El permiso de escritura solo importa al GUARDAR; para leer/mostrar un PDF basta con poder leer la carpeta.
    if ($crear && !is_writable($real)) {
        error_log("config_file: sin permiso de escritura en " . $real);
        throw new Exception("La carpeta de archivos no tiene permiso de escritura.");
    }
    return $real . DIRECTORY_SEPARATOR;
}

/** Deja solo letras, números, guion y guion bajo (el nombre final lo vuelve a sanear Upload). */
function u_file_nombre_seguro($texto)
{
    return preg_replace('/[^A-Za-z0-9_\-]/', '', (string) $texto);
}

/* ---------------------------------------------------------------------------
 * Validación
 * ------------------------------------------------------------------------- */

/** Tipo MIME real del archivo (por su contenido). Cadena vacía si no se pudo detectar. */
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

/**
 * Valida un elemento de $_FILES contra el perfil $tipo: errores de PHP, vacío, tamaño,
 * extensión y contenido real (MIME; en imágenes además que sea una imagen legible).
 * Devuelve array('ext' =>, 'mime' =>, 'size' =>, 'nombre_original' =>) o lanza Exception.
 */
function u_file_validar($archivo, $tipo)
{
    $p = u_file_perfil($tipo);

    if (!is_array($archivo) || !isset($archivo['error'], $archivo['tmp_name'], $archivo['name'], $archivo['size'])
        || is_array($archivo['error']) || is_array($archivo['name'])) {
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

/**
 * Valida y guarda el archivo $archivo (elemento de $_FILES) según el perfil $tipo.
 * Devuelve el NOMBRE FINAL del archivo (solo nombre, sin ruta), listo para guardar en la BD.
 *
 * $nombre_base  nombre sin extensión que quiere el módulo (ej.: 'TRAM_28070010499'). La extensión
 *               la pone el sistema. Si ya existe un archivo con ese nombre y el perfil no
 *               sobrescribe, se agrega _1, _2, ...
 * $opciones     (todas opcionales)
 *   'carpeta'       carpeta relativa distinta a la del perfil (obligatoria si el perfil no tiene)
 *   'sobrescribir'  true/false para cambiar lo que dice el perfil
 *   'max_nombre'    largo máximo del nombre final, p. ej. 30 si se guarda en un varchar(30);
 *                   si no cabe, el archivo no se guarda y se lanza Exception
 */
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

    // Con _1, _2... el nombre puede crecer: si ya no cabe se descarta el archivo
    if ($max_nombre > 0 && strlen($nombre_final) > $max_nombre) {
        @unlink($carpeta . $nombre_final);
        throw new Exception("El nombre del archivo generado supera los " . $max_nombre . " caracteres.");
    }

    return $nombre_final;
}

/**
 * Elimina del servidor el archivo $nombre de la carpeta del perfil $tipo.
 * Solo acepta un nombre simple (sin rutas) con una extensión permitida por el perfil,
 * así que no puede borrar scripts ni salir de la carpeta.
 * Devuelve true si lo eliminó, false si no existía. Lanza Exception si no pudo borrarlo.
 */
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

/**
 * Ruta absoluta de un archivo YA guardado, o null si no existe. Solo acepta un nombre simple
 * (sin rutas) con una extensión permitida por el perfil, así que no puede salir de la carpeta
 * ni apuntar a un script. Lanza Exception si el nombre es vacío o no corresponde al tipo.
 */
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
 * ENVÍA el archivo al navegador (para carpetas no públicas como D:/file_tramites). Es la única
 * función de este archivo que escribe salida; úsela en un script que ya validó la sesión con
 * s_validar_pagina(), como tramite/exp_file_ver.php. No envía nada si el archivo no existe o su
 * contenido real no es del tipo del perfil: en esos casos lanza Exception antes de escribir cabeceras.
 */
function u_file_servir($tipo, $nombre, $descargar = false)
{
    $p = u_file_perfil($tipo);
    $ruta = u_file_ruta($tipo, $nombre);
    if ($ruta === null) {
        throw new Exception("El archivo no existe.");
    }
    $mime = u_file_detectar_mime($ruta);
    if ($mime === '' && $tipo === 'pdf') {
        // Sin la extensión fileinfo de PHP: se comprueba la firma del PDF ("%PDF-" al inicio)
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

    // Libera el bloqueo de la sesión: un PDF grande no debe frenar otras pantallas del mismo usuario
    if (function_exists('session_status') && session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }
    // Todo lo que se haya escrito antes (espacios de un include, avisos de PHP) se descarta: un solo byte
    // extra antes del "%PDF" hace que el visor del navegador diga que el PDF está dañado.
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    // Sin compresión: Content-Length debe coincidir con los bytes enviados
    @ini_set('zlib.output_compression', '0');
    if (function_exists('apache_setenv')) {
        @apache_setenv('no-gzip', '1');
    }
    // Cabeceras que deja la sesión/config del sistema (no-store, Pragma, Expires) y que confunden al visor de PDF
    header_remove('Pragma');
    header_remove('Expires');

    $nombre_visible = preg_replace('/[^A-Za-z0-9_.\-]/', '_', basename($ruta));
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . $tam);
    header('Content-Disposition: ' . ($descargar ? 'attachment' : 'inline') . '; filename="' . $nombre_visible . '"');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Accept-Ranges: none');

    $fh = @fopen($ruta, 'rb');
    if ($fh === false) {
        // las cabeceras ya salieron: se corta sin escribir texto dentro del PDF
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
