<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_actividad_sustento.php");
$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_actividad = new bo_tram_actividad_sustento();

$ent_usuario = new seg_usuarios();
$ent_actividad = new tram_actividad_sustento();

$usuario = s_usuario();
$cc_local = s_local();

$sede = ($cc_local === '28') ? 'CN' : 'CR';

$data_area = $bo_general->AreaAdministrativa($sede);
$data_dia = $bo_parametro_detalle->listarParametroDet("tram_actividad_sustento", "dia");
$data_flag = $bo_parametro_detalle->listarParametroDet("tram_actividad_sustento", "flag");

$opc = 'I';
if (isset($_REQUEST["opc"])) {
    $opc = s_crypt($_REQUEST["opc"], 'out');
}
$cc_sustento = '';
if (isset($_REQUEST["cod"])) {
    $cc_sustento = s_crypt($_REQUEST["cod"], 'out');
}

if ($opc == 'U') {
    $ent_actividad->setCc_sustento($cc_sustento);
    $dat_ac = $bo_actividad->listarID($ent_actividad);
    foreach ($dat_ac as $act) {
        $ent_actividad->setCc_area_adm($act["cc_area_adm"]);
        $ent_actividad->setObs($act["obs"]);
        $ent_actividad->setFecha($act["fecha"]);
        $ent_actividad->setDia($act["dia"]);
        $ent_actividad->setFlag($act["flag"]);
    }
}

?>
<input type="hidden" name="cc_sustento" id="cc_sustento" value="<?php echo s_crypt($cc_sustento, 'in') ?>">
<input type="hidden" name="opc" id="opc" value="<?php echo $opc ?>">

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Registro de horas extras</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#nav-border-top-home" role="tab" aria-selected="false">
                            Nuevo registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_listarReporte();" data-bs-toggle="tab" href="#nav-border-top-profile" role="tab" aria-selected="false">
                            Listar registros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_listarConsolidado();" data-bs-toggle="tab" href="#nav-border-top-consolidado" role="tab" aria-selected="false">
                            Consolidado
                        </a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="nav-border-top-home" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-body p-0">
                                    <div class="row row-cols-md-3 row-cols-1">
                                        <div class="col-12 col-lg border-end">
                                            <form method="post" action="javascript:fn_grabarRegistro();" id="frmGrabarRegistro" novalidate>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Área</span>
                                                            <select name="cc_area_adm" id="cc_area_adm" class="form-control" required>
                                                                <option value="">Selecciona</option>
                                                                <?php
                                                                foreach ($data_area as $area) {
                                                                ?>
                                                                    <option value="<?php echo $area["cc_area_adm"] ?>" <?php if ($ent_actividad->getCc_area_adm() == $area["cc_area_adm"]) {
                                                                                                                            echo "selected";
                                                                                                                        } ?>><?php echo $area["nombre"] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Fecha</span>
                                                            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $ent_actividad->getFecha(); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Día</span>
                                                            <select name="dia" id="dia" class="form-control" required>
                                                                <option value="">Selecciona</option>
                                                                <?php
                                                                foreach ($data_dia as $dia) { ?>
                                                                    <option value="<?php echo $dia['cc_codigo'] ?>" <?php if ($ent_actividad->getDia() == $dia['cc_codigo']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?php echo $dia['detalle']  ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Estado</span>
                                                            <select name="flag" id="flag" class="form-control" required>
                                                                <?php
                                                                foreach ($data_flag as $fl) { ?>
                                                                    <option value="<?php echo $fl['cc_codigo'] ?>" <?php if ($ent_actividad->getFlag() == $fl['cc_codigo']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?php echo $fl['detalle']  ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Evento</span>
                                                            <input type="text" class="form-control" id="obs" name="obs" placeholder="Evento" maxlength="70" oninput="updateCharacterCount()" value="<?php echo $ent_actividad->getObs(); ?>" required>
                                                            <small id="charCount">0/70</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <input type="hidden" name="cc_sustento" value="<?php echo s_crypt($cc_sustento, 'in') ?>">
                                                        <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                                                        <input type="hidden" name="cc_local" value="<?php echo $cc_local ?>">
                                                        <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
                                                        <?php if ($opc == 'U') { ?>
                                                            <?php echo bt_guardar('Actualizar'); ?>
                                                            <a href="?id=<?php echo s_crypt('400001', 'in') ?>" class="btn btn-outline-secondary" role="button" aria-pressed="true"><i class="fas fa-file"></i> Nuevo</a>
                                                        <?php } else {
                                                            echo bt_guardar('Continuar');
                                                        } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- end col -->
                                        <div class="col-12 col-lg">

                                            <div id="divFromDetalle"></div>

                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end col -->
                        </div><!-- end row -->


                    </div><!-- end row -->
                    <div class="tab-pane" id="nav-border-top-profile" role="tabpanel">
                        <div class="d-flex">
                            <div class="flex-grow-1 ms-2">
                                <div id="divReporte"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="nav-border-top-consolidado" role="tabpanel">
                        <div class="d-flex">
                            <div class="flex-grow-1 ms-2">
                                <div id="divlistarConsolidad"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importDatatable() . importTypeahead();
} ?>