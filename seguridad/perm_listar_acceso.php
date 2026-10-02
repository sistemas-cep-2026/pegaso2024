<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_modulo.php");
require_once(u_src() . "bo/bo_seg_perfil.php");
s_validar_pagina();
$bo_modulo      = new bo_seg_modulo();
$bo_perfil      = new bo_seg_perfil();

$cc_perfil      = $_REQUEST["cc_perfil"];
$date_padre = $bo_modulo->listarPadre();

$data_per=$bo_perfil->listarId($cc_perfil);
foreach ($data_per as $per) {
	$nomre_perf=$per["ct_perfil"];
}

?>
<div class="row">
	<div class="col-xl-12">
		<div class="card-header">
			<h4 class="card-title mb-2"><?php echo $nomre_perf ?></h4>
		</div><!-- end card header -->

		<div class="card-body">
			<p class="text-muted">Asigne el módulo correspondiente</p>

			<div class="mx-n3">
				<div data-simplebar style="max-height: 580px;" class="px-3">
					<form action="javascript:fn_grabarAsigModulo();" role="form" id="frmAsigModuloPerfil">
						<input type="hidden" name="cc_perfil" value="<?php echo $cc_perfil; ?>">
						<?php foreach ($date_padre as $pa) { ?>
							<div class="row">
								<div class="col-md-6">
									<div class="col-12">
								<h4><i class="fas <?php echo $pa["mod_ico"] ?>"></i> <?php echo $pa["mod_nombre"] ?></h4>
								<div class="ms-1 mb-1"><i class="fas fa-puzzle-piece"></i> Procesos</div>
							</div>
							<?php $date_nieto = $bo_modulo->listarSubmenu($pa["cc_modulo"], $cc_perfil, 'P');
							foreach ($date_nieto as $nie) {
								$check = "";
								if ($nie["n"] > 0) {
									$check = 'checked';
								}
								?>
								<div class="ms-2 mb-1">
									<?php echo input_checkbox($nie["mod_nombre"], 'cc_modulo[]', $nie["cc_modulo"], $check,'cc_modulo'.$nie["cc_modulo"]) ?>
								</div>
							<?php } ?>
								</div>
								<div class="col-md-6">
									<div class="ms-1 mb-1"><i class="fas fa-signal"></i> Reportes</div>
							<?php $date_nieto = $bo_modulo->listarSubmenu($pa["cc_modulo"], $cc_perfil, 'R');
							foreach ($date_nieto as $nie) {
								$check = "";
								if ($nie["n"] > 0) {
									$check = 'checked';
								}
								?>
								<div class="ms-2 mb-1">
									<?php echo input_checkbox($nie["mod_nombre"], 'cc_modulo[]', $nie["cc_modulo"], $check,'cc_modulo'.$nie["cc_modulo"]) ?>
								</div>
							<?php } ?>
								</div>
							</div>
							<hr class="bg-Secondary">
						<?php } ?>
					</form>
				</div>
			</div>
		</div><!-- end card-body -->

	</div>
</div>

<script>
    $('input[name="cc_modulo[]"]').on('click',function(){
        fn_grabarAsigModulo();
    });
</script>
