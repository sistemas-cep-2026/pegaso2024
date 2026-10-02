<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">LISTAR COLEGIADOS PARA CARNET</h5>       
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" action="javascript:fn_buscarRegistro();" role="form" id="frmBuscarRegistro">
                    <div class="d-flex flex-column mb-1">
                        <div class="row justify-content-center mb-1">
                            <div class="col-sm-3 pt-4">
                                <?= input_checkbox("Activa Unico o Lista", 'option', 'V', 'false', 'lista') ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="cepinicio" class="form-label">CEP único o inicial:</label>
                                <input class="form-control" required type="number" placeholder="CEP Unico o Lista" name="cepinicio" id="cepinicio" autofocus>
                            </div>
                            <div class="col-sm-3">
                                <label for="cepfinal" class="form-label">CEP final:</label>
                                <input class="form-control" required type="number" placeholder="CEP Final" name="cepfinal" id="cepfinal" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <?= bt_buscar() ?>
                            <?= bt_cancelar() ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-12 shadow p-3 mb-5 bg-white rounded">
                <div id="divListarRegistro"></div>
            </div>
        </div>
    </div>
</div>
 <?php $include_scripts = fn() => importDatatable(); ?>