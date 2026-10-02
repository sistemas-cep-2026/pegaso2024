<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Lista de Pre-Registro de Colegiación</h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12">
                        <form id="frmBuscarRegistro" action="javascript:fn_buscarRegistro();">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" name="varbuscar" id="varbuscar"
                                            placeholder="Buscar por documento de identidad o apellidos y nombres" autofocus>
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <?= bt_buscar(); ?>
                                    <?= bt_cancelar('Limpiar', 'onclick="fn_buscarRegistro()"'); ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 p-2" id="divListarRegistros"><?= cargador(); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>