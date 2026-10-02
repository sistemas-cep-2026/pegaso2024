<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();
$data_local = $bo_general->listar28Regiones();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Ingreso de trámites</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:fn_buscarTramites()" id="fn_buscarTramites">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" name="desde" title="Desde" class="form-control bg-white input-desde" placeholder="dd/mm/yyyy" value="<?= date('d/m/Y', strtotime(restarDias(7))); ?>" required>
                                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="text" name="hasta" title="Hasta" class="form-control bg-white input-hasta" placeholder="dd/mm/yyyy" value="<?= date('d/m/Y'); ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group mb-1">
                                <span class="input-group-text">Origen:</span>
                                <select name="c_local_origen" id="c_local_origen" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    foreach ($data_local as $co) {
                                    ?>
                                        <option value="<?php echo $co['cc_local'] ?>"><?php echo $co['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1 row justify-content-center align-items-center">
                        <div class="col-sm-9">
                            <div class="input-group mb-1">
                                <span class="input-group-text">Nombre:</span>
                                <input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" placeholder="Nombre" value="">
                            </div>
                        </div>
                        <!-- <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <span class="input-group-text">N°:</span>
                                <input type="text" class="form-control" id="num_documento" name="num_documento" placeholder="# Documento" value="">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group mb-1">
                                <span class="input-group-text">Exp.:</span>
                                <input type="text" class="form-control" id="c_expediente" name="c_expediente" placeholder="Expediente" value="">
                            </div>
                        </div> -->
                    </div>
                    <div class="mb-1 row justify-content-center align-items-center">
                        <div class="col-md-2 text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                <div id="divListarTramites" class="pt-2 table-responsive"></div>
            </div>
        </div>
    </div>
</div>
<?php
$include_scripts = fn() => importDatePicker() . importTypeahead() . importformmasks() . importDatatable();
?>