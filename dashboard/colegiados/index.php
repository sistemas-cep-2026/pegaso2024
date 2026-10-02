<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");

$bo_general = new bo_general();
$bo_documentos_venta = new bo_fin_documentos_de_venta();

$cc_local_sesion = s_local();
$usuario_sesion = s_usuario();
$es_admin_general = ($cc_local_sesion === '28');

$data_anho = $bo_documentos_venta->listarAnhos();
$meses = u_meses();

$data_local = $es_admin_general
    ? $bo_general->listarRegionesAdministrativo($cc_local_sesion, $usuario_sesion, 'A')
    : [];
?>
<style>
    .s0 {
        opacity: .05;
        fill: var(--vz-info)
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-n4 mx-n4">
            <div class="bg-info-subtle">
                <div class="card-body pb-0 px-4">
                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="row align-items-center g-3">
                                <div class="col-md">
                                    <div>
                                        <h4 class="fw-bold">Filtros</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <form class="row g-2 align-items-end" id="frmFiltroColegiacionDashboard" action="javascript:fn_listarDatosColegiadosDashboard()" novalidate>
                                                <div class="col-sm-3">
                                                    <label class="form-label text-muted fs-13 mb-1">Año</label>
                                                    <select class="form-control" id="anho" name="anho" onchange="submit()">
                                                        <option value="9999" selected>Todos</option>
                                                        <?php
                                                        foreach ($data_anho as $a) {
                                                            if($a['anho'] == date('Y')-5) {
                                                                break;
                                                            }
                                                        ?>
                                                            <option value="<?= $a['anho'] ?>">
                                                                <?= $a['anho'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php if ($es_admin_general): ?>
                                                    <div class="col-sm-6">
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
                                                    <!-- no es admin general: el consejo queda fijo en el propio, sin selector (regla 1 y 3) -->
                                                    <input type="hidden" id="c_local" name="c_local" value="<?= $cc_local_sesion ?>">
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<div class="row">
    <div class="col-lg-12" id="divlistarColegiacionDashboard"><?= cargador(); ?></div>
</div>

<?php
$include_scripts = function () {
    return importapexcharts();
};
?>