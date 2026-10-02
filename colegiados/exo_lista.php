<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personas = new bo_gen_personas();

$c_local = $_REQUEST["c_local"] === '28' ? '' : $_REQUEST["c_local"];
$detalle = $_REQUEST["detalle"];

function flag_si_no($flag)
{
    switch ($flag) {
        case "*":
            $texto = "*NO*";
            break;
        case "&":
            $texto = "*SI*";
            break;
    }
    return $texto;
}

function motivo_exoneracion($tipo)
{
    switch ($tipo) {
        case "01":
            $texto = "Personal";
            break;
        case "02":
            $texto = "Trabajo";
            break;
        case "03":
            $texto = "Estudios";
            break;
    }
    return $texto;
}

switch ($detalle) {
    case 'C':
        $data = $bo_personas->listar_exo_total($c_local);

?>
        <table class="table table-sm table-striped table-hover" id="table_exo">
            <thead>
                <tr>
                    <th class="text-center" colspan="6">
                        <h2> <strong>TOTAL DE EXONERACIONES POR TIPO</strong></h2>
                    </th>
                </tr>
                <tr>
                    <th class="text-center" colspan="6">
                        <?= date('d/m/Y H:i:s') . " (" . s_usuario() . ")"; ?>
                    </th>
                </tr>
                <tr>
                    <th><strong>CR</strong></th>
                    <th><strong>NOMBRE</strong></th>
                    <th class="text-end"><strong>PERSONAL</strong></th>
                    <th class="text-end"><strong>TRABAJO</strong></th>
                    <th class="text-end"><strong>ESTUDIOS</strong></th>
                    <th class="text-end"><strong>TOTAL</strong></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 0;
                $sum_personal = array_sum(array_column($data, 'personal'));
                $sum_trabajo = array_sum(array_column($data, 'trabajo'));
                $sum_estudios = array_sum(array_column($data, 'estudios'));
                $sum_data_total = array_sum(array_column($data, 'total'));
                foreach ($data as $row) {
                ?>
                    <tr>
                        <td><?= $row["c_local"] ?></td>
                        <td><?= $row["nombre"] ?></td>
                        <td class="text-end">
                            <?= decimal($row["personal"], 0) ?>
                        </td>
                        <td class="text-end">
                            <?= decimal($row["trabajo"], 0) ?>
                        </td>
                        <td class="text-end">
                            <?= decimal($row["estudios"], 0) ?>
                        </td>
                        <td class="text-end">
                            <?= decimal($row["total"], 0) ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end"><strong>TOTAL==&gt;</strong></td>
                    <td class="text-end"><strong><?= decimal($sum_personal, 0) ?></strong></td>
                    <td class="text-end"><strong><?= decimal($sum_trabajo, 0) ?></strong></td>
                    <td class="text-end"><strong><?= decimal($sum_estudios, 0) ?></strong></td>
                    <td class="text-end"><strong><?= decimal($sum_data_total, 0) ?></strong></td>
                </tr>
            </tfoot>

        </table>
    <?php
        break;
    case 'D':
        $data_local = $bo_personas->listar_exo_detalle($c_local);
    ?>
        <table class="table table-sm table-striped table-hover" id="table_exo">
            <thead>
                <tr class="active">
                    <th class="text-center" colspan="9">
                        <h2>
                            <strong> DETALLE DE EXONERACIONES POR TIPO</strong>
                        </h2>
                    </th>
                </tr>
                <tr>
                    <th class="text-center" colspan="9">
                        <?= date('d/m/Y H:i:s') . " (" . s_usuario() . ")"; ?>
                    </th>
                </tr>
                <tr>
                    <th><strong>REG</strong></th>
                    <th><strong>FECHA</strong></th>
                    <th><strong>CR</strong></th>
                    <th><strong>NOMBRE</strong></th>
                    <th><strong>MOTIVO</strong></th>
                    <th><strong>PERIODO</strong></th>
                    <th><strong>RETORNO?</strong></th>
                    <th><strong>USUARIO</strong></th>
                    <th><strong>OBS</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $t = 0;
                $sum_data_hist = array_sum(array_column($data_local, 'total'));
                foreach ($data_local as $row) {
                    $i++;
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row["fecha"] ?></td>
                        <td><?= $row["c_local"] ?></td>
                        <td><?= $row["c_cmp"] . '-' . $row["nombre"]; ?></td>
                        <td><?= $row["motivo_text"]; ?></td>
                        <td><?= $row["mes_salida"] . '/' . $row["year_salida"] . ' => ' . $row["mes_retorno"] . '/' . $row["year_retorno"]; ?></td>
                        <td><?= flag_si_no($row["flag_no_retorno"]) ?></td>
                        <td><?= $row["usuario"] ?></td>
                        <td><?= $row["sustento"] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
<?php
        break;
    default:
        # code...
        break;
}
?>