<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas_obs_matricula.php");

$bo_personaobs = new bo_gen_personas_obs_matricula();

$ent_personaobs= new gen_personas_obs_matricula();


$var=$_REQUEST["nombre"];

if (is_numeric($var)) {
	$ent_personaobs->setCep($var);
}else{
	$ent_personaobs->setNombre($var);
}


$data_per=$bo_personaobs->listar($ent_personaobs);
?>
<div class="table-responsive">
	<table class="table table-nowrap" id="table-reporte">
		<thead>
			<tr class="table-active">
				<th class="col-md-1">#</th>
				<th class="col-md-2">NOMBRE</th>
				<th class="col-md-1">CELULAR</th>
				<th class="col-md-1">CORREO</th>
				<th class="col-md-1">FEC. ENV</th>
				<th class="col-md-1">FEC. FIN</th>
				<th class="col-md-4">OBS</th>
				<th class="col-md-1 ">OPCION</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i=1;
			foreach ($data_per as $per) {
				?>
				<tr >
					<td><?php echo $i ?></td>
					<td><?php echo $per['cep']." - ".$per['nombre'] ?></td>
					<td><?php echo $per['celular'] ?></td>
					<td><?php echo $per['correo'] ?></td>
					<td><?php echo $per['fecha_envio'] ?></td>
					<td><?php echo $per['fecha_respuesta_text'] ?></td>
					<td><?php echo $per['respuesta'] ?></td>
					<td class="text-center">
						<a href="javascript:fn_controlObs('<?php echo s_crypt($per['cc_personaobs'],'in') ?>','<?php echo s_crypt($per['c_persona'],'in') ?>')" class="text-primary"><i class="fas fa-edit fa-1x"></i></a>
					</td>
				</tr>
				<?php $i++;
			} ?>
		</tbody>
	</table>
</div>