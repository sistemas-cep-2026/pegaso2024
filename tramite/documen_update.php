<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_enviados.php");
header('Content-type: application/json; charset=utf-8');

$bo_documentos = new bo_tram_documentos_enviados();
$ent_documentos = new tram_documentos_enviados();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_docenviado = s_crypt($_REQUEST["cc_docenviado"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $ent_documentos->setCc_docenviado($cc_docenviado);
    $ent_documentos->setC_tipo_de_documento($_REQUEST["c_tipo_de_documento"]);
    $ent_documentos->setGestion($_REQUEST["gestion"]);
    $ent_documentos->setFecha($_REQUEST["fecha"]);
    $ent_documentos->setAsunto($_REQUEST["asunto"]);
    $ent_documentos->setC_usuario(s_usuario());
    $ent_documentos->setC_local($_REQUEST["cc_local"]);
    $ent_documentos->setC_area_adm_usuario($_REQUEST["c_area_adm_usuario"]);
    $ent_documentos->setC_area_adm_doc($_REQUEST["c_area_adm_doc"]);
    $ent_documentos->setTipo_persona($_REQUEST["tipo_persona"]);
    $ent_documentos->setFlag($_REQUEST["flag"]);
    $ent_documentos->setOpc($opc);

    $val = $bo_documentos->ProcesarDocumentos($ent_documentos);
    if (!$val) {
        throw new Exception($bo_documentos->errores() ?: "Error desconocido");
    }

    if ($opc === 'I') {
        $cc_docenviado = $val['cc_docenviado'] ?? null;
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => '?id=' . s_crypt('400011', 'in') . '&cod=' . s_crypt($cc_docenviado) . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
