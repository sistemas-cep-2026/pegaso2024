<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_fin_estado_cuenta_periodo_detalle.php");
require_once(u_src() . "bo/bo_gen_entidad_pagadora.php");

$bo_general = new bo_general();
$bo_entidad_pagad = new bo_gen_entidad_pagadora();
$bo_planillaminsa = new bo_fin_estado_cuenta_periodo_detalle();

$ent_pagadora = new gen_entidad_pagadora();
$ent_planillaminsa = new fin_estado_cuenta_periodo_detalle();

$cc_local = (s_local() === '28') ? '' : s_local();

$periodo            = $_POST['periodo'] ?? '';

$ent_planillaminsa->setCc_local($cc_local);
$ent_planillaminsa->setPeriodo($periodo);

$data_plan_essalud = $bo_planillaminsa->PlanillaEssalud($ent_planillaminsa);

$fechaActual = fecha_hora_hoy();
$usuario = s_usuario();

$headerReporte = '
<div class="d-flex justify-content-between align-items-center mb-1">
  <div class="text-center flex-fill">
    <h3 class="fw-semibold text-uppercase mb-0">PLANILLAS ESSALUD POR PERIODO</h3>
    <small class="text-muted">Periodo: ' . htmlspecialchars($periodo) . '</small>
  </div>
  <div class="text-end ms-3">
    <small class="text-muted d-block">Fecha: ' . htmlspecialchars($fechaActual) . '</small>
    <small class="text-muted d-block">Usuario: ' . htmlspecialchars($usuario) . '</small>
  </div>
</div>';

echo '<script>var headerContent = ' . json_encode($headerReporte) . ';</script>';
?>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered align-middle" id="table-minsa">
        <thead class="table-light text-center">
            <tr>
                <th scope="col">#</th>
                <th scope="col">ENTIDAD</th>
                <th scope="col">CANTIDAD</th>
                <th scope="col" class="text-end">IMPORTE</th>
                <th scope="col" class="text-end">%RETENCIÓN</th>
                <th scope="col" class="text-end">TRANS AL CR</th>
                <th scope="col" class="text-end">CN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $cantidad = 0;
            $total_importe = 0;
            $total_imp_porc = 0;
            foreach ($data_plan_essalud as $row) {
                $cantidad += $row['cantidad'];
                $total_importe += $row['importe'];
                $total_imp_porc += $row['importe_porcentaje'];
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><a href="#" onclick="fn_verPlanillaEssalud('<?php echo s_crypt($periodo, 'in'); ?>', '<?php echo s_crypt($row['cc_local'], 'in'); ?>')"><?= $row['nombre_entidad'] ?></a> </td>
                    <td class="text-center"><?= $row['cantidad'] ?></td>
                    <td class="text-end"><?= decimal($row['importe'], 2) ?></td>
                    <td class="text-center"><?= decimal($row['porc_cotizacion'], 0) ?></td>
                    <td class="text-end"><?= decimal($row['importe'] - $row['porc_cotizacion'], 2) ?></td>
                    <td class="text-end"><?= decimal($row['importe_porcentaje'], 2) ?></td>

                </tr>
            <?php $i++;
            } ?>
        </tbody>
        <tfoot class="fw-bold">
            <tr>
                <td colspan="2" class="text-end">TOTAL=></td>
                <td class="text-center"><?= $cantidad ?></td>
                <td class="text-end"><?= decimal($total_importe, 2) ?></td>
                <td class="text-center">--</td>
                <td class="text-end "><?= decimal($total_importe - $total_imp_porc, 2) ?></td>
                <td class="text-end "><?= decimal($total_imp_porc, 2) ?></td>
            </tr>

        </tfoot>
    </table>
</div>