<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_general = new bo_general();
$bo_personas = new bo_gen_personas();

$ent_personas = new gen_personas();
$buscar = isset($_REQUEST['dato']) ? trim((string)$_REQUEST['dato']) : '';

if ($buscar === '') {
    echo '<div class="alert alert-danger shadow" role="alert">
            <strong>Atención:</strong> Ingrese un valor.
          </div>';
    exit;
}
if (preg_match('/^\d+$/', $buscar)) {
    $ent_personas->setNum_documento($buscar);
    $data_parti = $bo_personas->buscarTodoJson($ent_personas);
} elseif (preg_match('/[a-zA-Z]/', $buscar)) {
    $ent_personas->setNombre($buscar);
    $data_parti = $bo_personas->buscarTodoJson($ent_personas);
} else {
    echo '<div class="alert alert-warning shadow" role="alert">
            <strong>Atención:</strong> El valor ingresado no es válido.
          </div>';
    exit;
}
?>
<table class="table table-hover table-nowrap" id="table_listaParticipantes">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Grado</th>
            <th>Documento</th>
            <th>CEP</th>
            <th>Nombre</th>
            <th class="text-center">Optión</th>
        </tr>
    </thead>

    <body>
        <?php
        $i = 1;
        foreach ($data_parti as $par) { ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $par['c_persona'] ?></td>
                <td><?= $par['grado'] ?></td>
                <td><?= $par['num_documento'] ?></td>
                <td><?= $par['c_cmp'] ?></td>
                <td><?= $par['nombre_completo'] ?></td>
                <td class="text-center"><a href="#" onclick="javascrip:fn_control('<?= s_crypt($par['c_persona'], 'in') ?>', '<?= s_crypt('U', 'in') ?>')" class="btn btn-sm btn-soft-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar"><i class='fas fa-edit'></i></a></td>
            </tr>
        <?php $i++;
        } ?>
    </body>
</table>