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

$data_ventas = $bo_ventas->listar($ent_ventas);
$data_ventas_total = $bo_ventas->sumarListar($ent_ventas);
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="table-light">
            <th>#</th>
            <th>FECHA</th>
            <th>DOCUMENTO</th>
            <th>CE/RUC</th>
            <th>A NOMBRE DE</th>
            <th>USUARIO</th>
            <th>TIPO</th>
            <th></th>
            <th class="text-end">SUB TOTAL</th>
            <th class="text-center">ESTADO</th>

            <th>MANT.</th>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total_general = 0;
            foreach ($data_ventas as $row) {
                $total_general += $row['valor_venta'];
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $row['fecha'] ?></td>
                    <td><?= $row['cod_documento'] . "-" . $row['num_documento'] ?></td>
                    <td><?= $row['codx'] ?></td>
                    <td><?= $row['nombrecolegiado'] ?></td>
                    <td><?= $row['usuario_registro'] ?></td>
                    <td><?= $row['cod_forma_de_pago_text'] ?></td>
                    <td><?php if ($row['cod_forma_de_pago'] == 'V') { ?>
                            <small><?= $row['nombre_banco'] . " " . $row['cta_cte_deposito'] . " | " . $row['num_referencia'] . " | " . $row['fecha_referencia'] ?></small>
                        <?php } ?>
                    </td>
                    <td class="text-end"><?= decimal($row['valor_venta'], 2) ?></td>
                    <td class="text-center">
                        <?php
                        echo u_estado($row["flag_text"], $color_flag_listar_caja[$row['flag']]);
                        ?>

                    </td>

                    <td><a href="#" onclick="redireccionar_ventana('<?php echo url('caja/recib_print?cod=' . s_crypt($row['cc_ventas'])); ?>', 750);" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                            <i class="fas fa-print"></i>
                        </a>
                        <?php if ($row['flag'] != 'A' && anulaRecibo($row['fecha'])): ?>
                            <a href="#" onclick="fn_anularRegistro('<?php echo s_crypt($row['cc_ventas']) ?>','<?php echo s_crypt('AL') ?>');" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"> <i class='fas fa-trash'></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="8" class="text-end">TOTAL =></th>
                <th class="text-end"><?php echo decimal($total_general, 2) ?></th>
            </tr>
        </tfoot>
    </table>
</div>