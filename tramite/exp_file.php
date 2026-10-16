<?php
/*
 * Bloque de PDF del expediente.
 * El nombre del PDF se guarda en documentos_recibidos.documento_enviado.
 *
 * Lo incluye exp_taps_det_from.php, que debe definir antes:
 *   $cc_docrecibidos   -> id del expediente (sin cifrar)
 *   $documento_enviado -> valor actual de la columna documento_enviado
 *   $bloqueo_pdf       -> true cuando el expediente está bloqueado (archivado o con alguna
 *                         derivación ya recibida/atendida). Lo calcula exp_taps_det_from.php.
 *
 * Reglas:
 *   - Expediente bloqueado: nadie sube archivos y solo el superusuario (s_nivel() = 'A') puede eliminarlo.
 *   - Las mismas reglas se validan en el servidor en exp_file_update.php.
 */
$fileAdjunto = trim((string) ($documento_enviado ?? ''));
$esPdf       = ($fileAdjunto !== '' && preg_match('/\.pdf$/i', $fileAdjunto) === 1);
$valorPrevio = ($fileAdjunto !== '' && !$esPdf); // dato antiguo que no es un PDF subido por el sistema

$bloqueado     = !empty($bloqueo_pdf);
$esSuper       = (trim((string) s_nivel()) === 'A');
$puedeEliminar = (!$bloqueado || $esSuper);
?>

<hr class="border-info">
<?php if ($esPdf): ?>
    <p class="card-text mb-0">
        <?php
        $urlAdjunto = url('file_tramites/' . rawurlencode($fileAdjunto));
        ?>
        <a href="<?php echo $urlAdjunto; ?>" target="_blank" class="btn btn-outline-info">
            <i class="fa fa-file-pdf"></i> Ver / descargar PDF
        </a>
        <?php if ($puedeEliminar): ?>
            <button type="button" class="btn btn-danger ms-2"
                <?php echo $bloqueado ? 'title="Expediente bloqueado: solo el superusuario puede eliminar"' : 'title="Eliminar PDF"'; ?>
                onclick="fn_eliminarArchivo('<?php echo s_crypt($cc_docrecibidos); ?>','<?php echo s_crypt('EA'); ?>','<?php echo s_crypt($fileAdjunto); ?>')">
                <i class="fa fa-trash"></i>
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-danger ms-2" disabled title="Expediente bloqueado: solo el superusuario puede eliminar">
                <i class="fa fa-trash"></i>
            </button>
        <?php endif; ?>
        <?php if ($bloqueado): ?>
            <span class="text-muted ms-2"><i class="fa fa-lock"></i> Expediente bloqueado</span>
        <?php endif; ?>
    </p>

<?php elseif ($valorPrevio): ?>
    <div class="alert alert-warning mb-0">
        <i class="fa fa-exclamation-triangle"></i>
        Este expediente ya tiene un dato en <b>Documento enviado</b>:
        <b><?php echo htmlspecialchars($fileAdjunto); ?></b>.
        No se puede adjuntar un PDF para no sobrescribirlo.
    </div>

<?php elseif ($bloqueado): ?>
    <p class="text-muted mb-0"><i class="fa fa-lock"></i> Expediente bloqueado: no se pueden adjuntar archivos.</p>

<?php else: ?>
    <form action="javascript:;" enctype="multipart/form-data" id="frmSubirArchivo" novalidate>
        <label for="file_adjunto" class="btn btn-primary">
            <i class="fa fa-file-upload"></i> Subir documento en PDF
        </label>
        <div class="form-text">Solo archivos PDF. Máximo tamaño de archivo 5Mb.</div>
        <input class="d-none" type="file" name="file_adjunto" id="file_adjunto" onchange="fn_subirArchivo()" accept="application/pdf,.pdf">
        <input type="hidden" name="cc_docrecibidos" value="<?php echo s_crypt($cc_docrecibidos); ?>">
        <input type="hidden" name="opc" value="<?php echo s_crypt('UPLOAD'); ?>">
    </form>
<?php endif; ?>
