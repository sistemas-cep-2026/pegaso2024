<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_banc_excel_migrar.php");

// Entidad para migración de ingresos
$bo_excel = new bo_banc_excel_migrar();
$data_cantidad = $bo_excel->cantidad();
$cantidad = (int)($data_cantidad[0]['cantidad'] ?? 0);

$mostrar_nuevo = ($cantidad === 0);
$mostrar_procesar_limpiar = ($cantidad > 0);
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0 me-3">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
                            <i class="ri-file-excel-2-line"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0">MIGRACIÓN DE EXCEL - INGRESOS</h4>
                        <p class="text-muted mb-0 fs-13">Importar registros desde archivo .xlsx</p>
                    </div>
                </div>
            </div>

            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <div class="d-flex gap-2 flex-wrap">
                    <?php if ($mostrar_nuevo): ?>
                        <button type="button" class="btn btn-success" onclick="fn_nuevo()" title="Cargar nuevo archivo Excel">
                            <i class="ri-add-line align-bottom me-1"></i> Nuevo
                        </button>
                    <?php endif; ?>
                    <?php if ($mostrar_procesar_limpiar): ?>
                        <button type="button" class="btn btn-warning" onclick="fn_procesar()" title="Ejecutar migración">
                            <i class="ri-play-line align-bottom me-1"></i> Procesar
                        </button>
                        <button type="button" class="btn btn-danger" onclick="fn_limpiar()" title="Eliminar todos los registros">
                            <i class="ri-delete-bin-line align-bottom me-1"></i> Limpiar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="divListarExcel"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header border-0">
                <h5 class="card-title mb-0">
                    <i class="ri-guide-line align-bottom me-2"></i>
                    Formato para migración
                </h5>
            </div>

            <div class="card-body">
                <p class="fs-13 text-muted mb-3">
                    Descargue el formato oficial de plantilla <strong>antes de preparar</strong> la información.
                    El archivo Excel debe respetar exactamente la estructura proporcionada.
                </p>
                <div class="alert alert-warning alert-border-left alert-dismissible fade show" role="alert">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="ri-alert-fill align-bottom"></i>
                        </div>
                        <div class="flex-grow-1">
                            <strong>Importante</strong><br>
                            <small>
                                El archivo Excel debe respetar estrictamente el formato
                                proporcionado, incluyendo el orden y estructura de las columnas.
                                La modificación del formato puede generar errores durante la
                                migración. La correcta preparación y contenido de la información
                                son responsabilidad del usuario.
                            </small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <button type="button" class="btn btn-primary w-100 mb-2" onclick="fn_descargarPlantilla()">
                    <i class="ri-download-2-line align-bottom me-1"></i>
                    Descargar formato Excel
                </button>
                <div class="alert alert-info alert-sm mt-3 mb-0">
                    <small>
                        <i class="ri-information-line align-bottom me-1"></i>
                        <strong>Columnas esperadas:</strong>
                    </small>
                    <small class="d-block mt-2">
                        1. Fecha (YYYY-MM-DD)<br>
                        2. Operación<br>
                        3. Monto<br>
                        4. Referencia 1<br>
                        5. Referencia 2<br>
                        6. Cuenta Contable<br>
                        7. Banco<br>
                        8. Cuenta Bancaria
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>