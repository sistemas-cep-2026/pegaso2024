<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_prestamos_socios.php");


$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_prestamos_socios = new bo_prestamos_socios();
$ent = new prestamos_socios();

$ent->setC_local($_REQUEST['c_local']);
$ent->setCod_desde(u_fecha($_REQUEST['cod_desde']));
$ent->setCod_hasta(u_fecha($_REQUEST['cod_hasta']));
$ent->setFlag($_REQUEST['flag']);

$data = $bo_prestamos_socios->listar($ent);

?>
<div class="table-responsive">
    <table class="table table-hover table-sm" id="table-reporte">
        <thead class="table-light">
            <th># </th>
            <th>FECHA</th>
            <th>FRACCIONAMIENTO</th>
            <th>CEP</th>
            <th>NOMBRE</th>
            <th>USUARIO</th>
            <th>REGION</th>
            <th>DEUDA</th>
            <th>CUOTAS</th>
            <th>MONTO CUOTA</th>
            <th>ESTADO</th>

        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($data as $row) {
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $row['fecha'] ?></td>
                    <td>
                        <a href="#" onclick="redireccionar_ventana('<?php echo url('caja/fracc_print?cod=' . s_crypt($row['cc_fraccionamiento'])); ?>', 750);">
                            <?= $row['cc_fraccionamiento'] ?>
                        </a>
                    </td>
                    <td><?= $row['c_cmp'] ?></td>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['c_usuario'] ?></td>
                    <td><?= $row['c_local'] ?></td>
                    <td><?= $row['capital'] ?></td>
                    <td><?= $row['num_cuotas'] ?></td>
                    <td><?= $row['valor_cuota'] ?></td>


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
                <th colspan="11" class="text-end"></th>

            </tr>
        </tfoot>
    </table>
</div>