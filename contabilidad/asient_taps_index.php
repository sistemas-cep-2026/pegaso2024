<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cont_voucher.php");
$bo_general = new bo_general();
$bo_voucher = new bo_cont_voucher();

$ent_voucher = new cont_voucher();


$flag='0';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_voucher = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';

$data_subdiario=$bo_general->subdiario();
$data_tpDoc=$bo_general->tipo_documento();


if($opc=='U'){
    $ent_voucher->setCc_voucher($cc_voucher);
    $data_voucher=$bo_voucher->listarID($ent_voucher);
    foreach($data_voucher as $vou){
        $ent_voucher->setCc_voucher($cc_voucher); 
        $ent_voucher->setC_persona($vou["c_persona"]); 
        $ent_voucher->setRazon_social($vou["razon_social"]); 
        $ent_voucher->setC_subdiario($vou["c_subdiario"]);
        $ent_voucher->setCod_documento($vou["cod_documento"]);             
        $ent_voucher->setNum_documento($vou["num_documento"]);
        $ent_voucher->setObservacion($vou["observacion"]); 
        $ent_voucher->setFecha($vou["fecha"]);             

    }
    $disabled_temp=' disabled';
}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header align-items-center d-flex border-0">
                <h4 class="card-title mb-0 flex-grow-1">Registro de asientos contables</h4>
                <div class="flex-shrink-0">
                   <h4><a href="#" onclick="fn_periodo('')"><span class="badge border border-success text-success"><?php echo $cc_loca_text." > ".s_periodo()." / ".s_anho() ?></span></a> </h4>
               </div>
           </div>
           <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
            <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">CREAR REGISTRO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="fn_BuscarVoucher();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">LISTAR REGISTROS</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
                    <form action="javascript:fn_guardarVoucher();" id="frmRegistroVoucher" novalidate>
                        <input type="hidden" name="cc_voucher" id="cc_voucher"  value="<?php echo s_crypt($cc_voucher,'in') ?>">
                        <input name="flag" id="flag" type="hidden" value="<?php echo $flag ?>">
                        <div class="row">
                            <div class="col-md-9 p-2 border-end">
                               <fieldset <?php echo $disabled; ?>>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Voucher: </span>
                                            <input type="text" class="form-control" id="voucher" name="voucher" value="<?php echo $ent_voucher->getVoucher(); ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Fecha : </span>
                                            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $ent_voucher->getFecha(); ?>" required >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group mb-3">
                                            <input type="hidden" class="form-control" id="c_persona" name="c_persona" value="<?php echo $ent_voucher->getC_persona(); ?>">
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ruc / Razón Social" value="<?php echo $ent_voucher->getRazon_social(); ?>" required >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Subdiario : </span>
                                            <select class="form-control" id="c_subdiario" name="c_subdiario"  required>
                                                <option value="">Selecciona</option>
                                                <?php
                                                foreach ($data_subdiario as $sub) { ?>
                                                    <option value="<?php echo $sub['c_subdiario']; ?>"<?php if ($ent_voucher->getC_subdiario() == $sub["c_subdiario"]) {
                                                        echo "selected";
                                                    } ?>><?php echo $sub['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Documento : </span>
                                            <select class="form-control" id="cod_documento" name="cod_documento"  required>
                                                <option value="">Selecciona</option>
                                                <?php
                                                foreach ($data_tpDoc as $doc) { ?>
                                                    <option value="<?php echo $doc['c_tipo_de_documento']; ?>"<?php if ($ent_voucher->getCod_documento() == $doc["c_tipo_de_documento"]) {
                                                        echo "selected";
                                                    } ?>><?php echo $doc['nombre']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Num. Doc.: </span>
                                            <input type="text" class="form-control" id="num_documento" name="num_documento" placeholder="000.000000" value="<?php echo $ent_voucher->getNum_documento(); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Obs: </span>
                                            <input type="text" class="form-control" id="observacion" maxlength="80" name="observacion" placeholder="Observación" value="<?php echo $ent_voucher->getObservacion(); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="hidden" name="cc_compra" value="<?php echo s_crypt($cc_compra,'in') ?>">
                                        <input type="hidden" name="opc" value="<?php echo s_crypt($opc,'in') ?>">
                                        <div class="row border-bottom mb-1 py-2"></div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-3">
                            <div class="mt-md-1">
                                <?php include 'asient_taps_botones.php'; ?>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="row">
                    <div class="col-md-9 border-end">
                        <div id="divDetalleDetallevoucher"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
                <div id="divlistarVoucher"></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks().importDatatable();
} ?>