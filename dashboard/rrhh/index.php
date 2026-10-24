<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");


$cc_local_sesion = s_local();
$usuario_sesion = s_usuario();
$es_admin_general = ($cc_local_sesion === '28');
$anho_actual = (int)date('Y');
$meses = u_meses();

$data_local = [];
if ($es_admin_general) {
    $bo_general = new bo_general();
    $data_local = $bo_general->listarRegionesAdministrativo($cc_local_sesion, $usuario_sesion, 'A');
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Filtros</h5>
            </div>
            <div class="card-body">
                <form class="row g-2 align-items-end" id="frmFiltroRrhh" action="javascript:void(0)" novalidate>
                    <div class="col-sm-2">
                        <label class="form-label text-muted fs-13 mb-1">Año</label>
                        <select class="form-control" id="anho" name="anho">
                            <?php for ($a = $anho_actual; $a >= $anho_actual - 2; $a--): ?>
                                <option value="<?= $a ?>" <?= ($a === $anho_actual) ? 'selected' : '' ?>><?= $a ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label text-muted fs-13 mb-1">Mes</label>
                        <select class="form-control" id="mes" name="mes">
                            <option value="">Todos</option>
                            <?php foreach ($meses as $key => $value): ?>
                                <option value="<?= htmlspecialchars($key) ?>" <?= ((string)$key === date('m')) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($value) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($es_admin_general): ?>
                        <div class="col-sm-4">
                            <label class="form-label text-muted fs-13 mb-1">Consejo Regional</label>
                            <select class="form-control" id="c_local" name="c_local">
                                <option value="">Todos los consejos</option>
                                <?php foreach ($data_local as $loc): ?>
                                    <option value="<?= htmlspecialchars(trim((string)$loc['c_local'])) ?>">
                                        <?= htmlspecialchars($loc['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" id="c_local" name="c_local" value="<?= htmlspecialchars((string)$cc_local_sesion) ?>">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<p class="text-muted fs-13 mb-2"><i class="ri-calendar-line me-1"></i>Indicadores del período: <span class="fw-medium">Octubre 2026</span></p>
<div class="row">
    <div class="col-sm-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Permisos</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">14</h4>
                        <p class="text-muted mb-0 fs-13">2 anulado(s)</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                            <i class="ri-door-open-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Horas extras</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">26:15 h</h4>
                        <p class="text-muted mb-0 fs-13">9 registro(s)</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                            <i class="ri-time-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Asistencia</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">12 <small class="fs-13 text-muted fw-normal">persona(s)</small></h4>
                        <p class="text-muted mb-0 fs-13">230 día(s)-persona</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                            <i class="ri-fingerprint-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Permanencia</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">8:13 h</h4>
                        <p class="text-muted mb-0 fs-13">promedio diario</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-secondary-subtle text-secondary rounded-circle fs-4">
                            <i class="ri-timer-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Usuarios activos</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">40</h4>
                        <p class="text-muted mb-0 fs-13">7 inactivo(s)</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                            <i class="ri-team-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>