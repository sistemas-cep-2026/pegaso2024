<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");
$bo_general = new bo_general();
$bo_cajachica = new bo_comp_liquidaciones_caja_chica();
$bo_usuario = new bo_seg_usuarios();

$ent_usuario = new seg_usuarios();
$ent_cajachica = new comp_liquidaciones_caja_chica();

$ent_usuario->setCc_local(s_local_vinculado());
$data_usuer     = $bo_usuario->ListarUsuarios($ent_usuario);
$data_bancos    = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_caja_chica = isset($_REQUEST['cc_caja_chica']) ? s_crypt($_REQUEST['cc_caja_chica'], 'out') : '';
$option = "NUEVA CAJA CHICA";
if ($opc == 'U') {
    $ent_cajachica->setCc_caja_chica($cc_caja_chica);
    $dat_ac = $bo_cajachica->listarID($ent_cajachica);
    foreach ($dat_ac as $act) {
        $ent_cajachica->setC_persona($act["c_persona"]);
        $ent_cajachica->setFecha_operacion($act["fecha_operacion"]);
        $ent_cajachica->setNro_cheque($act["nro_cheque"]);
        $ent_cajachica->setC_banco($act["c_banco"]);
        $ent_cajachica->setMonto($act["monto"]);
        $ent_cajachica->setMonto_apertura($act["monto_apertura"]);
        $banco_cta = $act["banco_cta"] ?? '';
    }
    $option = "MODIFICAR CAJA CHICA";
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardarcChica();" id="frmRegistrocChica" novalidate>
        <div class="row">
            <div class="col-md-12 p-2">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Usuario : </span>
                            <select class="form-control" id="c_persona" name="c_persona" required>
                                <option value="">Selecciona</option>
                                <?php
                                foreach ($data_usuer as $user) { ?>
                                    <option value="<?php echo $user['c_persona']; ?>" <?php if ($ent_cajachica->getC_persona() == $user["c_persona"]) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $user['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Fecha op : </span>
                            <input type="date" class="form-control" id="fecha_operacion" name="fecha_operacion" value="<?php echo $ent_cajachica->getFecha_operacion(); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Banco : </span>
                            <select class="form-control" id="c_banco" name="c_banco" required>
                                <option value="">Selecciona</option>
                                <?php
                                foreach ($data_bancos as $ban) { ?>
                                    <option value="<?php echo $ban['c_banco'] . "-" . $ban['c_cta_corriente']; ?>" <?php if ($banco_cta === $ban['banco_cta']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?php echo $ban['nombre'] . " =>> " . $ban['c_cta_corriente'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group mb-3">
                            <span class="input-group-text">N° Cheque : </span>
                            <input type="text" class="form-control" id="nro_cheque" name="nro_cheque" value="<?php echo $ent_cajachica->getNro_cheque(); ?>" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Monto. : </span>
                            <input type="text" class="form-control" name="monto" id="monto" value="<?php echo $ent_cajachica->getMonto() ?: ''; ?>" placeholder="S/. 0.00" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Monto Apertura : </span>
                            <input type="text" class="form-control" name="monto_apertura" id="monto_apertura" value="<?php echo $ent_cajachica->getMonto_apertura() ?: ''; ?>" placeholder="S/. 0.00">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                        <input type="hidden" name="cc_caja_chica" value="<?php echo s_crypt($cc_caja_chica, 'in') ?>">
                        <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $("#frmRegistrocChica").validate();
    var cleaveNumeral = new Cleave("#monto", {
        numeral: !0,
        numeralThousandsGroupStyle: "thousand"
    })
    var cleaveNumeral = new Cleave("#monto_apertura", {
        numeral: !0,
        numeralThousandsGroupStyle: "thousand"
    })

    function fn_guardarcChica() {
        swalProcesando();
        var str = $("#frmRegistrocChica").serialize();
        ajax('compras/cajachica_update', str)
            .then(function(res) {
                if (res != '0') {
                    throw res;
                }
                swalOk(750);
                modalRegistro.hide();
                fn_reporteCjaChica();
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>