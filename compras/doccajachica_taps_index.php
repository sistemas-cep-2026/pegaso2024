<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");
$bo_general = new bo_general();
$bo_compras = new bo_comp_documentos_de_compras();
$bo_cja_chica = new bo_comp_liquidaciones_caja_chica();

$ent_compras = new comp_documentos_de_compras();
$ent_cja_chica = new comp_liquidaciones_caja_chica();



$perido_activo = $bo_general->periodo_activo_compras(s_local(), s_anho(), s_periodo());
foreach ($perido_activo as $activop) {
    $activo_mes =   $activop["cantidad"];
}


$data_local = $bo_general->RegionID(s_local_vinculado());
foreach ($data_local as $loc) {
    $cc_loca_text = $loc['nombre'];
}
$flag = '0';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_compra = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';

$data_tipodoc = $bo_compras->listaTipoDocumento_caja();

$ent_cja_chica->setC_local(s_local_vinculado());
$data_cchica = $bo_cja_chica->CajaChicaPendiente($ent_cja_chica);

$disabled = '';
$disabled_temp = '';
$flag_text = 'Sin estado';
$cod_ano = s_anho();
$cod_mes = s_periodo();
$fecha = fechaPeriodoActual($cod_ano, $cod_mes);
$ent_compras->setFecha_documento($fecha);
$ent_compras->setFecha_vencimiento($fecha);
if ($opc == 'U') {
    $ent_compras->setCc_compra($cc_compra);
    $dat_ac = $bo_compras->listarID($ent_compras);
    foreach ($dat_ac as $act) {
        $ent_compras->setCod_documento($act["cod_documento"]);
        $ent_compras->setNum_documento($act["num_documento"]);
        $ent_compras->setFecha_documento($act["fecha_documento"]);
        $ent_compras->setFecha_vencimiento($act["fecha_vencimiento"]);
        $ent_compras->setTotal($act["total"]);
        $ent_compras->setCc_persona(s_crypt($act["c_persona"]));
        $ent_compras->setRazon_social($act["razon_social"]);
        $ent_compras->setCc_local($act["c_local"]);
        $ent_compras->setObservacion($act["observacion"]);
        $ent_compras->setPorcentaje($act["porcentaje"]);
        $ent_compras->setC_liquidacion_caja_chica($act["c_liquidacion_caja_chica"]);
        $flag_text = $act["flag_text"];
        $flag_text_cancelado = $act["flag_text_cancelado"];
        $error_text = $act["error_text"];
        $flag = $act["flag"];
        $disabled = in_array($flag, ['*', 'A']) ? 'disabled' : '';
        $ent_compras->setComprobante($act["comprobante"]);
        $ent_compras->setC_local($act["c_local"]);
        $ent_compras->setCod_ano($act["cod_ano"]);
        $ent_compras->setCod_mes($act["cod_mes"]);

        $ent_compras->setTipo_desc($act["tipo_desc"]);
        $ent_compras->setReten_numero($act["reten_numero"]);
        $ent_compras->setReten_fecha($act["reten_fecha"]);
    }
}

$disabled_temp = ($flag == '&' || $flag == '0') ? ' ' : ' readonly';
$disabled_temp_prima = ($flag == '0') ? ' ' : ' readonly';

