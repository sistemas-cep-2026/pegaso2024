<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_compras = new bo_comp_documentos_de_compras();
$bo_general = new bo_general();
$bo_personas = new bo_gen_personas();

$ent_personas = new gen_personas();

$cc_documento_det = s_crypt($_REQUEST['cc_documento_det'], 'out');
$c_persona = s_crypt($_REQUEST['c_persona_hijo'] ?? '', 'out');
$cod_documento = $_REQUEST['cod_documento'];
$c_local = s_crypt($_REQUEST['c_local'], 'out');
$data_compras = $bo_compras->documentosBancos($c_local, $c_persona, $cod_documento);
$ent_personas->setC_persona($c_persona);
$dato_per = $bo_personas->listarID($ent_personas);

$ruc          = '';
$rasonsocial  = '';
$num_doc      = '';
$tipo_doc     = '';
$estado_per   = '';
foreach ($dato_per as $per) {
    $ruc         = trim((string)($per['ruc'] ?? ''));
    $rasonsocial = trim((string)($per['nombre_completo'] ?? ''));
    $num_doc     = trim((string)($per['num_documento'] ?? ''));
    $tipo_doc    = trim((string)($per['cod_documento_text'] ?? ''));
    $estado_per  = trim((string)($per['flag_activo_text'] ?? ''));
}
$id_etiqueta = ($ruc !== '') ? 'RUC' : ($tipo_doc !== '' ? $tipo_doc : 'Documento');
$id_valor    = ($ruc !== '') ? $ruc : $num_doc;

?>
<div class="modal-header">
    <h4 class="modal-title">DOCUMENTOS PENDIENTES:</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <div class="card border-0 border-start border-3 border-primary shadow-none bg-light-subtle mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center">
                <div class="avatar-sm flex-shrink-0 me-3">
                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-4">
                        <i class="ri-building-line"></i>
                    </span>
                </div>
                <div class="flex-grow-1">

                    <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($rasonsocial) ?></h6>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <?php if ($id_valor !== '') { ?>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                <?= htmlspecialchars($id_etiqueta) ?>: <?= htmlspecialchars($id_valor) ?>
                            </span>
                        <?php } ?>
                        <?php if ($estado_per !== '') { ?>
                            <span class="badge bg-light text-muted border"><?= htmlspecialchars($estado_per) ?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="javascript:fn_guardarEvento();" id="frmRegistroEvento" novalidate>
        <div class="row">
            <div class="col-md-12 p-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive" style="max-height: calc(100vh - 340px); min-height: 180px; overflow-y: auto;">
                            <table class="table table-nowrap" id="tblComprasPend">
                                <thead class="table-light">
                                    <tr>
                                        <th>DOCUMENTO</th>
                                        <th>FECHA</th>
                                        <th>PERIODO</th>
                                        <th>SALDO</th>
                                        <th>MONTO OPERACION</th>
                                        <th>OBS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_compras as $row) { ?>
                                        <tr>
                                            <th scope="row"><a href="#" onclick="fc_procesarCompras('<?php echo s_crypt($cc_documento_det, 'in') ?>','<?php echo s_crypt($row['cc_compra_det'], 'in') ?>','<?php echo s_crypt('D', 'in') ?>')" class="fw-semibold"><?php echo $row['cod_documento'] . '-' . $row['num_documento'] ?></a></th>
                                            <td><?php echo $row['fecha_documento'] ?></td>
                                            <td><?php echo $row['cod_mes'] . ' / ' . $row['cod_ano'] ?></td>
                                            <td class="text-end"><?php echo 'S/. ' . decimal($row['saldo'], 2) ?></td>
                                            <td class="text-end"><?php echo 'S/. ' . decimal($row['haber'], 2) . '(' . $row['c_cuenta'] . ')' ?></td>
                                            <td><?php echo $row['observacion'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <?= bt_cerrar('Cerrar') ?>
</div>
<script>
    function fc_procesarCompras(cc_documento_det, cc_compra, opcd) {
        alertaMensaje('&iquest;Desea procesar este registro?', function() {
            var str = 'cc_documento_det=' + cc_documento_det + '&cc_compra=' + cc_compra + '&opcd=' + opcd;
            return ajax('bancos/egresos_detalle_update', str)
                .then(function(data) {
                    if (data !== '0') {
                        throw data;
                    }
                    return data;
                }).catch(function(err) {
                    Swal.showValidationMessage(err);
                });
        }).then(function(result) {
            if (result.value) {
                modalRegistroXl.hide();
                fn_listarDetalleFromEgresos();
            }
        });
    }
</script>