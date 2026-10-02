<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recaudo.php");

$bo_doc_recaudo = new bo_tram_documentos_recaudo();
$ent_doc_recaudo = new tram_documentos_recaudo();

$c_expediente = $_REQUEST["c_expediente"] ?? '';

$ent_doc_recaudo->setC_expediente($c_expediente);
$data_doc_pagos = $bo_doc_recaudo->listarXExpediente($ent_doc_recaudo);
?>
<div class="offcanvas-header">
    <h5 class="offcanvas-title">Agregar Pago</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="row">
        <div class="col-12">
            <input type="text" class="form-control" name="varbuscarcol" id="varbuscarcol" placeholder="Búsqueda por CEP o Apellidos">
        </div>
        <div class="col-12">
            <div id="divListarPagosRecaudoPersona"></div>
            
        </div>
    </div>
</div>
<script>
    var dataSetPersonas = newBloodhound({
        url: 'comun/json_colegiado'
    });
    newTypeahead('varbuscarcol', dataSetPersonas).on("typeahead:selected", function(e, datum) {
        fn_listarPagoRecaudoPersona({
            c_persona: datum.c_persona,
            c_expediente:'<?= $c_expediente; ?>'
        })
    });

    function fn_listarPagoRecaudoPersona(str) {
        obtenerDatos('divListarPagosRecaudoPersona', 'colegiados/tram_listar_detalle_recaudo', str);
    }
</script>