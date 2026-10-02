<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="modal-header bg-light border-bottom">
    <h5 class="modal-title" id="modalRegistroLabel">
        <i class="ri-upload-cloud-2-line align-bottom me-2"></i>
        Cargar archivo Excel
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    <form id="frmImportarExcel" action="javascript:fn_cargarExcel();" method="post" novalidate>
        <div class="alert alert-info mb-3">
            <i class="ri-lightbulb-line align-bottom me-2"></i>
            <strong>Paso 1:</strong> Descargue la plantilla oficial<br>
            <strong>Paso 2:</strong> Complete los datos en el archivo<br>
            <strong>Paso 3:</strong> Seleccione el archivo y cargue
        </div>
        <div class="mb-3">
            <label for="archivo_import" class="form-label">
                <i class="ri-file-xlsx-line align-bottom me-1"></i>
                Seleccionar archivo (.xlsx)
            </label>
            <div class="input-group">
                <input type="file" class="form-control" id="archivo_import" name="archivo_import" accept=".xlsx" required>
                <span class="input-group-text">
                    <i class="ri-file-excel-line"></i>
                </span>
            </div>
            <small class="text-muted d-block mt-1">
                Solo se aceptan archivos con formato .xlsx
            </small>
        </div>

        <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="ri-close-line align-bottom me-1"></i>
                Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="ri-upload-2-line align-bottom me-1"></i>
                Cargar / Importar
            </button>
        </div>
    </form>
</div>