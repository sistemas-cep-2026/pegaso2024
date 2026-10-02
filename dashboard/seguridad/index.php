<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");

$bo_usuarios = new bo_seg_usuarios();

$cc_local = s_local();
// c_local='28' es el administrador general: debe ver el consolidado de todos los
// consejos regionales; cualquier otro local ve solo el suyo.
$c_local_filtro = ($cc_local === '28') ? '' : $cc_local;

$data_usuario = $bo_usuarios->Dash_UserLocal($c_local_filtro);

$total_activos = 0;
$total_inactivos = 0;
foreach ($data_usuario as $row) {
    $total_activos += (int)$row['activos'];
    $total_inactivos += (int)$row['inactivos'];
}

$ambito_text = ($cc_local === '28') ? 'todos los consejos regionales' : ($data_usuario[0]['nombre'] ?? 'su consejo regional');

// aviso de clave vulnerable para el usuario de la sesión actual
$ent_usuarios = new seg_usuarios();
$ent_usuarios->setUsuario(s_usuario());
$data_sua = $bo_usuarios->listarId($ent_usuarios);
$cambio = '';
$nombre_completo = '';
foreach ($data_sua as $row) {
    $cambio = $row['cambio'];
    $nombre_completo = $row['nombre'];
}
?>
<?php if ($cambio === 'SI') { ?>
    <div class="alert alert-danger alert-border-left alert-dismissible fade shadow show" role="alert">
        <i class="ri-error-warning-line me-3 align-middle"></i> <strong>¡Atención <?= $nombre_completo ?>!</strong> - Su clave actual es vulnerable. Si no la cambia, corre el riesgo de robo de información y acceso no autorizado. <strong><a href="?<?php echo s_crypt('100000', 'in') ?>&sec=<?php echo s_crypt('3', 'in') ?>&your_fa=<?php echo s_crypt(s_cpersona(), 'in') ?>"> Personalice su clave aquí</a></strong>.
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Usuarios activos</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_activos ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">en <?= htmlspecialchars($ambito_text) ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                            <i class="ri-user-follow-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Usuarios inactivos</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_inactivos ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">en <?= htmlspecialchars($ambito_text) ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                            <i class="ri-user-unfollow-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Usuarios por consejo regional</h5>
                <p class="text-muted mb-0 fs-13">Activos e inactivos</p>
            </div>
            <div class="card-body">
                <?php if (empty($data_usuario)): ?>
                    <div class="text-center p-4 text-muted">Sin usuarios registrados.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Consejo regional</th>
                                    <th class="text-center">Activos</th>
                                    <th class="text-center">Inactivos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_usuario as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['nombre']) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success"><?= (int)$user['activos'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger-subtle text-danger"><?= (int)$user['inactivos'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Usuarios: activos vs inactivos</h5>
                <p class="text-muted mb-0 fs-13"><?= htmlspecialchars(ucfirst($ambito_text)) ?></p>
            </div>
            <div class="card-body">
                <?php if (($total_activos + $total_inactivos) === 0): ?>
                    <div class="text-center p-4 text-muted">Sin datos.</div>
                <?php else: ?>
                    <div id="usuarios_activos_donut_chart"
                        data-colors='["--vz-success", "--vz-danger"]'
                        data-series="<?= htmlspecialchars(json_encode([$total_activos, $total_inactivos]), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$include_scripts = function () {
    return importapexcharts();
};
?>
