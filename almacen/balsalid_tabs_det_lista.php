<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_guias_de_salida.php");
require_once(u_src() . "bo/bo_gen_articulos.php");

$opc = 'I';
$bo_itemguia = new bo_alm_items_guias_de_salida();
$bo_articulo = new bo_gen_articulos();

$ent_itemguia = new alm_items_guias_de_salida();
$ent_articulo = new gen_articulos();

//$opc=s_crypt($_REQUEST["opc"],'out');
$cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
$flag = $_REQUEST["flag"];

$ent_itemguia->setCc_guia($cc_guia);
$data_deta = $bo_itemguia->ListarIdGuia($ent_itemguia);
// global $data_deta;
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
                        <th class="col-6">Artículo</th>
                        <th class="col-2">Unidad</th>
                        <th class="col-2">Cantidad</th>
                        <?php if ($flag === 'P') { ?>
                            <th class="col-1 text-center">Opción</th>
                            <th class="col-1 text-center">Stock</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data_deta as $act) {
                    ?>
                        <tr class="<?php echo ($act['stock_actual'] < $act['cantidad'] && $flag =='P') ? 'table-danger' : ''; ?>">
                            <td><?php echo $i ?></td>
                            <td><?php echo $act["c_articulo"] ?></td>
                            <td><?php echo $act["nombre_articulo"] ?></td>
                            <td><?php echo $act["unidad"] ?></td>
                            <td><?php echo decimal($act['cantidad'],0); ?></td>
                            <?php if ($flag === 'P') { ?>
                                <td class="text-center">
                                    <a href="javascript: fn_eliminarDetalle('<?php echo s_crypt($act["cc_guia_det"], 'in') ?>','<?php echo s_crypt('E', 'in') ?>');">
                                        <i class='fas fa-window-close text-danger'></i>
                                    </a>
                                </td>
                                <td><?php echo decimal($act['stock_actual'],0); ?></td>
                            <?php } ?>

                            
                            
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>