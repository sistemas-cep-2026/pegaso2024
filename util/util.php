<?php
function u_estado($text, $color = 'primary')
{
    echo '<span class="badge bg-' . $color . '">' . $text . '</span>';
}

function u_estadoico($flag)
{
    if ($flag == "A") {
        echo "<i class='fas fa-check-circle' style='color:#198754'></i>";
    } else {
        echo "<i class='fas fa-eye-slash' style='color:#dc3545'></i>";
    }
}
function u_flacActividad($ejecucion)
{
    if ($ejecucion == "S") {
        echo '<svg  width="16" height="16" fill="green" class="bi bi-circle-fill" viewBox="0 0 16 16">
        <circle cx="8" cy="8" r="8"/>
        </svg>';
    } elseif ($ejecucion == "N") {
        echo '<svg  width="16" height="16" fill="red" class="bi bi-circle-fill" viewBox="0 0 16 16">
        <circle cx="8" cy="8" r="8"/>
        </svg>';
    } else {
        echo '<svg  width="16" height="16" fill="gray" class="bi bi-circle-fill" viewBox="0 0 16 16">
        <circle cx="8" cy="8" r="8"/>
        </svg>';
    }
}

function u_meses()
{
    $data = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Setiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
    return $data;
}

function u_meses_iniciales()
{
    $data = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4" => "Abr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Ago", "9" => "Set", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    return $data;
}

function u_meses_contable()
{
    $data = array("00" => "Apertura", "01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Setiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre", "13" => "13", "14" => "14");
    return $data;
}

function tipo_cliente()/*PARA BUSCAR AL CLIENTE*/
{
    $data = array("C" => "COLEGIADO", "E" => "RAZON SOCIAL");
    return $data;
}


function u_local_defecto_selec($cc_local)
{

    if ($cc_local == s_local_vinculado()) {
        echo " selected ";
    }
}

function tipo_reten()
{
    $data = array("D" => "DETRACCIÓN", "R" => "RETENCIÓN");
    return $data;
}

function procentaje()
{
    $data = array("0" => "0%", "4" => "4%", "5" => "5%", "8" => "8%", "10" => "10%", "12" => "12%", "14" => "14%");
    return $data;
}
function procentaje_retenc()
{
    $data = array("0" => "0%", "3" => "3%", "8" => "8%");
    return $data;
}

function u_img()
{
    return '../images/';
}

function u_src()
{
    return dirname(__DIR__) . '/src/'; //"../src/";
}

function u_ascui($String)
{
    $String = str_replace(array('�', '?', '�', '?', '?', '�'), "a", $String);
    $String = str_replace(array('�', '?', '�', '?', '�'), "A", $String);
    $String = str_replace(array('�', '?', '�', '?'), "I", $String);
    $String = str_replace(array('�', '?', '�', '?'), "i", $String);
    $String = str_replace(array('�', '?', '?', '�'), "e", $String);
    $String = str_replace(array('�', '?', '?', '�'), "E", $String);
    $String = str_replace(array('�', '?', '�', '?', '�', '?'), "o", $String);
    $String = str_replace(array('�', '?', '�', '?', '�'), "O", $String);
    $String = str_replace(array('�', '?', '?', '�'), "u", $String);
    $String = str_replace(array('�', '?', '?', '�'), "U", $String);
    $String = str_replace(array('[', '^', '�', '`', '�', '~', ']'), "", $String);
    $String = str_replace("�", "c", $String);
    $String = str_replace("�", "C", $String);
    $String = str_replace("?", "n", $String);
    $String = str_replace("?", "N", $String);
    $String = str_replace("�", "Y", $String);
    $String = str_replace("�", "y", $String);
    return utf8_decode($String);
}
function errors($text = "Búsqueda sin éxito", $type = "danger")
{
    $msj = '<div class="alert alert-' . $type . ' alert-border-left mt-1 fade show material-shadow" role="alert"><div class="alert-body"><div class="d-flex"><div class="flex-shrink-0 align-middle me-3"><i class="ri-error-warning-line fa-2x align-middle"></i></div><div class="flex-grow-1"><h5 class="alert-heading">Mensaje!</h5><p class="mb-0">' . $text . '</p></div></div></div></div>';

    return $msj;
}
function u_tildesHtml($cadena)
{
    return str_replace(
        array(
            "&aacute;",
            "&eacute;",
            "&iacute;",
            "&oacute;",
            "&uacute;",
            "&ntilde;",
            "&Aacute;",
            "&Eacute;",
            "&Iacute;",
            "&Oacute;",
            "&Uacute;",
            "&Ntilde;"
        ),
        array("á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ"),
        $cadena
    );
}
function parsear($property)
{
    $property = trim($property);
    $property = stripslashes($property);
    $property = htmlspecialchars($property);
    return $property;
}

