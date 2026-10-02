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

$cc_local           = $_POST['c_local'] ?? '';
$c_entidad_pagadora = $_POST['c_entidad_pagadora'] ?? '';
$cod_anho           = $_POST['cod_anho'] ?? '';
$cod_mes            = $_POST['cod_mes'] ?? '';

$ent_planillaminsa->setC_entidad_pagadora($c_entidad_pagadora);
$ent_planillaminsa->setC_periodo($cod_mes . '/' . $cod_anho);

$data_plan_minsa = $bo_planillaminsa->listarPlanilla($ent_planillaminsa);

$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $local_nombre = $loc['nombre'] ?? '';
}
$ent_pagadora->setC_entidad_pagadora($c_entidad_pagadora);
$data_pegadora = $bo_entidad_pagad->listarID($ent_pagadora);
foreach ($data_pegadora as $pag) {
    $nombre_pagadora = $pag['nombre_entidad'] ?? '';
}

$headerReporte = '
<div class="text-center">
  <h3 class="mb-1 fw-semibold text-uppercase">
    PLANILLAS POR ENTIDADES MINSA, FAP, UNIVERSIDADES, OTROS - ' . htmlspecialchars($local_nombre) . '
  </h3>
  <small class="d-block text-muted">
    Entidad: ' . htmlspecialchars($nombre_pagadora) . ' | Periodo: ' . htmlspecialchars($cod_mes) . ' / ' . htmlspecialchars($cod_anho) . '
  </small>
</div>';

echo '<script>var headerContent = ' . json_encode($headerReporte) . ';</script>';

$data_plan_minsa_total = $bo_planillaminsa->listarPlanillaTotales($ent_planillaminsa);
?>
<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered align-middle" id="table-minsa">
        <thead class="table-light text-center">
            <tr>
                <th scope="col">#</th>
                <th scope="col">FECHA</th>
                <th scope="col">CEP</th>
                <th scope="col">NOMBRE</th>
                <th scope="col">VÍNCULO</th>
                <th scope="col">DOC</th>
                <th scope="col">OBS</th>
                <th scope="col" class="text-end">MONTO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($data_plan_minsa as $row) { ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= ($row['flag_grabado'] === '*') ? $row['fecha'] : '--' ?></td>
                    <td><?= $row['c_cmp'] ?></td>
                    <td><?= $row['nombre_colegiado'] ?></td>
                    <td><?= $row['ddirecto'] ?></td>
                    <td class="text-nowrap"><?= $row['cod_documento'] . "-" . $row['boleta'] ?></td>
                    <td><?= $row['observacion'] ?></td>
                    <td class="text-end"><?= decimal($row['importe'], 2) ?></td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
        <tfoot class="fw-bold">
            <tr>
                <td colspan="5" class="text-end">Vínculo</td>
                <td class="text-end">Sustento</td>
                <td class="text-end">Ingreso</td>
                <td class="text-end ">Sub Total</td>
            </tr>
            <?php
            $total = 0.0;
            $ingreso = 0;

            if (!empty($data_plan_minsa_total) && is_array($data_plan_minsa_total)) {
                foreach ($data_plan_minsa_total as $tot) {
                    $ddirecto      = $tot['ddirecto']      ?? '';
                    $cod_documento = $tot['cod_documento'] ?? '';
                    $boleta        = $tot['boleta']        ?? '';
                    $cantidad      = (float)($tot['cantidad'] ?? 0);
                    $subtotal      = (float)($tot['total'] ?? 0);

                    $total   += $subtotal;
                    $ingreso += $cantidad;
            ?>
                    <tr>
                        <td colspan="5" class="text-end"><?= htmlspecialchars($ddirecto) ?></td>
                        <td class="text-end text-nowrap"><?= htmlspecialchars($cod_documento . '-' . $boleta) ?></td>
                        <td class="text-end"><?= decimal($cantidad, 0) ?></td>
                        <td class="text-end text-nowrap"><?= decimal($subtotal, 2) ?></td>
                    </tr>
            <?php }
            } ?>
            <tr>
                <td colspan="6" class="text-end">TOTAL=&gt;</td>
                <td class="text-end"><?= decimal($ingreso, 0) ?></td>
                <td class="text-end text-nowrap"><?= decimal($total, 2) ?></td>
            </tr>
        </tfoot>
    </table>
</div>