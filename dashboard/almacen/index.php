<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_alm_dashboard.php");

$bo_general = new bo_general();
$bo_dash_alm = new bo_alm_dashboard();

$cc_local_sesion = s_local();
$usuario_sesion = s_usuario();
$es_admin_general = ($cc_local_sesion === '28');

$data_anho = $bo_dash_alm->listarAnhos();
if (empty($data_anho)) {
    $data_anho = [['anho' => date('Y')]];
}
$meses = u_meses();

// Solo el Consejo Nacional elige consejo; los demás ven siempre el suyo (se fuerza también en el listar).
$data_local = $es_admin_general
    ? $bo_general->listarRegionesAdministrativo($cc_local_sesion, $usuario_sesion, 'A')
    : [];
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Filtros</h5>
            </div>
            <div class="card-body">
                <form class="row g-2 align-items-end" id="frmFiltroAlmacen" action="javascript:fn_filtrarAlmacen()" novalidate>
                    <div class="col-sm-2">
                        <label class="form-label text-muted fs-13 mb-1">Año</label>
                        <select class="form-control" id="anho" name="anho" onchange="fn_filtrarAlmacen()">
                            <?php foreach ($data_anho as $a): ?>
                                <option value="<?= (int) $a['anho'] ?>" <?= ((int) $a['anho'] === (int) date('Y')) ? 'selected' : '' ?>><?= (int) $a['anho'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label text-muted fs-13 mb-1">Mes</label>
                        <select class="form-control" id="mes" name="mes" onchange="fn_filtrarAlmacen()">
                            <option value="">Todos</option>
                            <?php foreach ($meses as $key => $value): ?>
                                <option value="<?= htmlspecialchars($key) ?>" <?= ($key == date('m')) ? 'selected' : '' ?>><?= htmlspecialchars($value) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($es_admin_general): ?>
                        <div class="col-sm-4">
                            <label class="form-label text-muted fs-13 mb-1">Consejo</label>
                            <select class="form-control" id="c_local" name="c_local" onchange="fn_filtrarAlmacen()">
                                <?php foreach ($data_local as $loc): ?>
                                    <option value="<?= htmlspecialchars(trim($loc['c_local'])) ?>" <?= (trim($loc['c_local']) == $cc_local_sesion) ? 'selected' : '' ?>><?= htmlspecialchars(trim($loc['nombre'])) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" id="c_local" name="c_local" value="<?= htmlspecialchars($cc_local_sesion) ?>">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="divDashAlmacen"></div>

<?php
// El JS (dashboard/js/jalmacen.js) lo carga index.php al final; aquí solo se agrega ApexCharts.
$include_scripts = function () {
    return importapexcharts();
};
?>
