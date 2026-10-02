<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_articulos.php");
$bo_general = new bo_general();
$bo_articulo = new bo_gen_articulos();

$ent_articulo = new gen_articulos();
$nombre = isset($_REQUEST["conceptos"]) ? $_REQUEST["conceptos"] : "";

$ent_articulo->setNombre($nombre);
$ent_articulo->setC_usuario(s_usuario());

$data_articulos = $bo_articulo->listarUsuarios($ent_articulo, 20);
$data_conp_user = $bo_articulo->ConceptoUsuario($ent_articulo);

?>
<div class="row">
    <div class="col-md-6 mb-3">
        <h4>Conceptos Generales</h4>
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="col-1">#</th>
                        <th class="col-10">Nombre</th>
                        <th class="col-1 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data_articulos as $conc) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $conc["nombre_concepto"] ?></td>
                            <td class="text-center">
                                <a href="#" onclick="fn_asignarConcepto('<?= $conc['c_articulo'] ?>','<?= s_usuario() ?>','<?= 'I' ?>'); return false;">
                                    <i class='fas fa-star text-success'></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <h4>Concetos al usuario <?= s_usuario() ?> </h4>
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="col-1">#</th>
                        <th class="col-10">Nombre</th>
                        <th class="col-1 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data_conp_user as $user) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $user["nombre_articulo"] ?></td>
                            <td class="text-center">
                                <a href="#" onclick="fn_eliminarConcepto('<?= $user['c_articulo'] ?>','<?= s_usuario() ?>','<?= 'E' ?>'); return false;">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>