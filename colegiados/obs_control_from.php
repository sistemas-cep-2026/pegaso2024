<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas_obs_matricula.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personaobs = new bo_gen_personas_obs_matricula();
$bo_personas = new bo_gen_personas();

$ent_personaobs= new gen_personas_obs_matricula();

$cc_personaobs=s_crypt($_REQUEST['cc_personaobs'],'out');
$cc_persona=s_crypt($_REQUEST['cc_persona'],'out');

$ent_personaobs->setCc_personaobs($cc_personaobs);
$data_perobs=$bo_personaobs->listarID($ent_personaobs);
foreach ($data_perobs as $now) {
	 $ent_personaobs->setFecha_reportado($now["fecha_reportado_text"]);
	 $ent_personaobs->setFecha_respuesta($now["fecha_respuesta_text"]);
	 $ent_personaobs->setRespuesta($now["respuesta"]);
	 $ent_personaobs->setDoc_envio_numero($now["doc_envio_numero"]);
}

$data_personas=$bo_personas->listarShowID($cc_persona);
foreach ($data_personas as $pers) {
	$nombre=$pers['nombre'];
}

?>

<div class="modal-header">
	<h4 class="modal-title">Modificar registro</h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<form method="post" action="javascript:fn_grabarRegistro();" id="frmGrabarRegistro" novalidate>
		<div class="row ">
			<div class="col-md-12 col-12">
				<h4><?php echo $nombre ?></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-6">
				<div class="input-group mb-3">
					<span class="input-group-text">Fecha envio</span>
					<input type="date" class="form-control" id="fecha_reportado" name="fecha_reportado" aria-describedby="Detalle" placeholder="fecha envio" value="<?php echo $ent_personaobs->getFecha_reportado(); ?>" required>
				</div>
			</div>
			<div class="col-md-6 col-6">
				<div class="input-group mb-3">
					<span class="input-group-text">Fecha limite</span>
					<input type="date" class="form-control" id="fecha_respuesta" name="fecha_respuesta" aria-describedby="Fecha" placeholder="fecha envio"value="<?php echo $ent_personaobs->getFecha_respuesta(); ?>" required>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text"># Oficio </span>
					<input type="text" class="form-control" id="doc_envio_numero" name="doc_envio_numero" placeholder="0025-2024" value="<?php echo $ent_personaobs->getDoc_envio_numero(); ?>"  >
				</div>
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Observación </span>
					<input type="text" class="form-control" id="respuesta" name="respuesta" aria-describedby="Respuesta" placeholder="Respuesta" value="<?php echo $ent_personaobs->getRespuesta(); ?>" maxlength="250" oninput="contarRespuesta()" required>
					<small id="charCount">0/250</small>
				</div>
				
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="mb-3">
					<input type="hidden" class="form-control" name="cc_personaobs" value="<?php echo s_crypt($cc_personaobs, 'in') ?>">
					<?php echo bt_guardar(); ?>
					<?php echo bt_cerrar(); ?>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
    (function($) {
        $("#frmGrabarRegistro").validate();
    })(jQuery);
</script>