$meses = u_meses();
$nombre_mes = $meses[$cod_mes] ?? 'Mes no definido';
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header align-items-center d-flex border-0">
                <h4 class="card-title mb-0 flex-grow-1">REGISTRO DE DOCUMENTOS DE CAJA CHICA</h4>

            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">CREAR REGISTRO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_reporteComprasCH();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">LISTAR REGISTROS</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
                        <form action="javascript:fn_guardarCchica();" id="frmRegistroCchica" novalidate>
                            <input name="cc_compra" id="cc_compra" type="hidden" value="<?php echo s_crypt($cc_compra) ?>">
                            <input name="flag" id="flag" type="hidden" value="<?php echo $flag ?>">
                            <div class="row">

                                <div class="col-md-9 p-2 border-end">
                                    <fieldset <?php echo $disabled; ?>>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-warning text-dark fw-semibold">
                                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                        Periodo Actual:
                                                    </span>
                                                    <input type="text" class="form-control bg-warning bg-opacity-25 border-warning fw-bold" value="<?= $nombre_mes . ' => ' . $cod_ano; ?>"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Comprobante #: </span>
                                                    <input type="text" class="form-control" id="compro" name="compro" value="<?= digitos($ent_compras->getComprobante(), 6) ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group mb-3">
                                                    <div class="alert <?php echo $color_flag_cont[$flag]; ?> shadow p-2 text-white" role="alert">
                                                        <?php echo $flag_text; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Caja chica:</span>
                                                    <select class="form-control" id="cc_caja_chica" name="cc_caja_chica" required <?= $disabled_temp_prima ?>>
                                                        <?php foreach ($data_cchica as $cja): ?>
                                                            <option value="<?= $cja['c_liquidacion_caja_chica']; ?>"
                                                                <?= ($ent_compras->getC_liquidacion_caja_chica() == $cja['c_liquidacion_caja_chica']) ? 'selected' : ''; ?>>
                                                                <?= htmlspecialchars($cja['caja_chica']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Tipo Doc. : </span>
                                                    <select class="form-control" id="cod_documento" name="cod_documento" <?= $disabled_temp_prima ?? '' ?> required>
                                                        <?php
                                                        $selectedDoc = $ent_compras->getCod_documento();
                                                        foreach ($data_tipodoc as $uni):
                                                            $selected = ($selectedDoc == $uni['c_tipo_de_documento']) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= $uni['c_tipo_de_documento']; ?>" <?= $selected; ?>>
                                                                <?= $uni['nombre']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"># : </span>
                                                    <input type="text" class="form-control" id="num_documento" name="num_documento" title="Al menos 5 caracteres." value="<?php echo $ent_compras->getNum_documento(); ?>"
                                                        required <?php echo $disabled_temp_prima ?> onblur="formatDocumento(this)" maxlength="11" minlength="5">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="input-group mb-3">
                                                    <input class="form-control" type="hidden" id="cc_persona" name="cc_persona" value="<?php echo $ent_compras->getCc_persona(); ?>">
                                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ruc / Razón Social" value="<?php echo $ent_compras->getRazon_social(); ?>" required <?php echo $disabled_temp_prima ?>>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">F. Emisión : </span>
                                                    <input type="date" class="form-control" id="fecha_documento" name="fecha_documento" value="<?php echo $ent_compras->getFecha_documento(); ?>" required <?php echo $disabled_temp ?>>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">F. Venc. : </span>
                                                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $ent_compras->getFecha_vencimiento(); ?>" <?php echo $disabled_temp ?>>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Neto : </span>
                                                    <input type="text" class="form-control input-pen" name="total" id="total" title="Mayor que 0.01" min="0.01" value="<?php echo decimal($ent_compras->getTotal(), 2); ?>" placeholder="S/. 0.00" required <?php echo $disabled_temp ?>>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="row_tipo_desc">
                                            <div class="col-lg-3">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">D/R</span>
                                                    <select class="form-control" id="tipo_desc" name="tipo_desc" <?= $disabled_temp ?? '' ?>>
                                                        <option value="">-- Seleccione --</option>
                                                        <?php
                                                        $tipos = tipo_reten();
                                                        $selectedTipo = $ent_compras->getTipo_desc() ?? '';
                                                        foreach ($tipos as $key => $value):
                                                            $selected = ($selectedTipo == $key) ? 'selected' : '';
                                                        ?>
                                                            <option value="<?= $key; ?>" <?= $selected; ?>><?= $value; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2" id="col_porcentaje">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">%</span>
                                                    <select class="form-control" id="porcentaje" name="porcentaje" <?= $disabled_temp ?>>
                                                        <?php
                                                        $data_porcen = procentaje();
                                                        foreach ($data_porcen as $value => $key) { ?>
                                                            <option value="<?php echo $value; ?>" <?php if ($ent_compras->getPorcentaje() == $value) echo "selected"; ?>>
                                                                <?php echo $key; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 d-none" id="col_porcentaje_ret">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">%</span>
                                                    <select class="form-control" id="porcentaje_ret" name="porcentaje_ret" <?= $disabled_temp ?>>
                                                        <?php
                                                        $data_porcen_reten = procentaje_retenc();
                                                        foreach ($data_porcen_reten as $value => $key) { ?>
                                                            <option value="<?php echo $value; ?>" <?php if ($ent_compras->getPorcentaje() == $value) echo "selected"; ?>>
                                                                <?php echo $key; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 d-none" id="col_reten_numero">
                                                <input type="text" class="form-control" name="reten_numero" id="reten_numero"
                                                    value="<?php echo $ent_compras->getReten_numero(); ?>" placeholder="E001-1" <?= $disabled_temp ?>>
                                            </div>

                                            <div class="col-lg-3 d-none" id="col_reten_fecha">
                                                <input type="date" class="form-control" name="reten_fecha" id="reten_fecha"
                                                    value="<?php echo $ent_compras->getReten_fecha(); ?>" <?= $disabled_temp ?>>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Obs: </span>
                                                    <input type="text" class="form-control" id="observacion" maxlength="80" name="observacion" value="<?php echo $ent_compras->getObservacion(); ?>" oninput="this.value = this.value.toUpperCase();" <?php echo $disabled_temp ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (strlen($error_text ?? '') > 0) { ?>
                                            <div class="col-lg-2">
                                                <div class="input-group mb-3">
                                                    <span class="badge rounded-pill <?php echo $color_flag_cont["A"]; ?>"><?php echo  $error_text; ?> </span>
                                                </div>

                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="hidden" name="cc_compra" value="<?php echo s_crypt($cc_compra, 'in') ?>">
                                                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                                                <div class="row border-bottom mb-1 py-2"></div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <div class="mt-md-1">
                                        <?php include 'comp_taps_botones.php'; ?>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="row">
                            <div class="col-md-9 border-end">
                                <div id="divDetalleDetalleCH"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divReporComprasCH"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>
<div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
    <i class="ri-error-warning-line me-3 align-middle fs-16"></i>
    <strong>¡ATENCIÓN!</strong>
    </br>
    Los documentos BE,BP,CC,TC y DJ van directamente a la cuenta de gasto. </br>No van al Registro de Compras.</br>
    Consultas y dudas =>
    <a href="mailto:SISTEMAS@CEP.ORG.PE" class="alert-link">CONTABILIDAD@CEP.ORG.PE</a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>