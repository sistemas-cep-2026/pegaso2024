<?php

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");

require_once(u_src() . "bo/bo_tram_documentos_enviados_destinos.php");

$bo_general = new bo_general();

$bo_documentos_dest = new bo_tram_documentos_enviados_destinos();
$ent_documentos_dest = new tram_documentos_enviados_destinos();

try {

    $opcd = s_crypt($_REQUEST['opcd'] ?? '', 'out');
    $cc_docenviado_det = !empty($_REQUEST['cc_docenviado_det']) ? s_crypt($_REQUEST['cc_docenviado_det'], 'out') : '';
    $cc_docenviado = !empty($_REQUEST['cc_docenviado']) ? s_crypt($_REQUEST['cc_docenviado'], 'out') : '';
    $cargo = !empty($_REQUEST['cargo'])  ? $_REQUEST['cargo']  : '';
  

    $ent_documentos_dest->setCc_docenviado_det($cc_docenviado_det);
    $ent_documentos_dest->setCc_docenviado($cc_docenviado);
        $ent_documentos_dest->setCargo($cargo);
    $ent_documentos_dest->setC_persona(s_crypt($_REQUEST['c_persona'] ?? '...', 'out'));
    $ent_documentos_dest->setOpcd($opcd);

    $val = $bo_documentos_dest->control($ent_documentos_dest,$opcd);

   if (!$val) {
        throw new Exception($bo_documentos_dest->errores());
    }
         

    echo '0';
} catch (Exception $e) {

    echo $e->getMessage();
}