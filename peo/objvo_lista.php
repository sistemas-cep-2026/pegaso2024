<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_peo_objetivos.php");

$bo_objetivos = new bo_peo_objetivos();
$cc_ejeestrategico="";
if(isset($_REQUEST["cc_ejeestrategico"])){
	$cc_ejeestrategico=$_REQUEST["cc_ejeestrategico"];
}
$data_objet  =   $bo_objetivos->listarIDEje($cc_ejeestrategico);

$color_estado = [
	'A' => 'success',
	'I' => 'danger'
];
?>
<table class="dt-multilingual table" id="table-objetivo">
	<thead>
		<tr>
			<th>#</th>
			<th>OBJETIVOS</th>
			<th>ESTADO</th>
			<th>ACCIÓN</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1;
		foreach ($data_objet as $obj) {
			?>
			<tr>
				<td><?php echo $i ?></td>
				<td><?php echo $obj["nombre"] ?></td>
				<td><?php echo u_estado($obj["flag_text"], $color_estado[$obj['flag']]); ?></td>
				<td>
					<button type="button" title="Editar" data-bs-toggle="tooltip" class="btn btn-icon bg-transparent text-info" ><i class="fa fa-edit"></i></button>
					<button type="button" title="Eliminar" data-bs-toggle="tooltip" class="btn btn-icon bg-transparent text-danger" ><i class="fa fa-trash"></i></button>
				</td>
			</tr>
			<?php $i++;
		} ?>
	</tbody>
</table>
