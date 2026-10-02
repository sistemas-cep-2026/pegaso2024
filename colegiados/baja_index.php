<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nueva baja de colegiatura</h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12">
                        <form id="frmBuscarRegistro" action="javascript:fn_buscarRegistro();" method="post">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" name="nombres" id="nombres"
                                            placeholder="Buscar por CEP o apellidos y nombres" autofocus>
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <?= bt_buscar('Buscar'); ?>
                                    <?= bt_cancelar('Limpiar'); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 p-1" id="divListarRegistros"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$include_scripts = fn() => importTypeahead();