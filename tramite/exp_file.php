<?php
$fileAdjunto  = $ent_doc_recibidos->getFile_adjunto();
$tieneAdjunto = !empty($fileAdjunto);
?>

<?php if (!$tieneAdjunto): ?>
    <hr class="border-info">
    <form action="javascript:;" enctype="multipart/form-data" id="frmSubirArchivo" novalidate>
        <label for="file_adjunto" class="btn btn-primary">
            <i class="fa fa-file-upload"></i> Subir documento en PDF
        </label>
        <div class="form-text">Solo archivos PDF. Máximo tamaño de archivo 2Mb.</div>
        <input class="d-none" type="file" name="file_adjunto" id="file_adjunto" onchange="fn_subirArchivo()" accept="application/pdf,.pdf">
        <input type="hidden" name="cc_docrecibidos" value="<?php echo s_crypt($cc_docrecibidos); ?>">
        <input type="hidden" name="opc" value="<?php echo s_crypt('UPLOAD'); ?>">
    </form>

<?php else: ?>
    <hr class="border-info">
    <p class="card-text mb-0">
        <?php
        $urlAdjunto = url('file_tramites/' . rawurlencode($fileAdjunto));
        ?>
        <a href="<?php echo $urlAdjunto; ?>" target="_blank" class="btn btn-outline-info">
            <i class="fa fa-file-pdf"></i> Ver / descargar PDF
        </a>
        <button type="button" class="btn btn-danger ms-2" onclick="fn_eliminarArchivo('<?php echo s_crypt($cc_docrecibidos); ?>','<?php echo s_crypt('EA'); ?>','<?php echo s_crypt($fileAdjunto); ?>')" <?php //echo $disabled 
                                                                                                                                                                                                            ?>>
            <i class="fa fa-trash"></i>
        </button>
    </p>
<?php endif; ?>