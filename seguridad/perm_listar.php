<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_perfil.php");
//require_once(u_src() . "bo/bo_gen_local.php");
s_validar_pagina();
//$bo_local = new bo_gen_local();
$bo_perfil = new bo_seg_perfil();

?>

<div class="mail-list mt-1">
	<?php
	$data_perfil = $bo_perfil->listarContar();
	foreach ($data_perfil as $row) {
		?>
		<a href="javascript:fn_asignaModulo('<?php echo $row["cc_perfil"] ?>');"><span class="ri-checkbox-blank-circle-line me-2 text-info"></span><span class="mail-list-link" data-type="label"><?php echo $row["ct_perfil"] ?></span> <span class="badge bg-success-subtle text-success ms-auto"><?php echo $row["cantidad"] ?></span></a>
	<?php } ?>
</div>

<form id="frmAsigPerfil" method="post">
	<input type="hidden" class="input-sm" name="cc_perfilb" id="cc_perfilb" />
</form>



