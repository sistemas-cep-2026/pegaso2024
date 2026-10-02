<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_requisicion.php");
require_once(u_src() . "bo/bo_gen_articulos.php");

$opc = 'I';
$bo_items_requisicion= new bo_alm_items_requisicion();
$bo_articulo = new bo_gen_articulos();

$ent_items = new alm_items_requisicion();
$ent_articulo = new gen_articulos();

 
$cc_requisicion = s_crypt($_REQUEST["cc_requisicion"], 'out');
$flag = $_REQUEST["flag"];

$ent_items->setCc_requisicion($cc_requisicion);
$data_deta = $bo_items_requisicion->ListarIdGuia($ent_items);
global $data_deta;
$ent_articulo->setC_local($c_local);
$data_art = $bo_articulo->listarSelect($ent_articulo);
 
?>
<div class="row">
    <div class="col-12">
        <?php if (count($data_deta) > 0) { ?>
            <table class="table table-striped-columns">
                <thead class="table-light">
                    <tr>
                        <th class="col-1">#</th>
                        <th class="col-2">C&oacute;digo</th>
                        <th class="col-8">Artículo</th>
                        <th class="col-2">Cantidad</th>
                        <th class="col-2">Unidad</th>
                        <?php if ($flag === '&') { ?>
                        <th class="col-1 text-center">Opción</th>
                       
                      
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data_deta as $act) {
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $act["c_articulo"] ?></td>
                            <td><?php echo $act["nombre_articulo"] ?></td>
                            <td><?php echo $act['cantidad'] ?></td>
                            <td><?php echo $act['unidad'] ?></td>
                            <?php if ($flag === '&') { ?>
                                <td class="text-center">
                                    <a href="javascript: fn_eliminarDetalle('<?php echo s_crypt($act["cc_requisicion_det"], 'in') ?>','<?php echo s_crypt('E', 'in') ?>');">
                                        <i class='fas fa-window-close text-danger'></i>
                                    </a>
                                </td>
                                  
                            <?php } ?>

                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>