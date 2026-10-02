<?php

use GuzzleHttp\Psr7\Request;

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_comp_rh_plame.php");
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
$bo_general = new bo_general();
$bo = new bo_comp_rh_plame();
$ent = new comp_rh_plame();
$bo_compras = new bo_comp_documentos_de_compras();
$data_tipodoc = $bo_compras->listaTipoDocumento();
$cc_id = s_crypt($_REQUEST['cc_id'], 'out') ?? '';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';

$ent->setFecha_registro(fecha_hora_hoy());
$cc_local = s_local_vinculado();
$cod_anho = s_anho();
$cod_mes = s_periodo();
$ent->setCod_mes($cod_mes);
$ent->setCod_anho($cod_anho);
$ent->setC_local($cc_local);

$disabled = 'X';



echo 'ID=' . $cc_id . '/opc->' . $opc;

$option = "NUEVO DOCUMENTO =>" . $ent->getCod_mes() . '/' . $ent->getCod_anho();

if ($opc == 'U') {
    $ent->setCc_Id($cc_id);
    $data = $bo->listarID($ent);
    foreach ($data as $act) {
        $ent->setC_local($act["c_local"]);
        $ent->setCod_anho($act["c_anho"]);
        $ent->setCod_mes($act["c_mes"]);
        $ent->setC_persona(s_crypt($act["c_persona"], 'in'));
        $ent->setCod_documento($act["cod_documento"]);
        $ent->setNum_documento($act["num_documento"]);
        $ent->setMonto($act["monto"]);
        $ent->setFecha_documento($act["fecha_documento"]);
        $ent->setFecha_pago($act["fecha_pago"]);
        $ent->setCuarta($act["cuarta"]);
        $ent->setRazon_social($act["nombre"]);

    }
    $option = "MODIFICAR DOCUMENTO => " . $ent->getCod_mes() . '/' . $ent->getCod_anho();
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_procesar();" id="frmRegistro" novalidate>
        <div class="row">
            <div class="col-md-12 p-2">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="input-group mb-4">
                            <span class="input-group-text">Tipo Doc. : </span>
                            <select class="form-control" id="cod_documento" name="cod_documento" <?php echo $disabled_temp_prima ?> required>

                                <?php
                                foreach ($data_tipodoc as $uni) {
                                    if ($uni["c_tipo_de_documento"] === "RH") {
                                ?>
                                        <option value="<?php echo $uni['c_tipo_de_documento']; ?>" <?php if ($ent->getCod_documento() == $uni["c_tipo_de_documento"]) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $uni['nombre']; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-3">
                            <span class="input-group-text"># : </span>
                            <input type="text" class="form-control" id="num_documento" name="num_documento" title="Al menos 5 caracteres." placeholder="0000-0000000" value="<?php echo $ent->getNum_documento(); ?>" required <?php echo $disabled_temp_prima ?> oninput="formatDocumento(this)" maxlength="20" minlength="6">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group mb-4">
                                <input  type="hidden"  class="form-control" id="cc_persona" name="cc_persona" value="<?php echo $ent->getC_persona(); ?>">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ruc / Razón Social" value="<?php echo $ent->getRazon_social(); ?>" required <?php echo $disabled_temp_prima ?>>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group mb-4">
                                <span class="input-group-text">F. Emisión. : </span>
                                <input type="date" class="form-control" id="fecha_documento" name="fecha_documento" value="<?php echo $ent->getFecha_documento(); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group mb-4">
                                <span class="input-group-text">F. Pago. : </span>
                                <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?php echo $ent->getFecha_pago(); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Monto : </span>
                                <input type="text" class="form-control" name="monto" id="monto" value="<?php echo $ent->getMonto(); ?>" placeholder="S/. 0.00" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group mb-4">
                                <span class="input-group-text">4TA : </span>
                                <select class="form-control" id="cuarta" name="cuarta" <?php echo $disabled_temp_prima ?> required>


                                    <option value="1" <?php if ($ent->getCuarta() === $uni["cuarta"]) {
                                                            echo "selected";
                                                        } ?>>SI</option>
                                    <option value="0" <?php if ($ent->getCuarta() === $uni["cuarta"]) {
                                                            echo "selected";
                                                        } ?>>NO</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                        <input type="hidden" name="cc_id" value="<?php echo s_crypt($cc_id, 'in') ?>">
                        <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    $("#frmRegistro").validate();

    var cccc = newBloodhound({
        url: 'comun/json_ruc'
    });


    newTypeahead('nombre', cccc).on("typeahead:selected", function(e, datum) {
        $('input[name="cc_persona"]').val(datum.c_persona);

    });
</script>