<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

$data_anho = listarAnhos();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-0"><i class="ri-lock-2-line align-middle me-1 text-primary"></i> Cerrar períodos</h5>
                    <p class="text-muted fs-13 mb-0">Abre o cierra el período de cada módulo del consejo seleccionado.</p>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:fn_ListarCerrar();" id="frmBuscarCerrar" novalidate>
                    <div class="row g-2 align-items-end justify-content-center mb-3">
                        <div class="col-sm-3 col-md-2">
                            <label for="cerrar_anho" class="form-label text-muted fs-13 mb-1">Año</label>
                            <select name="anho" id="cerrar_anho" class="form-select" onchange="fn_ListarCerrar();">
                                <?php foreach ($data_anho as $row) { ?>
                                    <option value="<?php echo (int) $row['anho']; ?>" <?php echo ((int) $row['anho'] === (int) date('Y')) ? 'selected' : ''; ?>>
                                        <?php echo (int) $row['anho']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <?php bt_filtrar(); ?>
                        </div>
                    </div>
                </form>
                <div id="divListaCerrar"></div>
            </div>
        </div>
    </div>
</div>
