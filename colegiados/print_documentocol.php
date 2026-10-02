<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_web_tram_colegiacion.php");
require_once(u_src() . "bo/bo_general.php");
require_once u_src() . 'bo/bo_web_tram_colegiacion_doc.php';

$c_persona = $_REQUEST["c_persona"];
$cep = $_REQUEST["cep"] ?? $c_persona;

$bo_colegiado = new bo_web_tram_colegiacion();
$bo_general = new bo_general();
$bo_colegiacion_doc = new bo_web_tram_colegiacion_doc();

$ent_colegiado = new web_tram_colegiacion();
$ent_colegiado_doc = new web_tram_colegiacion_doc();

$ent_colegiado->setNum_documento($c_persona);
$dato_personales = $bo_colegiado->reportFicha($ent_colegiado);

foreach ($dato_personales as $row) {
    $region = $row["c_region"];
    $cod_doc = $row["cod_documento"];
    $num_documento = $row["num_documento"];
    $lugar = $row["distrito_region"];

    $ent_colegiado->setC_persona($row["c_persona"]);
    $ent_colegiado->setCol_fecha($row["col_fecha"]);
    $ent_colegiado->setNombre1($row["nombres"]);
    $ent_colegiado->setCod_documento($row["cod_documentocod"]);
    $ent_colegiado->setNum_documento($row["num_documento"]);
    $ent_colegiado->setC_pais($row["pais_nacim"]);
    $ent_colegiado->setEmail($row["Email"]);
    $ent_colegiado->setCelular($row["celular"]);
    $ent_colegiado->setGenero($row["genero_text"]);
    $ent_colegiado->setFecha_de_nacimiento($row["fec_nac"]);
    $ent_colegiado->setUbigeonac($row["lugar_nacimiento"]);
    $ent_colegiado->setEstado_civil($row["estado_civil_text"]);
    $ent_colegiado->setGrupo_sanguineo($row["sangre"]);
    $ent_colegiado->setUbigeodirec($row["lugar_direccion"]);
    $ent_colegiado->setDireccion($row["direccion"]);
    $ent_colegiado->setProf_titulo($row["prof_titulo"]);
    $ent_colegiado->setProf_fecha($row["fec_titulo"]);
    $ent_colegiado->setProf_c_universidad($row["univ_lic"]);
    $ent_colegiado->setProf_c_pais($row["pais_univ_lic"]);
    $ent_colegiado->setProf_sunedu($row["prof_sunedu"]);
    $ent_colegiado->setBach_c_universidad($row["univ_bach"]);
    $ent_colegiado->setBach_fecha($row["fec_bach"]);
    $ent_colegiado->setBach_c_pais($row["pais_uni_bach"]);
    $ent_colegiado->setBach_forma($row["bach_forma"]);
    $ent_colegiado->setBach_nombre($row["bach_nombre"]);
    $ent_colegiado->setProf_modingreso($row["prof_modingreso"]);
    $ent_colegiado->setProf_sede($row["prof_sede"]);
    $ent_colegiado->setProf_duracion($row["prof_duracion"]);
    $ent_colegiado->setProf_exa_suf($row["prof_exa_suf"]);
}

$urlfoto = "https://www.cep.org.pe/colegiacion/imag/fotos/";
//echo $urlfoto . rtrim($num_documento) . ".jpg";
$foto = $urlfoto . rtrim($num_documento) . ".jpg";
// ob_start();
require_once 'print_documentocol_plantilla.php';
/* $template = ob_get_clean();
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

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
    $num_documento,
    ["Attachment" => false]
);
 */