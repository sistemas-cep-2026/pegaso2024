<?php 
if (empty($ent_eventos->getImg_certificado())) {
?>
	<form action="javascript:;" enctype="multipart/form-data" id="frmSubirArchivo" novalidate>
		<label for="img_fondo" class="btn btn-primary btn-sm"><i class="fa fa-file-upload"></i> Subir diploma</label>
		<div class="form text">Máximo tamaño de archivo 500kb.</div>
		<input class="d-none" type="file" name="img_fondo" id="img_fondo" onchange="fn_subirArchivo()" accept="image/*">
		<input type="hidden" name="cc_evento" value="<?php echo s_crypt($cc_evento) ?>">
		<input type="hidden" name="opc" value="<?php echo s_crypt('UPLOAD') ?>">
	</form>
	<hr>
<?php
}
?>
<p class="card-text mb-0">
	<?php
	$url_diploma = "";
	$btn_elimina = "d-none";
	if (!empty($ent_eventos->getImg_certificado())) {
		$url_diploma = url('capacitacion/img/' . $ent_eventos->getImg_certificado());
		$btn_elimina = "";
	}
	?>
	<img src="<?php echo $url_diploma; ?>" alt="" class="img-fluid" id="img_fondo_container"><br><br>
	<button type="button" class="btn btn-danger btn-sm <?php echo $btn_elimina; ?>" 
    onclick="fn_eliminarArchivo('<?php echo s_crypt($cc_evento); ?>','<?php echo s_crypt('EA'); ?>','<?php echo $img_fondo; ?>')">
    <i class="fa fa-trash"></i> Eliminar
</button>
</p>