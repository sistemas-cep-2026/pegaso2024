<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Reporte de grados - trámites (BBVA)</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:fn_buscarReporteRecaudoGradosTramites()" id="fn_buscarReporteRecaudoGradosTramites">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" name="desde" title="Desde" class="form-control bg-white input-desde" placeholder="dd/mm/yyyy" value="<?= date('d/m/Y'); ?>" required>
                                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="text" name="hasta" title="Hasta" class="form-control bg-white input-hasta" placeholder="dd/mm/yyyy" value="<?= date('d/m/Y'); ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group mb-1">
                                <span class="input-group-text">Tipo:</span>
                                <select name="tipo" id="tipo" class="form-select" onchange="fn_buscarReporteRecaudoGradosTramites()" required>
                                    <option value="">Seleccione...</option>
                                    <option value="G">GRADOS</option>
                                    <option value="T">TRÁMITES</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1 row justify-content-center align-items-center">
                        <div class="col-md-2 text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                <div id="divListarReporteRecaudoGradosTramites" class="pt-2 table-responsive"></div>
            </div>
        </div>
    </div>
</div>
<?php
$include_scripts = fn() => importDatePicker() . importTypeahead() . importformmasks() . importDatatable();
?>