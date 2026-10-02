<?php
require_once("../util/seguridad.php");
require_once("../util/util.php");
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_coleg       = new bo_gen_personas();

$cep = digitos($_REQUEST["cepinicio"], 6);
$cepfinal = digitos($_REQUEST["cepfinal"] ?? '0', 6);
$tipo = $_REQUEST["option"] ?? 'U';

$bo_coleg->printFotosColegiacion($cep, $cep, $cepfinal, $tipo);
$data_coleg = $bo_coleg->ImprimirFotosColegiados($cep, $cep, $cepfinal);
if(empty($data_coleg)) {
	echo errors();
	return;
}
?>
<table class="table table-sm table-hover" id="tabla-carnet">
	<caption class="caption-top">
		<div class="row">
			<div class="col-sm-12 text-end">
				<a href="javascript:fn_limpiarfoto()" class="btn btn-outline-danger" role="button"><i class="fa fa-broom"></i> Limpiar lista</a>
			</div>
		</div>
	</caption>
	<thead>
		<tr class="table-active">
			<th>#</th>
			<th class="text-center">FOTO PRE MAT.</th>
			<th>FOTO</th>
			<th>CEP</th>
			<th>DNI</th>
			<th>NOMBRE</th>
			<th>CR</th>
			<th>FEC. INI</th>
			<th>VENCE</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1;
		foreach ($data_coleg as $row) {
		?>
			<tr class="align-middle">
				<td ><?= $i ?></td>
				<td class="text-center"><a href="#" onclick="fn_verfoto({dni:'<?= $row['dni']; ?>',nombre:'<?= $row['nombre_completo']; ?>',foto:`<?= 'https://www.cep.org.pe/colegiacion/imag/fotos/'.$row['dni'].'.jpg' ?>`});"><img src="https://www.cep.org.pe/colegiacion/imag/fotos/<?= $row['dni'] ?>.jpg" loading="lazy" width="45" class="rounded img-fluid material-shadow" onerror="this.onerror=null; this.src='images/sinfoto.jpg';"></a></td>
				<td><a href="#" onclick="fn_verfoto({dni:'<?= $row['dni']; ?>',nombre:'<?= $row['nombre_completo']; ?>',foto:`<?= 'https://cep.org.pe/fotos/'.$row['dni'].'.jpg' ?>`});"> <img src="<?= 'https://cep.org.pe/fotos/'.$row['dni'].'.jpg' ?>" width="40" class="rounded img-fluid material-shadow" onerror="this.onerror=null; this.src='images/sinfoto.jpg';" /></a></td>
				<td><?= $row["C_CMP"]; ?></td>
				<td><?= $row["dni"]; ?></td>
				<td><?= $row["nombre_completo"]; ?></td>
				<td><?= $row["nombre_abv"]; ?></td>
				<td><?= $row["inicio"]; ?></td>
				<td><?= $row["hasta"]; ?></td>
			</tr>
		<?php
			$i++;
		}
		?>
	</tbody>
</table>