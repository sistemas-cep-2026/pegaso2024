<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_compras = new bo_comp_documentos_de_compras();
$bo_general = new bo_general();

$cc_documento_det = s_crypt($_REQUEST['cc_documento_det'], 'out');
$c_persona = s_crypt($_REQUEST['c_persona_hijo'] ?? '', 'out');
$cod_documento = $_REQUEST['cod_documento'];
$c_local = s_crypt($_REQUEST['c_local'], 'out');
//print_r($_REQUEST);
$data_compras = $bo_compras->documentosBancos($c_local, $c_persona, $cod_documento);

?>
<div class="modal-header">
    <h4 class="modal-title">DOCUMENTOS PENDIENTES:</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardarEvento();" id="frmRegistroEvento" novalidate>
        <div class="row">
            <div class="col-md-12 p-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-nowrap">
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
                                              <td class="text-end"><?php echo 'S/. ' . decimal($row['haber'], 2).'('. $row['c_cuenta'].')' ?></td>
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
                modalRegistro.hide();
                fn_listarDetalleFromEgresos();
            }
        });
    }
</script>