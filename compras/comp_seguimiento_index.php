<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_general = new bo_general();
$bo_compras = new bo_comp_documentos_de_compras();

$data_anho = listarAnhos();
$periodo = u_meses();
$cc_local = s_local();
$usuario = s_usuario();
$data_region = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
//$data_tipodoc = $bo_compras->listaTipoDocumento();
$data_tipodoc = $bo_compras->listaTipoDocumento_caja();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Seguimiento del Documentos (Compras->Bancos->Contabilidad)</h5>
                    </div>

                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form method="post" action="javascript:fn_buscarRegistro();" id="frmFormRegistro" novalidate>
                    <div class="row g-3 justify-content-center">

                        <div class="col-sm-2">
                            <select name="cc_local" id="cc_local" class="form-control" required onchange="submit()">
                               
                                <?php
                                foreach ($data_region as $loc) { ?>
                                    <option value="<?php echo $loc['c_local']; ?>" <?= ($loc['c_local'] === s_local_vinculado()) ? 'selected' : '' ?>><?php echo $loc['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!--<div class="col-sm-1">
                            <select name="anho" id="anho" class="form-control">

                                <?php foreach ($data_anho as $row) { ?>
                                    <option value="<?php echo $row['anho']; ?>" <?php if ($row['anho'] == date("Y")) {
                                                                                    echo "selected";
                                                                                } ?>>
                                        <?php echo $row['anho']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>-->
                        <div class="col-xxl-3 col-sm-3">
                            <div class="search-box">
                                <input type="hidden" class="form-control" name="cc_persona" value="">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="RUC - Razón Social" value="" required>
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="cod_documento" name="cod_documento" <?php echo $disabled_temp ?> required>
                                 
                                <?php
                                foreach ($data_tipodoc as $uni) { ?>
                                    <option value="<?php echo $uni['c_tipo_de_documento']; ?>"><?php echo $uni['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-xxl-2 col-sm-2">
                            <div class="search-box">
                                <input type="text" class="form-control" id="num_documento" name="num_documento" placeholder="Numero" value="" required>
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-sm-6">
                            <?php echo bt_filtrar("Buscar") ?>
                            <button class="btn btn-outline-warning waves-effect" onclick="location.reload();">
                                <i class="fas fa-ban"></i>
                                <span>Cancelar</span>
                            </button>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="col-xxl-12">
                <div class="card-body">
                    <div id="div_documentos"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $include_scripts = function () {
    return importDatatable() . importTypeahead();
} ?>