function u_fecha($fecha)
{
    if (empty($fecha)) return '';
    $fechaFormato = date("d/m/Y", strtotime($fecha));
    return $fechaFormato;
}

function u_fechaFormato($fecha, $formato = 'd/m/Y')
{
    return date($formato, strtotime($fecha));
}

function u_fecha_hora($fecha)
{
    $fechaFormato = date("d/m/Y H:i:s", strtotime($fecha));
    return $fechaFormato;
}

function fecha_hora_hoy()
{
    return $fecha_hora = date('d/m/Y G:i:s');
}
function sistema_vesion()
{
    return $sistema_ver = 'Sistema Informático Institucional - ERP PEGASO - Ver. 3.01';
}
function segundos_tiempo($segundos)
{
    $minutos = $segundos / 60;
    $horas = floor($minutos / 60);
    $minutos2 = $minutos % 60;
    $segundos_2 = $segundos % 60 % 60 % 60;
    if ($minutos2 < 10)
        $minutos2 = '0' . $minutos2;

    if ($segundos_2 < 10)
        $segundos_2 = '0' . $segundos_2;

    if ($segundos < 60) { /* segundos */
        $resultado = round($segundos) . ' Segundos';
    } elseif ($segundos > 60 && $segundos < 3600) { /* minutos */
        $resultado = $minutos2
            . ':'
            . $segundos_2
            . ' Minutos';
    } else { /* horas */
        $resultado = $horas . ':' . $minutos2 . ':' . $segundos_2 . ' Horas';
    }
    return $resultado;
}


function decimal(?float $total, int $digito): string
{
    $total = $total ?? 0.0;
    return number_format($total, $digito, '.', ',');
}

function decimal_millar(?float $total, int $digito): string
{
    $total = $total ?? 0.0;
    return number_format($total, $digito, '.', ',');
}


function digitos($number, $n)
{
    return str_pad((string) intval($number), $n, '0', STR_PAD_LEFT);
}

function bt_insertar($text = "Insertar", $callback_js = '')
{
    echo '<button class="btn btn-outline-success waves-effect" onclick="fn_nuevo_detalle()" type="button" ' . $callback_js . '>
    <i class="fas fa-sd-card"></i>
    <span>' . $text . '</span>
    </button>';
}

function bt_cancelar($text = "Cancelar", $callback_js = '')
{
    echo '<button class="btn btn-outline-warning waves-effect" type="reset" ' . $callback_js . '>
    <i class="fas fa-ban"></i>
    <span>' . $text . '</span>
    </button>';
}


function bt_buscar($text = "Buscar", $callback_js = '')
{
    echo '<button type="submit" class="btn btn-outline-info waves-effect" ' . $callback_js . '>
    <i class="fas fa-search"></i>
    <span>' . $text . '</span>
    </button>';
}

function bt_nuevo($text = "Nuevo", $callback_js = '')
{
    echo '
    <button class="btn btn-outline-warning waves-effect" type="button" ' . $callback_js . '>
    <i class="fas fa-file"></i>
    <span>' . $text . '</span>
    </button>';
}

function bt_cerrar($text = "Cerrar", $callback_js = '')
{
    echo '<button type="button" class="btn btn-outline-warning waves-effect " data-bs-dismiss="modal" ' . $callback_js . '>
    <i class="fas fa-times"></i>
    <span>' . $text . '</span>
    </button>';
}

