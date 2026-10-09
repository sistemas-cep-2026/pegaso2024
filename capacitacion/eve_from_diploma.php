<?php
$campos_imagen = [
	'img_ponente' => [
		'label' => 'diploma del ponente',
		'valor' => $ent_eventos->getImg_ponente(),
	],
	'img_asistente' => [
		'label' => 'diploma del asistente',
		'valor' => $ent_eventos->getImg_asistente(),
	],
];
foreach ($campos_imagen as $campo => $info):
	$valor = $info['valor'];
	if (strtoupper(trim((string) $valor)) === 'NULL') {
		$valor = '';
	}
?>
	<div class="mb-4">
		<h6 class="text-muted text-uppercase fs-12 mb-2"><?= ucfirst($info['label']) ?></h6>

		<?php if (empty($valor)): ?>
			<form action="javascript:;" enctype="multipart/form-data" id="frmSubirArchivo_<?= $campo ?>" class="frm-subir-diploma" novalidate>
				<label for="<?= $campo ?>" class="btn btn-primary btn-sm"><i class="fa fa-file-upload"></i> Subir <?= $info['label'] ?></label>
				<div class="form text">Máximo tamaño de archivo 500kb.</div>
				<input class="d-none" type="file" name="<?= $campo ?>" id="<?= $campo ?>" onchange="fn_subirArchivo('<?= $campo ?>')" accept="image/*">
				<input type="hidden" name="cc_evento" value="<?php echo s_crypt($cc_evento) ?>">
				<input type="hidden" name="opc" value="<?php echo s_crypt('UPLOAD') ?>">
			</form>
		<?php else: ?>
			<p class="card-text mb-0">
				<img src="<?php echo url('capacitacion/img/' . $valor); ?>" alt="" class="img-fluid" id="<?= $campo ?>_container"><br><br>
				<button type="button" class="btn btn-danger btn-sm"
					onclick="fn_eliminarArchivo('<?php echo s_crypt($cc_evento); ?>','<?php echo s_crypt('EA'); ?>','<?php echo htmlspecialchars($valor); ?>','<?= $campo ?>')">
					<i class="fa fa-trash"></i> Eliminar
				</button>
			</p>
		<?php endif; ?>
	</div>
	<?php if ($campo === 'img_ponente'): ?>
		<hr>
	<?php endif; ?>
<?php endforeach; ?>