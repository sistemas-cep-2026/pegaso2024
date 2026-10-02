<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_requisicion.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once u_src() . 'bo/bo_general.php';

$bo_alm_requisicion = new bo_alm_requisicion();
$bo_usuarios = new bo_seg_usuarios();
$bo_general = new bo_general();
$bo_parametro = new bo_gen_parametro_det();

$ent_requisicion = new alm_requisicion();
$ent_usuarios = new seg_usuarios();

$cc_local=s_local_vinculado(); 
$ent_requisicion->setFecha(fecha_hora_hoy());
$sede = ($cc_local==='28') ? 'CN':'CR';
$data_area=$bo_general->AreaAdministrativa($sede);
$ent_usuarios->setCc_local($cc_local);
$data_usuarios=$bo_usuarios->ListarUsuarios($ent_usuarios);

$flag = '0';
$opc='I';
 
if(isset($_REQUEST["opc"])){
    $opc=s_crypt($_REQUEST["opc"],'out');
}
 
$cc_requisicion='';
if(isset($_REQUEST["cc_requisicion"])){
    $cc_requisicion=s_crypt($_REQUEST["cc_requisicion"],'out');
}
 

if($opc=='U'){
    $ent_requisicion->setcc_requisicion($cc_requisicion);
    $dat_ac=$bo_alm_requisicion->listaID($ent_requisicion);
    foreach($dat_ac as $act){
        $ent_requisicion->setC_area_adm($act["c_area_adm"]);
        $ent_requisicion->setC_usuario($act["c_usuario"]);
        $ent_requisicion->setFecha($act["fecha"]);
        $ent_requisicion->setCc_local($act["cc_local"]);
        $ent_requisicion->setObservacion($act["observacion"]);
        $ent_requisicion->setFlag($act["flag"]);
        $flag = $act['flag'];
        $flag_text = $act['flag_text'];
    }
}

?>
<form action="javascript:fn_guardar();" id="frmRegistroVale" novalidate>
    <div class="row">
        <div class="col-md-9 p-2 border-end">
        <div class="row">
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Requisición: </span>
                        <input class="form-control" value="<?php echo $ent_requisicion->getCc_requisicion(); ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Estado : </span>
                        <input   class="form-control" id="flag1" name="flag1" value="<?php echo $flag_text; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Área :</span>
                        <select name="c_area_adm" id="c_area_adm" class="form-control" required>
                            <option value="">Selecciona</option>
                            <?php
                            foreach ($data_area as $area) {
                                ?>
                                <option value="<?php echo $area["cc_area_adm"] ?>" <?php if ($ent_requisicion->getC_area_adm() == $area["cc_area_adm"]) {
                                    echo "selected";
                                } ?>><?php echo $area["nombre"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Fecha : </span>
                        <input   class="form-control" id="fecha" name="fecha" value="<?php echo $ent_requisicion->getFecha(); ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Solicitante : </span>
                        <select name="c_usuario" id="c_usuario" class="form-control" required>
                            <option value="">Selecciona</option>
                            <?php
                            foreach ($data_usuarios as $user) {
                                ?>
                                <option value="<?php echo $user["usuario"] ?>" <?php if ($ent_requisicion->getC_usuario() === $user["usuario"]) {
                                    echo "selected";
                                } ?>><?php echo $user["nombre"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Observación : </span>
                        <input type="text" class="form-control" id="observacion" name="observacion" placeholder="observacion" oninput="contar_actividad()" maxlength="70" value="<?php echo $ent_requisicion->getObservacion(); ?>" required  >
                        <small id="charCount">0/70</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input  type="hidden"  name="cc_requisicion" value="<?php echo s_crypt($cc_requisicion,'in') ?>">
                    <input type="hidden" name="opc" value="<?php echo s_crypt($opc,'in')?>">
                    <input type="hidden" name="cc_local" value="<?php echo $cc_local ?>">
                    <input  type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>">
                    <div class="row border-bottom mb-1 py-2">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mt-md-1">
                <?php include 'requisiciones_tabs_botones.php'; ?>
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
        <div  id="divfromDetalle"></div>
    </div>
</div>
</div>
