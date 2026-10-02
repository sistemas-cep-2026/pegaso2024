<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$data_region=$bo_general->listarRegiones();
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">REPORTE DE DERIVACIONES</h4>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center text-center">
                    <form class="needs-validation" id="frmFormRegistro" action="javascript:fn_ListarRegistro()" method="post" novalidate>
                        <div class="mb-1 row justify-content-center align-items-center">
                            <div class="col-sm-3">
                                <div class="d-flex">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="input-group mb-0">
                                            <span class="input-group-text">SEDE : </span>
                                            <select name="cc_local" id="cc_local" class="form-control"  onChange="fn_listar_banco(this.value)">
                                                <?php echo generarOpcionesRegion($data_region, s_local()); ?>
                                            </select>
                                        </div>                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="d-flex">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="input-group mb-0">
                                            <span class="input-group-text">Exp. Inicial : </span>
                                            <input type="number" class="form-control" id="num_inicio" name="num_inicio" placeholder="" value="1" >
                                        </div>                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="d-flex">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="input-group mb-0">
                                            <span class="input-group-text">Exp. Final : </span>
                                            <input type="number" class="form-control" id="num_final" name="num_final" placeholder="" value="1" >
                                        </div>                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="d-flex">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="input-group mb-0">
                                            <span class="input-group-text">Gestión : </span>
                                            <input type="number" class="form-control" id="gestion" name="gestion" placeholder="" value="07" >
                                        </div>                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 text-start">
                                <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="card-body pt-2">
                        <div id="div_derivaciones"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
