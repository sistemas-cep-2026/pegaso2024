<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_documentos_enviados.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_documentos = new bo_tram_documentos_enviados();

$ent_documentos = new tram_documentos_enviados();

$cc_local = s_local_vinculado();
$flag = '0';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_docenviado = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';

$tipo_persona = $bo_parametro_detalle->listarParametroDet("documentos_recibidos1", "tipo_persona");

$data_doc = $bo_general->tipo_documento('T');
//$data_cargos = $bo_general->listarCargos();
$sede = (s_local() == '28') ? 'CN' : 'CR';
$data_area = $bo_general->AreaAdministrativa($sede);

$gestion = s_gestion();

$disabled = '';
$ent_documentos->setFecha(date('Y-m-d'));
if ($opc === 'U') {
    $ent_documentos->setCc_docenviado($cc_docenviado);
    $dat_ac = $bo_documentos->listarId($ent_documentos);
    foreach ($dat_ac as $act) {
        $ent_documentos->setNum_documento($act["num_documento"]);
        $ent_documentos->setC_tipo_de_documento($act["c_tipo_de_documento"]);
        $ent_documentos->setAsunto($act["asunto"]);
        $ent_documentos->setC_area_adm_usuario($act["c_area_adm_usuario"]);
        $ent_documentos->setC_area_adm_doc($act["c_area_adm_doc"]);
        $ent_documentos->setAsunto($act["asunto"]);
        $ent_documentos->setTipo_persona($act["tipo_persona"]);
        $flag=$act["flag"];
        
        $opc=($flag=='*') ? '*' : 'U';

        $disabled =  'disabled';
    }
    $disabled_temp = ' disabled';
}

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header align-items-center d-flex border-0">
                <h4 class="card-title mb-0 flex-grow-1">EMISIÓN DE EXPEDIENTES</h4>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">CREAR REGISTRO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_Buscar();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">LISTAR REGISTROS</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
                        <form action="javascript:fn_guardarDocumento();" id="frmRegistroDocumento" novalidate>
                            <input type="hidden" name="flag" id="flag" value="<?php echo $flag ?>">
                            <input  type="hidden" name="cc_local" id="cc_local" value="<?php echo $cc_local ?>">
                            <input  type="hidden" name="gestion" id="gestion" value="<?php echo $gestion ?>">
                            <input  type="hidden" name="cc_docenviado" id="cc_docenviado" value="<?php echo s_crypt($cc_docenviado, 'in') ?>">
                          
                            <input  type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                            <div class="row">
                                <div class="col-md-9 p-2 border-end">
                                    <fieldset <?php echo $disabled; ?>>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">N° Documento : </span>
                                                    <input type="number" class="form-control" id="num_documento" name="num_documento" value="<?php echo $ent_documentos->getNum_documento(); ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Fecha Doc. : </span>
                                                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $ent_documentos->getFecha(); ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bx bx-user me-1"></i> Remitente</span>
                                                    <select name="tipo_persona" id="tipo_persona" class="form-control" onchange="mostrarCamposExtras()" required>
                                                        <?php foreach ($tipo_persona as $fl) { ?>
                                                            <option value="<?php echo $fl['cc_codigo'] ?>" <?php if ($ent_documentos->getTipo_persona() === $fl['cc_codigo']) echo "selected"; ?>>
                                                                <?php echo $fl['detalle'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Area Usuario : </span>
                                                    <select name="c_area_adm_usuario" id="c_area_adm_usuario" class="form-control" required>
                                                        <?php foreach ($data_area as $car) { ?>
                                                            <option value="<?php echo $car['cc_area_adm'] ?>" <?php if ($ent_documentos->getC_area_adm_usuario() === $car['cc_area_adm']) echo "selected"; ?>>
                                                                <?php echo $car['nombre'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Tipo Documento. : </span>
                                                    <select id="c_tipo_de_documento" name="c_tipo_de_documento" class="form-control select2" required>
                                                        <?php foreach ($data_doc as $doc): ?>
                                                            <option value="<?= $doc['c_tipo_de_documento'] ?>"
                                                                <?= $ent_documentos->getC_tipo_de_documento() === $doc['c_tipo_de_documento'] ? 'selected' : '' ?>>
                                                                <?= $doc['nombre'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Área de Origen : </span>
                                                    <select name="c_area_adm_doc" id="c_area_adm_doc" class="form-control" required>
                                                        <?php foreach ($data_area as $car) { ?>
                                                            <option value="<?php echo $car['cc_area_adm'] ?>" <?php if ($ent_documentos->getC_area_adm_doc() === $car['cc_area_adm']) echo "selected"; ?>>
                                                                <?php echo $car['nombre'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden"
                                                name="c_area_adm_doc"
                                                id="c_area_adm_doc_hidden"
                                                disabled>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Asunto : </span>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="asunto"
                                                        name="asunto"
                                                        value="<?php echo htmlspecialchars($ent_documentos->getAsunto() ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                                        style="text-transform: uppercase;"
                                                        oninput="this.value = this.value.toUpperCase();"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">

                                                
                                                
                                                <div class="row border-bottom mb-1 py-2"></div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <div class="mt-md-1">
                                        <?php include 'documen_taps_botones.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-9 border-end">
                                <div id="divDetalleDetalleDoc"></div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="div_listarDoc"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable() . importSelect2();
} ?>
 