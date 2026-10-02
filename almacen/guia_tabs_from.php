<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_entrada.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
$bo_general = new bo_general();
$bo_compras = new bo_comp_documentos_de_compras();

$bo_alm_guia = new bo_alm_guias_de_entrada();
$bo_usuarios = new bo_seg_usuarios();
$bo_general = new bo_general();
$bo_parametro = new bo_gen_parametro_det();

$ent_guia = new alm_guias_de_entrada();
$ent_usuarios = new seg_usuarios();

$cc_local = s_local_vinculado();
$ent_guia->setFecha(fecha_hora_hoy());
$sede = ($cc_local === '28') ? 'CN' : 'CR';
$data_area = $bo_general->AreaAdministrativa($sede);
$ent_usuarios->setCc_local($cc_local);
$data_usuarios = $bo_usuarios->ListarUsuarios($ent_usuarios);

$flag = '0';
$opc = 'I';
$cc_local = s_local_vinculado();

if (isset($_REQUEST["opc"])) {
    $opc = s_crypt($_REQUEST["opc"], 'out');
}

$cc_guia = '';
if (isset($_REQUEST["cc_guia"])) {
    $cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
}

if ($opc == 'U') {
    $ent_guia->setCc_guia($cc_guia);
    $dat_ac = $bo_alm_guia->listaID($ent_guia);

    foreach ($dat_ac as $act) {
        $ent_guia->setCc_guia($act["cc_guia"]);
        $ent_guia->setCc_usuario($act["c_usuario"]);
        $ent_guia->setFecha($act["fecha"]);
        $ent_guia->setCc_local($act["cc_local"]);
        $ent_guia->setObservacion($act["observacion"]);
        $ent_guia->setFlag($act["flag"]);
        $ent_guia->setCc_persona($act["c_persona"]);
        $ent_guia->setCod_documento($act["cod_documento"]);
        $ent_guia->setNum_documento($act["num_documento"]);
        $ent_guia->setCc_requisicion($act["cc_requisicion"]);
        $flag = $act['flag'];
        $flag_text = $act['flag_text'];
        $Razon_social = $act['ruc'] . '-' . $act['nombre'];
    }
}
$data_tipodoc = $bo_compras->listaTipoDocumento();
$data = $bo_alm_guia->listarRequisciones($cc_local);
?>
<form action="javascript:fn_guardar();" id="frmRegistroVale" novalidate>
    <div class="row">
        <div class="col-md-9 p-2 border-end">
            <div class="row">
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Guía: </span>
                        <input class="form-control" value="<?php echo $ent_guia->getCc_guia(); ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Estado : </span>
                        <input class="form-control" id="flag1" name="flag1" value="<?php echo $flag_text; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Tipo Doc. : </span>
                        <select class="form-control" id="cod_documento" name="cod_documento" required>
                            <option value="">Selecciona</option>
                            <?php foreach ($data_tipodoc as $uni): ?>
                                <option value="<?= $uni['c_tipo_de_documento']; ?>" <?= ($ent_guia->getCod_documento() == $uni["c_tipo_de_documento"]) ? 'selected' : ''; ?>>
                                    <?= $uni['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"># : </span>
                        <input type="text" class="form-control" id="num_documento" name="num_documento" title="Al menos 5 caracteres." value="<?php echo $ent_guia->getNum_documento(); ?>" required oninput="this.value = this.value.toUpperCase();" maxlength="11" minlength="5">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group mb-3">
                        <input   type="hidden"  class="form-control" id="cc_persona" name="cc_persona" value="<?php echo $ent_guia->getCc_persona(); ?>">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ruc / Razón Social" value="<?php echo $Razon_social; ?>" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Fecha : </span>
                        <input class="form-control" id="fecha" name="fecha" value="<?php echo $ent_guia->getFecha(); ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Observación : </span>
                        <input type="text" class="form-control" id="observacion" name="observacion" placeholder="observacion" oninput="contar_actividad()" maxlength="70" value="<?php echo $ent_guia->getObservacion(); ?>" required>
                        <small id="charCount">0/70</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Requisicion: </span>
                        <select name="cc_requisicion" id="cc_requisicion" class="form-control">
                               <option value="">Selecciona</option>
                            <?php
                            foreach ($data as $loc) { ?>
                                <option value="<?= $loc['cc_requisicion']?>" <?= ($ent_guia->getCc_requisicion() == $loc["cc_requisicion"]) ? 'selected' : ''; ?>><?= $loc['cc_requisicion'] . ' //  ' . $loc['observacion']; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="cc_guia" value="<?php echo s_crypt($cc_guia, 'in') ?>">
                    <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                    <input type="hidden" name="cc_local" value="<?php echo $cc_local ?>">
                    <input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>">
                   <!--  <input type="hidden" name="flag" id="cc_requisicion2" value="<?php //echo $ent_guia->getCc_requisicion(); ?>"> -->
                    <div class="row border-bottom mb-1 py-2">
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-md-3">
            <div class="mt-md-1">
                <?php include 'guia_tabs_botones.php'; ?>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-9 p-2 border-end" id="divlistarDetalles">
        <div class="mt-md-1">
            <div id="divListardetalle"></div>
        </div>
    </div>
    <div class="col-md-9 p-2 border-end">
        <div class="mt-md-1">
            <div id="divfromDetalle"></div>
        </div>
    </div>
</div>

 