<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . "/util/numeroLetra.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
   require_once(u_src() . "bo/bo_prestamos_socios.php");
    require_once(u_src() . "bo/bo_detalle_prestamos_socios.php");
    require_once(u_src() . "bo/bo_general.php");
    require_once(u_src() . "bo/bo_gen_personas.php");
 

    $bo_personas = new bo_gen_personas();

    $ent_personas = new gen_personas();
    $bo_general = new bo_general();

    $bo = new bo_prestamos_socios();
    $ent = new prestamos_socios();

    $bo_de = new bo_detalle_prestamos_socios();
    $ent_de = new detalle_prestamos_socios();

$cc_fraccionamiento = s_crypt($_REQUEST['cc_fraccionamiento'], 'out');
$ent->setCc_fraccionamiento($cc_fraccionamiento);
 

$cab = $bo->listarID($ent);
foreach ($cab as $cab) {
    $c_local = $cab['c_local'];
    $cc_fraccionamiento = $cab['cc_fraccionamiento'];
     $nombre = $cab['nombre'];
    $c_cmp = $cab['c_cmp'];
    $fecha_texto = $cab['fecha_texto'];
    $flag_text = $cab['flag_text'];
    $flag = $cab['flag'];
    $nombre_local = $cab['nombre_local'];
        $cod_documento = $cab['cod_documento'];
        $num_documento = $cab['num_documento'];
          $capital = $cab['capital'];
            $num_cuotas = $cab['num_cuotas'];
}
$ent_de->setCc_fraccionamiento($cc_fraccionamiento);
$data_detalle =  $bo_de->ListarId($ent_de);

 
 
ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'fracc_print_plantilla.php';
$template = ob_get_clean();

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set([
    'isRemoteEnabled' => true,
    'defaultFont' => 'Arial'
]);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($template);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream(
    sprintf('%s %s-%s', $nombre_documento, $ruc_local, $full_documento),
    ["Attachment" => false]
);
