<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_personas = new bo_gen_personas();

$grado = $_REQUEST["grado"];
$desde = $_REQUEST["desde"];

switch ($grado) {
    case 'R':
        $data = $bo_personas->listarPersonasBajaRegistro($desde);
        break;
    default:
        $data = $bo_personas->listar_cemd_rango($grado, $desde);
        break;
}

if (empty($data)) {
    echo errors();
    return;
}
$grados = [
    'C' => 'COLEGIADOS REGISTRADOS POR CR',
    'E' => 'ESPECIALIDAD REGISTRADOS POR CR',
    'M' => 'MAESTRIA REGISTRADOS POR CR',
    'D' => 'DOCTORADO REGISTRADOS POR CR',
    'A' => 'AUDITORES REGISTRADOS POR CR',
    'P' => 'POS.DOCTORADO POR CR',
    'N' => 'LACTANCIA POR CR',
    'J' => 'CONCILIADOR EXTRAJUDICIAL POR CR',
    'R' => 'DESAFILIACION (RENUNCIA) POR CR',
];
?>
<div class="row">
    <div class="col-12 text-center">
        <h4><?= $grados[$grado] ?></h4>
    </div>
</div>
<table class="table table-borderless table-sm" style="max-width: 550px;">
    <thead>
        <tr class="table-active">
            <th>NRO REGISTRO</th>
            <th>CR LOCAL</th>
            <th>NOMBRES Y APELLIDOS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data as $row) {
        ?>
            <tr>
                <td><?= digitos($row["c_cmp"],6) ?></td>
                <td><?= "CR" . $row["c_local_colegiacion"] ?></td>
                <td><?= $row["nombre"] ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>