function bt_guardar($text = "Guardar", $disabled = "", $btn = "")
{
    echo '<button type="submit" class="btn btn-outline-primary waves-effect ' . $btn . '" ' . $disabled . ' title="Guardar">
    <i class="fas fa-save"></i>
    <span>' . $text . '</span>
    </button>';
}

function bt_volver($text = "Volver")
{ //correcto
    echo '<a href="javascript: history.go(-1)" class="btn btn-outline-success waves-effect"> 
    <i class="fas fa-reply-all"></i>
    <span>' . $text . '</span>
    </a>';
}
function bt_imprimirDiv($text = "Imprimir")
{
    echo '<button onclick="imprimirDiv()"class="btn btn-success bg-gradient waves-effect waves-light"><i class="fas fa-print"></i> Imprimir</button>';
}

function bt_filtrar($text = "Buscar")
{
    echo '<button type="submit" class="btn btn-primary"> <i class="fas fa-filter"></i>
    ' . $text . '
    </button>';
}

function reArrayFiles(&$file_post)
{

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function delete_file($filename)
{
    if (file_exists($filename)) {
        unlink($filename);
    }
    return TRUE;
}

function importDatatable()
{
    return '<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>';
}

function importTypeahead()
{
    return '
    <link rel="stylesheet" href="' . url('bootstrap/assets/libs/typeahead/typeahead.jquery.min.css') . '">
    <script src="' . url('bootstrap/assets/libs/typeahead/typeahead.jquery.min.js') . '"></script>
    <script src="' . url('bootstrap/assets/libs/typeahead/bloodhound.min.js') . '"></script>
    <script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>';
}

function importSelect2()
{
    return '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
}

function importInputMask()
{
    return '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js" integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
}

/*function importToolTip()
{
    return '<script>var tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle="tooltip"]`);var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));</script>';
}*/
function importToolTip()
{
    return '
    <script> window.initTooltips = function(root){
        try {
          var scope = root || document;
          var els = scope.querySelectorAll("[data-bs-toggle=\'tooltip\']");
          els.forEach(function(el){
            var inst = bootstrap.Tooltip.getInstance(el);
            if (inst) inst.dispose();
            new bootstrap.Tooltip(el);
          });
        } catch (e) {
          console.warn("initTooltips error:", e);
        }
      };
      document.addEventListener("DOMContentLoaded", function(){
        window.initTooltips(document);
      });
    </script>';
}


function importDropZoneJs()
{
    return '
    <link rel="stylesheet" href="' . url('bootstrap/assets/libs/dropzone/dropzone.css') . '">
    <script src="' . url('bootstrap/assets/libs/dropzone/dropzone-min.js') . '"></script>';
}

function importChartJs()
{
    return '<script src="' . url('bootstrap/assets/libs/chart.js/chart.umd.js') . '"></script>';
}

function importMomentJs()
{
    return '<script src="' . url('bootstrap/assets/libs/moment/moment.js') . '"></script>';
}

function importChoices()
{
    return '<script src="' . url('bootstrap/assets/libs/choices.js/public/assets/scripts/choices.min.js') . '"></script>';
}

function importformmasks()
{
    return '<script src="' . url('bootstrap/assets/libs/cleave.js/cleave.min.js') . '"></script>';
}

function importDatePicker()
{
    return '<script src="' . url('bootstrap/assets/libs/flatpickr/flatpickr.min.js') . '"></script>
            <script src="' . url('bootstrap/assets/libs/flatpickr/l10n/es.js') . '"></script>
            <script src="' . url('bootstrap/assets/libs/flatpickr/plugins/rangePlugin.js') . '"></script>';
}

function importapexcharts()
{
    return '<script src="' . url('bootstrap/assets/libs/apexcharts/apexcharts.min.js') . '"></script>';
}

function input_checkbox($text, $name, $value = '', $cheked = '', $id = '')
{
    $_id = empty($id) ? $name : $id;
    echo '<div class="form-check form-switch form-switch-md form-check-inline" dir="ltr">
    <input class="form-check-input" type="checkbox" role="switch" name="' . $name . '" id="' . $_id . '" value="' . $value . '" ' . $cheked . '>
    <label class="form-check-label" for="' . $_id . '">' . $text . '</label></div>';
}

function fecha_hoy()
{
    return date("Y-m-d");
}

function SumarMeses($mes)
{
    $nuevafecha = date("Y-m-d", strtotime(date("Y-m") . "+ " . $mes . " month"));
    return $nuevafecha;
}

function sumardias($dias)
{
    $fecha = date('Y-m-d');
    $nuevafecha = strtotime('+' . $dias . ' day', strtotime($fecha));
    $nuevafecha = date('Y-m-d', $nuevafecha);
    return $nuevafecha;
}

function restarMeses($mes)
{
    $nuevafecha = date("Y-m-d", strtotime(date("Y-m") . "- " . $mes . " month"));
    return $nuevafecha;
}

function restarDias($dias)
{
    $fecha = date('Y-m-d');
    $nuevafecha = strtotime('-' . $dias . ' day', strtotime($fecha));
    $nuevafecha = date('Y-m-d', $nuevafecha);
    return $nuevafecha;
}

function fechatexto($fecha)
{
    $year = substr($fecha, 6, 10);
    $mon = substr($fecha, 3, 2);
    switch ($mon) {
        case "01":
            $month = "Enero";
            break;
        case "02":
            $month = "Febrero";
            break;
        case "03":
            $month = "Marzo";
            break;
        case "04":
            $month = "Abril";
            break;
        case "05":
            $month = "Mayo";
            break;
        case "06":
            $month = "Junio";
            break;
        case "07":
            $month = "Julio";
            break;
        case "08":
            $month = "Agosto";
            break;
        case "09":
            $month = "Septiembre";
            break;
        case "10":
            $month = "Octubre";
            break;
        case "11":
            $month = "Noviembre";
            break;
        case "12":
            $month = "Diciembre";
            break;
    }
    $day = substr($fecha, 0, 2);
    return $day . " de " . $month . " de " . $year;
}

function obtener_iniciales($str)
{
    $words = explode(' ', $str);
    $initials = '';
    $i = 1;
    foreach ($words as $w) {
        $initials .= strtoupper($w[0]); // Asegura que las iniciales sean mayúsculas
        if ($i === 2) break;
        $i++;
    }
    return $initials;
}

function diadesemana($fecha)
{
    $dias = array('', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
    $dia = $dias[date('N', strtotime($fecha))];
    echo $dia;
}


function compararFechas($fecha_registro)
{ /*cualcular dias para ocultar boton*/
    $timestamp_registro = strtotime($fecha_registro);
    $timestamp_actual = time();
    $diferencia_segundos = $timestamp_actual - $timestamp_registro;
    $diferencia_dias = floor($diferencia_segundos / (60 * 60 * 24));
    return $diferencia_dias;
}


function buscarFoto($num_documento)
{
    // Directorio base
    $directorio = "https://www.cep.org.pe/fotos/";

    $extensiones = ['jpg'];
    foreach ($extensiones as $extension) {
        $urlFoto = $directorio . $num_documento . '.' . $extension;
        $ch = curl_init($urlFoto);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return $urlFoto . '?v=' . time();
        }
    }
    return $directorio . "sinfoto.jpg?v=" . time();
}

/*colegiados*/
$color_flag_estado = [
    'F' => 'bg-danger',
    'R' => 'bg-danger',
    'I' => 'bg-danger',
    'X' => 'bg-danger',
    'D' => 'bg-danger',
    'V' => 'bg-warning',
    'A' => 'bg-success',
    'C' => 'bg-info',
    'B' => 'bg-secondary',
];
$color_flag_habil = [
    'I' => 'bg-warning',
    'H' => 'bg-success',
];

$color_flag_activo = [
    'A' => 'success',
    'I' => 'danger',
];
/*documentos contables A: Anulado, C: procesado y P:pendiente*/
$color_flag_cont = [
    'A' => 'bg-danger',
    'C' => 'bg-success',
    'I' => 'bg-success',
    'P' => 'bg-info',
    '&' => 'bg-info',
    '*' => 'bg-success',
];

$icon_flag = [
    'A' => 'fas fa-times-circle',
    'C' => 'fas fa-check-circle',
    'I' => 'fas fa-check-double',
    'P' => 'fas fa-clock',
    '&' => 'fas fa-hourglass-half',
    '*' => 'fas fa-clipboard-check',
];

/*==============fin======*/

$color_flag_listar = [
    'A' => 'danger',
    '*' => 'success',
    'V' => 'danger',
    'C' => 'success',
    '&' => 'success',
    'I' => 'success',
    'P' => 'info',
];

$color_flag_listar_caja = [
    'A' => 'danger',
    '*' => 'success',
    '&' => 'info'
];

function calcularDiferenciaHoras($horaInicio, $horaFinal)
{
    /**para asistencia*/
    // Convertir las horas a objetos DateTime
    $inicio = DateTime::createFromFormat('H:i', $horaInicio);
    $final = DateTime::createFromFormat('H:i', $horaFinal);
    if (!$inicio || !$final) {
        return "Formato de hora no válido";
    }
    $diferencia = $inicio->diff($final);
    return $diferencia->format('%h h %i m');
}

/*contabilidad*/
function ultimo_dia($mes, $anho)
{
    return date("d", (mktime(0, 0, 0, $mes + 1, 1, $anho) - 1));
}
function listarAnhos($inicio = 2000, $futuro = 0)
{
    $anioActual = date("Y");
    $anios = [];

    for ($anio = $inicio; $anio <= ($anioActual + $futuro); $anio++) {
        $anios[] = ['anho' => $anio];
    }
    usort($anios, function ($a, $b) {
        return $b['anho'] - $a['anho'];
    });

    return $anios;
}

function quitarComa($numero)
{
    return str_replace(',', '', $numero);
}

function recortarCadena($cadena, $caracter)
{
    return (strlen($cadena) > $caracter)
        ? substr($cadena, 0, $caracter) . '...'
        : $cadena;
}

function u_limpiarMonto($monto)
{
    return preg_replace('/[^\d.]/', '', $monto);
}

function u_limpiarCadena($texto)
{
    return preg_replace('/[^A-Za-z0-9]/', '', $texto);
}

function periodo_contable()
{
    $arr = array(
        '00' => "00",
        '01' => "01",
        '02' => "02",
        '03' => "03",
        '04' => "04",
        '05' => "05",
        '06' => "06",
        '07' => "07",
        '08' => "08",
        '09' => "09",
        '10' => "10",
        '11' => "11",
        '12' => "12",
        '13' => "13",
        '14' => "14"
    );
    return $arr;
}

function cargador()
{
    return '<div class="card" aria-hidden="true"><div class="card-body"><h5 class="card-title placeholder-glow"><span class="placeholder col-6"></span></h5><p class="card-text placeholder-glow"><span class="placeholder col-7"></span><span class="placeholder col-4"></span><span class="placeholder col-4"></span><span class="placeholder col-6"></span><span class="placeholder col-8"></span></p></div></div>';
}

function lista_tipo_documentos_archivos()
{ //tipo de pago de eventos
    return [
        'FOT' => 'Foto carnet',
        'DNI_C' => 'Documento de identidad (Cara)',
        'DNI_CC' => 'Documento de identidad (Contracara)',
        'TIT_C' => 'T&iacute;tulo profesional (Cara)',
        'TIT_CC' => 'T&iacute;tulo profesional (Contracara)',
        'VO' => 'Voucher - Cta. Recaudadora BCP (S/ 956.00)',
        'DJ' => 'Declaraci&oacute;n jurada',
        'SUN' => 'Registro de SUNEDU',
        'RE' => 'Resoluci&oacute;n Extranjeros SUNEDU',
        'DJCR' => 'Voucher Regional(S/ 330.00)',

        //'DJ01' => 'Voucher 01(Opcional)',
        //'DJ02' => 'Voucher 02(Opcional)',
        //'DJ03' => 'Voucher 03(Opcional)',

        'XRT_01' => 'COPIA CERTIFICADO DE ESTUDIOS 01',
        'XRT_02' => 'COPIA CERTIFICADO DE ESTUDIOS 02 (Opcional)',
        'XRT_03' => 'COPIA CERTIFICADO DE ESTUDIOS 03 (Opcional)',
        'XLL_01' => 'MALLA CURRICULAR 01',
        'XLL_02' => 'MALLA CURRICULAR 02 (Opcional)',
        'XLL_03' => 'MALLA CURRICULAR 03 (Opcional)',
        'XSTCIA' => 'CONSTANCIA DE INGRESO A UNIV.',
        'RE01' => 'REVALIDA TIT EXT01',
        'RE02' => 'REVALIDA TIT EXT02',
        'ODOC' => 'Otros Documentos'

    ];
}

function anulaRecibo(string $fechaDoc, ?DateTimeInterface $hoy = null): bool
{
    $hoy = $hoy
        ? DateTimeImmutable::createFromFormat('Y-m-d', $hoy->format('Y-m-d'))
        : new DateTimeImmutable('today');

    if (!$hoy) {
        return false;
    }

    $doc = DateTimeImmutable::createFromFormat('!d/m/Y', $fechaDoc);
    $errores = DateTimeImmutable::getLastErrors();

    if (!$doc || $errores['warning_count'] > 0 || $errores['error_count'] > 0) {
        return false;
    }

    $hoy = $hoy->setTime(0, 0, 0);
    $doc = $doc->setTime(0, 0, 0);

    $diaHoy = (int) $hoy->format('d');

    if ($diaHoy <= 15) {
        $primerDiaMesAnterior = $hoy->modify('first day of last month');
        if (!$primerDiaMesAnterior) {
            return false;
        }

        $inicio = $primerDiaMesAnterior
            ->setDate(
                (int) $primerDiaMesAnterior->format('Y'),
                (int) $primerDiaMesAnterior->format('m'),
                16
            )
            ->setTime(0, 0, 0);
    } else {
        $inicio = $hoy
            ->modify('first day of this month')
            ->setTime(0, 0, 0);
    }

    $fin = $hoy;

    return ($doc >= $inicio) && ($doc <= $fin);
}

function tipo_estudio() //ya esta en la tabla detalle 
{
    $tipo = [
        '2' => 'PRESENCIAL',
        '1' => 'SEMI PRESENCIAL',
        '3' => 'A DISTANCIA',
    ];
    return $tipo;
}

function grados_academicos($tipo)
{
    switch ($tipo) {
        case "E":
            $texto = "Especialidad";
            break;
        case "D":
            $texto = "Doctorado";
            break;
        case "M":
            $texto = "Maestr&iacute;a";
            break;
        case "A":
            $texto = "Auditor&iacute;a";
            break;
        case "P":
            $texto = "POS.DOCTORADO";
            break;
        case "N":
            $texto = "LACTANCIA";
            break;
        case "J":
            $texto = "CONCILIADOR EXTRAJUDICIAL";
            break;
    }
    return $texto;
}

function fechaPeriodoActual($anho, $mes)
{
    $diaHoy = date('d');
    $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $mes, $anho);

    if ($diaHoy > $ultimoDia) {
        $diaHoy = $ultimoDia;
    }
    return $anho . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . str_pad($diaHoy, 2, '0', STR_PAD_LEFT);
}


function essalud_y_recaudo($tipo, $valor)
{
    switch ($tipo) {
        case "Bcp66":
            switch ($valor) {
                case "0":
                    $texto = "*PEND.-CONCILIAR EECC*";
                    break;
                case "9":
                    $texto = "*CONCILIADO*";
                    break;
            }
            break;
        case "bbva571":
            switch ($valor) {
                case "0":
                    $texto = "*PEND.-CONCILIAR EECC*";
                    break;
                case "9":
                    $texto = "*CONCILIADO*";
                    break;
            }
            break;
        case "pla_ess":
            switch ($valor) {
                case "0":
                    $texto = "*PENDIENTE-CONCILIAR*";
                    break;
                case "1":
                    $texto = "*PENDIENTE-CAS*";
                    break;
                case "9":
                    $texto = "*CONCILIADO*";
                    break;
            }
            break;
    }
    return $texto;
}
