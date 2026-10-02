<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
require_once(u_src() . "bo/bo_fin_puntos_de_venta.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_ventas = new bo_fin_documentos_de_venta();

$ent_ventas = new fin_documentos_de_venta();

$ent_ventas->setC_local($_REQUEST['c_local']);
$ent_ventas->setCod_desde(u_fecha($_REQUEST['cod_desde']));
$ent_ventas->setCod_hasta(u_fecha($_REQUEST['cod_hasta']));
$ent_ventas->setFlag($_REQUEST['flag']);

$data_ventas = $bo_ventas->reporte_listar($ent_ventas);
$data_ventas_total = $bo_ventas->sumarListar($ent_ventas);
?>
<div class="table-responsive">
    <table class="table table-hover table-sm" id="table-reporte">
        <thead class="table-light">
            <th># </th>
            <th>FECHA</th>
            <th>DOCUMENTO</th>
            <th>CEP/RUC</th>
            <th>A NOMBRE DE</th>
            <th>USUARIO</th>
        
        
            <th class="text-end">TOTAL</th>
            <th class="text-center">ESTADO</th>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total_original = 0;
            foreach ($data_ventas as $row) {
                $total_original += $row['total_original'];
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $row['fecha'] ?></td>
                    <td>
                        <a href="#" onclick="redireccionar_ventana('<?php echo url('caja/recib_print?cod=' . s_crypt($row['cc_ventas'])); ?>', 750);">
                            <?= $row['cod_documento'] . "-" . $row['num_documento'] ?>
                        </a>
                    </td>
                    <td><?= $row['c_cmp'].'-'.$row['ruc'] ?></td>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['usuario_registro'] ?></td>
                    
                    <td class="text-end"><?= decimal($row['total_original'], 2) ?></td>
                    <td class="text-center">
                        <?php
                        echo u_estado($row["flag_text"], $color_flag_listar_caja[$row['flag']]);
                        ?>

                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="7" class="text-end">TOTAL =></th>
                <th class="text-end"><?php echo decimal($total_original, 2) ?></th>
            </tr>
        </tfoot>
    </table>
</div>