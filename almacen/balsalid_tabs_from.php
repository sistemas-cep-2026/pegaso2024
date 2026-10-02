<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once u_src() . 'bo/bo_general.php';

$bo_valesalida = new bo_alm_guias_de_salida();
$bo_usuarios = new bo_seg_usuarios();
$bo_general = new bo_general();
$bo_parametro = new bo_gen_parametro_det();

$ent_valesalida = new alm_guias_de_salida();
$ent_usuarios = new seg_usuarios();

$cc_local=s_local_vinculado();
$ent_valesalida->setFecha(fecha_hora_hoy());
$sede = ($cc_local==='28') ? 'CN':'CR';
$data_area=$bo_general->AreaAdministrativa($sede);
$ent_usuarios->setCc_local($cc_local);
$data_usuarios=$bo_usuarios->ListarUsuarios($ent_usuarios);
//echo date('Y-m-d H:i:s');
$flag = '0';
$opc='I';
if(isset($_REQUEST["opc"])){
    $opc=s_crypt($_REQUEST["opc"],'out');
}
$cc_guia='';
if(isset($_REQUEST["cc_guia"])){
    $cc_guia=s_crypt($_REQUEST["cc_guia"],'out');
}


if($opc=='U'){
    $ent_valesalida->setCc_guia($cc_guia);
    $dat_ac=$bo_valesalida->listaID($ent_valesalida);
    foreach($dat_ac as $act){
        $ent_valesalida->setC_area_adm($act["c_area_adm"]);
        $ent_valesalida->setFecha($act["fecha_text"]);
        // $ent_valesalida->setUser_crea($act["user_crea"]);
        $ent_valesalida->setC_local($act["c_local"]);
        $ent_valesalida->setJustificacion($act["justificacion"]);
        $ent_valesalida->setFlag($act["flag"]);
        $flag = $act['flag'];
        $flag_text = $act['flag_text'];
    }
}

?>
<form action="javascript:fn_guardarVale();" id="frmRegistroVale" novalidate>
    <div class="row">
        <div class="col-md-9 p-2 border-end">
        <div class="row">
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Vale: </span>
                        <input class="form-control" value="<?php echo $ent_valesalida->getCc_guia(); ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Estado : </span>
                        <input   class="form-control" id="flag1" name="flag1" value="<?php echo  $flag_text; ?>" readonly>
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
                                <option value="<?php echo $area["cc_area_adm"] ?>" <?php if ($ent_valesalida->getC_area_adm() == $area["cc_area_adm"]) {
                                    echo "selected";
                                } ?>><?php echo $area["nombre"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Fecha : </span>
                        <input class="form-control" id="fecha" name="fecha" value="<?php echo $ent_valesalida->getFecha(); ?>" readonly>
                    </div>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-lg-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Solicitante : </span>
                        <select name="user_crea" id="user_crea" class="form-control" required>
                            <option value="">Selecciona</option>
                            <?php
                            //foreach ($data_usuarios as $user) {
                                ?>
                                <option value="<?php // echo $user["usuario"] ?>" <?php //if ($ent_valesalida->getUser_crea() === $user["usuario"]) {
                                    //echo "selected";
                                //} ?>><?php //echo $user["nombre"] ?></option>
                            <?php //} ?>
                        </select>
                    </div>
                </div>
            </div>-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Justificación : </span>
                        <input type="text" class="form-control" id="justificacion" name="justificacion" placeholder="Justificación" oninput="contar_actividad()" maxlength="70" value="<?php echo $ent_valesalida->getJustificacion(); ?>" required>
                        <small id="charCount">0/70</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="cc_guia" value="<?php echo s_crypt($cc_guia,'in') ?>">
                    <input type="hidden" name="opc" value="<?php echo s_crypt($opc,'in')?>">
                    <input type="hidden" name="cc_local" value="<?php echo $cc_local ?>">
                    <input type="hidden" name="flag" id="flag" value="<?php echo $flag; ?>">
                    <div class="row border-bottom mb-1 py-2">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mt-md-1">
                <?php include 'balsalid_tabs_botones.php'; ?>
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
