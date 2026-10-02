<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_guias_de_entrada.php");
require_once(u_src() . "bo/bo_gen_articulos.php");

$opc = 'I';
$bo_items_guia= new bo_alm_items_guias_de_entrada();
$bo_articulo = new bo_gen_articulos();

$ent_items = new alm_items_guias_de_entrada();
$ent_articulo = new gen_articulos();

 
$cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
$flag = $_REQUEST["flag"];
 

$ent_items->setCc_guia($cc_guia);
$data_deta = $bo_items_guia->ListarIdGuia($ent_items);
global $data_deta;
$ent_articulo->setC_local($c_local);
$data_art = $bo_articulo->listarSelect($ent_articulo);
 //echo $cc_guia;
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
                        <th class="col-1 text-center">Opción</th>
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
                            <td><?php echo decimal($act['cantidad'],0); ?></td>
                            <td><?php echo $act['unidad'] ?></td>
                            <?php if ($flag === 'P') { ?>
                                <td class="text-center">
                                    <a href="javascript: fn_eliminarDetalle('<?php echo s_crypt($act["cc_guia_det"], 'in') ?>','<?php echo s_crypt('E', 'in') ?>');">
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