<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");

$bo_general = new bo_general();
$bo_comprobantes = new bo_banc_comprobantes_de_caja();

$cc_local_sesion = s_local();
$usuario_sesion = s_usuario();
$es_admin_general = ($cc_local_sesion === '28');

$data_anho = $bo_comprobantes->listarAnhosGeneral();
$meses = u_meses();

// el combo de consejos regionales solo se arma para el admin general;
// para un consejo regional normal ni siquiera se consulta la lista.
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
                <form class="row g-2 align-items-end" id="frmFiltroBancos" action="javascript:fn_filtrarBancos()" novalidate>
                    <div class="col-sm-2">
                        <label class="form-label text-muted fs-13 mb-1">Año</label>
                        <select class="form-control" id="anho" name="anho" onchange="submit()">
                            <?php foreach ($data_anho as $a): ?>
                                <option value="<?= $a['anho'] ?>" <?= ($a['anho'] == date('Y')) ? 'selected' : '' ?>>
                                    <?= $a['anho'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label text-muted fs-13 mb-1">Mes</label>
                        <select class="form-control" id="mes" name="mes" onchange="submit()">
                            <option value="">Todos</option>
                            <?php foreach ($meses as $key => $value): ?>
                                <option value="<?= htmlspecialchars($key) ?>" <?= ($key == date('m')) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($value) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($es_admin_general): ?>
                        <div class="col-sm-4">
                            <label class="form-label text-muted fs-13 mb-1">Consejo Regional</label>
                            <select class="form-control" id="c_local" name="c_local" onchange="submit()">
                                <?php foreach ($data_local as $loc): ?>
                                    <option value="<?= $loc['c_local'] ?>" <?= ($loc['c_local'] == $cc_local_sesion) ? 'selected' : '' ?>>
                                        <?= $loc['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <!-- no es admin general: el consejo queda fijo en el propio, sin selector -->
                        <input type="hidden" id="c_local" name="c_local" value="<?= $cc_local_sesion ?>">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="divDashBancos"></div>

<?php
$include_scripts = function () {
    return importapexcharts();
};
?>
