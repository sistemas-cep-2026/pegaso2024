 <?php
 require_once(dirname(__DIR__) . "/util/seguridad.php");
 require_once(dirname(__DIR__) . "/util/util.php");
 require_once(u_src() . "bo/bo_general.php");
 require_once(u_src() . "bo/bo_gen_parametro_det.php");
 require_once(u_src() . "bo/bo_seg_usuarios.php");
  require_once(u_src() . "bo/bo_seg_perfil.php");
 s_validar_pagina();
 //$cc_local=s_local();
 $bo_general = new bo_general();
 $bo_usuarios = new bo_seg_usuarios();
 $bo_perfil = new bo_seg_perfil();
 $bo_gen_parametro_det = new bo_gen_parametro_det();

 $ent_usuarios=new seg_usuarios();
 $ent_perfil=new seg_perfil();

 $opc = s_crypt($_REQUEST['opc'],'out');
 $usuario = s_crypt($_REQUEST['usuario'],'out');

 if($opc=='C'){
 	$ent_usuarios->setUsuario($usuario);
 	$data_usuarios=$bo_usuarios->listarId($ent_usuarios);
 	foreach ($data_usuarios as $row) {
 		$usuario=$row['usuario'];
 		$nombre=$row['nombre'];
 		$cc_perfil=$row['cc_perfil'];
 		$tp_user=$row['tp_user'];
 	}
 }
$ent_perfil->setFlag('A');
 $data_perfil=$bo_perfil->listar($ent_perfil);
 ?>
 <div class="modal-header">
 	<h4 class="modal-title">Reinicar Clave</h4>
 	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
 </div>
 <div class="modal-body">
 	<form method="post" action="javascript:fn_ActualizarClave();" id="frmGrabarClave" novalidate>
 		<div class="row">
 			<div class="col-md-7 col-12">
 				<div class="input-group mb-3">
 					<span class="input-group-text">Nombre: </span>
 					<input type="text" class="form-control"  placeholder="Nombre" value="<?php echo $nombre ?>" disabled>
 				</div>
 			</div>
 			<div class="col-md-5 col-12">
 				<div class="input-group mb-3">
 					<span class="input-group-text">Usuario: </span>
 					<input type="text" class="form-control"  placeholder="Nombre" value="<?php echo $usuario ?>" disabled>
 				</div>
 			</div>
 		</div>
 		<div class="row">
 			<div class="col-md-6 col-12">
 				<div class="input-group mb-3">
 					<span class="input-group-text">Perfil: </span>
 					<select name="cc_perfil" id="cc_perfil" class="form-control">
 						<option value="">Seleccione...</option>
 						<?php
 						foreach ($data_perfil as $perf) { ?>
 							<option value="<?php echo $perf['cc_perfil']; ?>" <?php echo $perf['cc_perfil']===$cc_perfil  ? 'selected' : ''; ?> ><?php echo $perf['ct_perfil']; ?></option>
 						<?php } ?>
 					</select>
 				</div>
 			</div>
 			<div class="col-md-6 col-12">
 				<div class="input-group mb-3">
 					<span class="input-group-text">clave: </span>
 					<input type="text" class="form-control" id="clave" name="clave" placeholder="clave" value="<?php echo generarContrasenaSegura(9) ?>">
 				</div>
 			</div>
 			
 		</div>
 		<div class="row">
 			
 			<div class="col-md-6 col-12">
 				<div class="input-group mb-3">
 					<span class="input-group-text">Segundo: </span>
 					<input type="text" class="form-control" id="tiempo_sesion" name="tiempo_sesion" placeholder="tiempo_sesion" value="3600">
 				</div>
 			</div>
 			<div class="col-md-6 col-12">
 				<div class="input-group mb-3">
 					<span class="input-group-text">Super User: </span>
 					<input type="text" class="form-control" id="tp_user" name="tp_user" placeholder="A" value="<?php echo $tp_user ?>">
 				</div>
 			</div>
 		</div>
 		<div class="row">
 			<div class="col-lg-12 text-center">
 				<div class="mb-3">
 					<input type="hidden" name="usuario" value="<?php echo s_crypt($usuario,'in')?>">
 					<input type="hidden" name="opc" value="<?php echo s_crypt($opc,'in') ?>">
 					<?php echo bt_guardar(); ?>
 					<?php echo bt_cerrar(); ?>
 				</div>
 			</div>
 		</div>
 	</form>
 </div>
 <script>
 	(function($) {
 		$("#frmGrabarClave").validate();
 	})(jQuery);
 </script>