<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_det = new bo_gen_parametro_det();
$bo_personas = new bo_gen_personas();

$tipo = $_REQUEST["tipo"];
$c_local = $_REQUEST["c_local"] === '28' ? '' : $_REQUEST["c_local"];
$detalle = $_REQUEST["detalle"];

$grados = [
    'C' => 'COLEGIADOS',
    'E' => 'ESPECIALIDAD',
    'M' => 'MAESTRIA',
    'D' => 'DOCTORADO',
    'A' => 'AUDITORES',
    'P' => 'POS.DOCTORADO',
    'N' => 'LACTANCIA',
    'J' => 'CONCILIADOR EXTRAJUDICIAL'
];
switch ($detalle) {
    case '01':
        $data = $bo_personas->listar_cemd($c_local, $tipo);

?>
        <table class="table table-sm table-striped table-hover" id="table_cedm">
            <thead>
                <tr>
                    <th class="text-center" colspan="3">
                        <h2> <strong>TOTAL DE <?= $grados[$tipo]; ?> REGISTRADOS POR CR </strong></h2>
                    </th>
                </tr>
                <tr>
                    <th><strong>CR</strong></th>
                    <th><strong>NOMBRE</strong></th>
                    <th class="text-end"><strong>CANTIDAD</strong></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                $sum_data = array_sum(array_column($data, 'cantidad'));
                foreach ($data as $row) {
                ?>
                    <tr>
                        <td><?= $row["c_local"] ?></td>
                        <td><?= $row["nombre1"] ?></td>
                        <td class="text-end">
                            <?= decimal($row["cantidad"], 0) ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end"><strong>TOTAL==&gt;</strong></td>
                    <td class="text-end"><strong><?= decimal($sum_data, 0) ?></strong></td>
                </tr>
            </tfoot>

        </table>
    <?php
        break;
    case '02':
        $data_local = $bo_personas->listar_cemd_historico($c_local, $tipo);
        $cabnombre = "TODOS LOS CONSEJOS REGIONALES";
        if ($c_local > 0) {
            $data_cabecera = $bo_general->RegionID($c_local);
            foreach ($data_cabecera as $cab) {
                $cabnombre = $cab["nombre"];
            }
        }
    ?>
        <table class="table table-sm table-striped table-hover" id="table_cedm">
            <thead>
                <tr class="active">
                    <th class="text-center" colspan="15">
                        <h2>
                            <strong> REGISTRO DE <?= $grados[$tipo]; ?></strong><br>
                            <strong>[<?= $cabnombre ?>]</strong>
                        </h2>
                    </th>
                </tr>
                <tr class="text-end">
                    <th><strong>#</strong></th>
                    <th><strong>A&Ntilde;O</strong></th>
                    <th><strong>ENE</strong></th>
                    <th><strong>FEB</strong></th>
                    <th><strong>MAR</strong></th>
                    <th><strong>ABR</strong></th>
                    <th><strong>MAY</strong></th>
                    <th><strong>JUN</strong></th>
                    <th><strong>JUL</strong></th>
                    <th><strong>AGO</strong></th>
                    <th><strong>SEP</strong></th>
                    <th><strong>OCT</strong></th>
                    <th><strong>NOV</strong></th>
                    <th><strong>DIC</strong></th>
                    <th><strong>TOTAL</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $t = 0;
                $sum_data_hist = array_sum(array_column($data_local, 'total'));
                foreach ($data_local as $row) {
                    $i++;
                ?>
                    <tr class="text-end">
                        <td><?= $i ?></td>
                        <td><?= $row["c_year"] ?></td>
                        <td><?= decimal($row["ene"], 0) ?></td>
                        <td><?= decimal($row["feb"], 0) ?></td>
                        <td><?= decimal($row["mar"], 0) ?></td>
                        <td><?= decimal($row["abr"], 0) ?></td>
                        <td><?= decimal($row["may"], 0) ?></td>
                        <td><?= decimal($row["jun"], 0) ?></td>
                        <td><?= decimal($row["jul"], 0) ?></td>
                        <td><?= decimal($row["ago"], 0) ?></td>
                        <td><?= decimal($row["sep"], 0) ?></td>
                        <td><?= decimal($row["oct"], 0) ?></td>
                        <td><?= decimal($row["nov"], 0) ?></td>
                        <td><?= decimal($row["dic"], 0) ?></td>
                        <td><strong><?= decimal($row["total"], 0); ?></strong></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="14"><strong>TOTAL==&gt;</strong></td>
                    <td><strong><?= decimal($sum_data_hist, 0); ?></strong></td>
                </tr>
            </tfoot>

        </table>
<?php
        break;
    default:
        # code...
        break;
}
?>