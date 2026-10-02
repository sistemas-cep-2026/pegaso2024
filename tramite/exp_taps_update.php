<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
header('Content-type: application/json; charset=utf-8');
// Inicialización de objetos
$bo_doc_recibidos = new bo_tram_documentos_recibidos();
$ent_doc_recibidos = new tram_documentos_recibidos();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_docrecibidos = s_crypt($_REQUEST["cc_docrecibidos"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    if ($opc === 'I') {
        $ent_doc_recibidos->setC_local($_REQUEST["c_local"] ?? '');

        $num_documento = u_limpiarCadena($_REQUEST["num_documento"] ?? '');

        $ent_doc_recibidos->setTokenumero($num_documento);

        if (!in_array(strtoupper(trim($num_documento)), ['SN', 'S/N'])) {
            $data_existe = $bo_doc_recibidos->validarExiste($ent_doc_recibidos);

            if (!empty($data_existe)) {
                throw new Exception(
                    'El Documento ' . $num_documento . ' ya existe'
                );
            }
        }
    }

    $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
    $ent_doc_recibidos->setC_tipo_de_documento($_REQUEST["c_tipo_de_documento"] ?? '');
    $ent_doc_recibidos->setNum_documento($_REQUEST["num_documento"] ?? '');
    $ent_doc_recibidos->setFecha_documento(u_fecha($_REQUEST["fecha_documento"] ?? ''));
    $ent_doc_recibidos->setC_persona(s_crypt($_REQUEST["c_persona"] ?? '', 'out'));
    $ent_doc_recibidos->setC_persona_pf(s_crypt($_REQUEST["c_persona_pf"] ?? '', 'out'));
    $ent_doc_recibidos->setAsunto($_REQUEST["asunto"] ?? '');
    $ent_doc_recibidos->setAsunto2($_REQUEST["asunto2"] ?? '');
    $ent_doc_recibidos->setC_local($_REQUEST["c_local"] ?? '');
    $ent_doc_recibidos->setC_usuario(s_usuario());
    $ent_doc_recibidos->setTipo_persona($_REQUEST["tipo_persona"] ?? '');
    $ent_doc_recibidos->setDestrinatario($_REQUEST["destinatario"] ?? '');
    $ent_doc_recibidos->setC_local_origen($_REQUEST["c_local_origen"] ?? '');
    $ent_doc_recibidos->setC_cargo($_REQUEST["c_cargo"] ?? '');
    $ent_doc_recibidos->setTokenumero(u_limpiarCadena($_REQUEST["num_documento"] ?? ''));
    $ent_doc_recibidos->setOpc($opc);


    $val = $bo_doc_recibidos->ProcesarDocumentosRecibidos($ent_doc_recibidos);
    if (!$val) {
        throw new Exception($bo_doc_recibidos->errores() ?: "Error desconocido");
    }

    if ($opc === 'I') {
        $cc_docrecibidos = $val['cc_docrecibidos'] ?? null;
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => '?id=' . s_crypt('400003', 'in') . '&cod=' . s_crypt($cc_docrecibidos) . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
