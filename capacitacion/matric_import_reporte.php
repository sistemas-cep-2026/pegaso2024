<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula_temp.php");

$bo_temp = new bo_cap_eventos_matricula_temp();
$ent_temp = new cap_eventos_matricula_temp();

$cc_evento = s_crypt($_REQUEST['cc_evento'], 'out');
$ent_temp->setCc_evento($cc_evento);

$data = $bo_temp->listarComparativo($ent_temp);

$total = count($data);
$coinciden = 0;
foreach ($data as $row) {
    if ($row['coincide'] == 'SI') $coinciden++;
}
$nuevos = $total - $coinciden;
?>
<div class="row mb-2">
    <div class="col-lg-4">
        <div class="alert alert-secondary mb-0 text-center">Total: <b><?php echo $total ?></b></div>
    </div>
    <div class="col-lg-4">
        <div class="alert alert-success mb-0 text-center">Coinciden: <b><?php echo $coinciden ?></b></div>
    </div>
    <div class="col-lg-4">
        <div class="alert alert-warning mb-0 text-center">Nuevos: <b><?php echo $nuevos ?></b></div>
    </div>
</div>
<div class="table-responsive" style="max-height: 300px; overflow-y:auto;">
    <table class="table table-sm table-hover">
        <thead class="table-light">
            <tr>
                <th>CEP</th>
                <th>DNI</th>
                <th>NOMBRE</th>
                <th class="text-center">A</th>
                <th class="text-center">P</th>
                <th class="text-center">C</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td><?php echo $row['cep'] ?></td>
                    <td><?php echo $row['num_documento'] ?></td>
                    <td><?php echo $row['nombre'] ?></td>
                    <td class="text-center"><?php echo $row['asistente'] == '1' ? 'SI' : '' ?></td>
                    <td class="text-center"><?php echo $row['ponente'] == '1' ? 'SI' : '' ?></td>
                    <td class="text-center"><?php echo $row['organizador'] == '1' ? 'SI' : '' ?></td>
                    <td class="text-center">
                        <?php if ($row['coincide'] == 'SI') { ?>
                            <span class="badge bg-success">COINCIDE</span>
                        <?php } else { ?>
                            <span class="badge bg-warning text-dark">NUEVO</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php if ($total > 0) { ?>
    <div class="text-center mt-2">
        <button type="button" class="btn btn-success" onclick="fn_procesarImport('<?php echo s_crypt($cc_evento, 'in') ?>')">
            <i class="ri-check-line align-bottom me-1"></i> Procesar (<?php echo $total ?>)
        </button>
    </div>
<?php } ?>
