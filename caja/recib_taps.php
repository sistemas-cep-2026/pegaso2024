<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
require_once(u_src() . "bo/bo_fin_puntos_de_venta.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_ventas = new bo_fin_documentos_de_venta();
$bo_ptventa = new bo_fin_puntos_de_venta();

$ent_ventas = new fin_documentos_de_venta();
$ent_ptventa = new fin_puntos_de_venta();

$ent_ptventa->setC_local(s_local());
$data_vp = $bo_ptventa->listar_por_local($ent_ptventa);

$flag = '0';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_ventas = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';

$tp_coleg = $bo_parametro_detalle->listarParametroDet('documentos_de_venta', 'c_persona_ref');
$tp_document = $bo_parametro_detalle->listarParametroDet('documentos_de_venta', 'cod_documento');

$disabled = '';
$ent_ventas->setFecha(date('Y-m-d'));

if ($opc == 'U') {
    $ent_ventas->setCc_ventas($cc_ventas);
    $dat_ac = $bo_ventas->listarID($ent_ventas);
    foreach ($dat_ac as $act) {
        $ent_ventas->setC_punto_de_venta($act["c_punto_de_venta"]);
        $ent_ventas->setCod_documento($act["cod_documento"]);
        $ent_ventas->setC_persona($act['c_persona']);
        $ent_ventas->setNombre_completo($act['nombre_completo']);
        $ent_ventas->setObservacion($act['observacion']);
        $ent_ventas->setC_persona_ref($act['c_persona_ref']);
        $ent_ventas->setNum_documento($act['num_documento']);
        $flag = $act["flag"];
    }
    $disabled = 'disabled';
}
$codDocDefault = 'RC';
$pvSeleccionado = $ent_ventas->getC_punto_de_venta();
if (!$pvSeleccionado && isset($_SESSION['punto_venta'])) {
    $pvSeleccionado = $_SESSION['punto_venta'];
}
$esPV137 = ($pvSeleccionado === '000137');

if (!$esPV137) {
    $ent_ventas->setCod_documento($codDocDefault);
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header align-items-center d-flex border-0">
                <h4 class="card-title mb-0 flex-grow-1">
                    <i class="bx bx-receipt text-primary align-middle me-1"></i> Registro de Recibo Interno
                </h4>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">
                            <i class="bx bx-plus-circle align-middle me-1"></i> Nuevo Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_listarBuscar();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">
                            <i class="bx bx-list-ul align-middle me-1"></i> Listar Registros
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
                        <form action="javascript:fn_guardarRecibo();" id="frmRegistroRecibo" novalidate>
                            <input type="hidden" name="flag" id="flag" value="<?php echo $flag ?>">
                            <div class="row">
                                <div class="col-md-9 p-2 border-end">
                                    <fieldset <?php echo $disabled; ?>>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bx bx-store me-1"></i> Punto venta</span>
                                                    <select class="form-control" id="c_punto_de_venta" name="c_punto_de_venta" required>
                                                        <option value="">Selecciona</option>
                                                        <?php foreach ($data_vp as $pv):
                                                            $selected = ($pvSeleccionado === $pv['c_punto_de_venta']) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= $pv['c_punto_de_venta'] ?>" <?= $selected ?>><?= $pv['nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bx bx-file me-1"></i> Tp Doc.</span>
                                                    <select class="form-control" id="cod_documento" name="cod_documento" <?= $esPV137 ? '' : 'disabled' ?> required>
                                                        <?php foreach ($tp_document as $row) { ?>
                                                            <option value="<?= $row['cc_codigo'] ?>"
                                                                <?= ($ent_ventas->getCod_documento() == $row['cc_codigo']) ? 'selected' : '' ?>>
                                                                <?= $row['detalle'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php if (!$esPV137): ?>
                                                <!-- Espejo oculto para enviar RC cuando el select esté deshabilitado -->
                                                <input type="hidden" id="cod_documento_hidden" name="cod_documento"
                                                    value="<?= htmlspecialchars($ent_ventas->getCod_documento() ?: $codDocDefault, ENT_QUOTES, 'UTF-8') ?>">
                                            <?php endif; ?>

                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bx bx-hash me-1"></i> N° Recibo</span>
                                                    <input type="text" class="form-control fw-semibold" id="num_documento" name="num_documento" title="000-0000000" placeholder="000-0000000" value="<?php echo $ent_ventas->getNum_documento(); ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <select name="c_persona_ref" class="form-control form-select" id="tipo_persona">
                                                    <?php foreach ($tp_coleg as $row) { ?>
                                                        <option value="<?= $row['cc_codigo'] ?>"
                                                            <?= ($ent_ventas->getC_persona_ref() == $row['cc_codigo']) ? 'selected' : '' ?>>
                                                            <?= $row['detalle'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="input-group mb-3">
                                                    <input type="hidden" class="form-control" id="c_persona" name="c_persona" value="<?= s_crypt($ent_ventas->getC_persona(), 'in'); ?>">
                                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Selecciona Cliente" value="<?= $ent_ventas->getNombre_completo(); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bx bx-note me-1"></i> Obs.</span>
                                                    <input type="text" class="form-control" id="obs" name="obs" placeholder="Observación" value="<?= $ent_ventas->getObservacion(); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="hidden" name="cc_local" value="<?= s_crypt($ent_ptventa->getC_local()) ?>">
                                                <input type="hidden" name="cc_ventas" id="cc_ventas" value="<?php echo s_crypt($cc_ventas, 'in') ?>">
                                                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                                                <div class="row border-bottom mb-1 py-2"></div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                                <div class="col-md-3">
                                    <div class="mt-md-1">
                                        <?php include 'recib_botones.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-9 border-end">
                                <div id="divDetalleRecibo"></div>
                            </div>
                            <div class="col-md-3">
                                <div id="divPagosRecibo"></div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divlistarVentas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importDatatable() . importTypeahead() . importSelect2() . importInputMask() . importToolTip();
} ?>