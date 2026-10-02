<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once u_src() . "bo/bo_gen_personas.php";

$bo_personas = new bo_gen_personas();

$tipo   = $_REQUEST["tipo"] ?? '';
$c_tipo = $_REQUEST["c_tipo"] ?? '';
$desde  = digitos($_REQUEST["desde"] ?? '', 6);
$hasta  = digitos($_REQUEST["hasta"] ?? '', 6);
$v      = $_REQUEST["v"] ?? '';
$url = '';
$dato_personales = $bo_personas->diploma_lista($tipo, $desde, $hasta);
if (empty($dato_personales)) {
	echo errors();
	return;
}
$printPath = url("colegiados/");

$config = [
	"C" => [
		"Z"  => "print_diploma.php",
		"W"  => "print_diploma_copia.php",
		"Y"  => "print_resolucion.php",
		"U"  => "print_resolucion_dupli.php",
		"T"  => "print_stiker.php",
	],

	"A" => [
		"Z" => "print_diploma_grado_auditoria.php",
		"W" => "print_diploma_gradoc_auditoria.php",
	],
	"N" => [
		"Z" => "print_diploma_grado_lactancia.php",
		"W" => "print_diploma_gradoc_lactancia.php",
	],
	"J" => [
		"Z" => "print_diploma_grado_conciliador.php",
		"W" => "print_diploma_gradoc_conciliador.php",
	],
	"DEFAULT" => [
		"Z" => "print_diploma_grado.php",
		"W" => "print_diploma_gradoc.php",
		"T" => "print_stiker.php",
	]
];

$grupo = $config[$tipo] ?? $config["DEFAULT"];
$archivo = $grupo[$c_tipo] ?? null;

$matricula = $archivo ? $printPath . $archivo : null;

$mensajes = [
	"C-Z" => "IMPRIMIR TODOS LOS DIPLOMAS COLEGIATURA!!",
	"E-Z" => "IMPRIMIR TODOS LOS DIPLOMAS ESPECIALIDAD!!",
	"M-Z" => "IMPRIMIR TODOS LOS DIPLOMAS MAESTRÍA!!",
	"D-Z" => "IMPRIMIR TODOS LOS DIPLOMAS DOCTORADO!!",
	"A-Z" => "IMPRIMIR TODOS LOS DIPLOMAS DE AUDITORÍA!!",
	"P-Z" => "IMPRIMIR TODOS LOS DIPLOMAS DE POS.DOCTORADO!!",
	"N-Z" => "IMPRIMIR TODOS LOS DIPLOMAS DE LACTANCIA MATERNA!!",
	"J-Z" => "IMPRIMIR TODOS LOS DIPLOMAS DE CONCILIADOR EXTRAJUDICIAL!!",
	"C-Y" => "IMPRIMIR TODAS LAS RESOLUCIONES COLEGIACION!!",
	"T"   => "IMPRIMIR TODOS LOS STIKER!!"
];

$key = "$tipo-$c_tipo";

if ($archivo && (isset($mensajes[$key]) || $c_tipo === 'T')) {
	$mensaje = $mensajes[$key] ?? $mensajes["T"];
	$url = "{$printPath}{$archivo}?tipo=$tipo&c_tipo=$c_tipo&desde=$desde&hasta=$hasta&v=$v";
}

$grados = [
	'C' => 'LISTA DE COLEGIADOS REGISTRADOS POR NÚMERO',
	'E' => 'LISTA DE ESPECIALIDAD REGISTRADOS POR NÚMERO',
	'M' => 'LISTA DE MAESTRIA REGISTRADOS POR NÚMERO',
	'D' => 'LISTA DE DOCTORADO REGISTRADOS POR NÚMERO',
	'A' => 'LISTA DE AUDITORES REGISTRADOS POR NÚMERO',
	'P' => 'LISTA DE POS.DOCTORADO REGISTRADOS POR NÚMERO',
	'N' => 'LISTA DE LACTANCIA REGISTRADOS POR NÚMERO',
	'J' => 'LISTA DE CONCILIADOR EXTRAJUDICIAL REGISTRADOS POR NÚMERO'
];
?>
<table class="table table-sm table-hover" id="tabla-diplomas">
	<caption class="caption-top">
		<div class="row">
			<div class="col-12 text-center d-flex">
				<div class="p-2 flex-grow-1">
					<h4><?= $grados[$tipo] ?></h4>
				</div>
				<div>
					<?php if (!empty($mensaje)) {
					?>
						<a href='<?= $url ?>' target='_blank' class='btn btn-primary'>
							<i class='fa fa-print'></i> <?= $mensaje ?>
						</a>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</caption>
	<tr class="table-active">
		<th>#</th>
		<th>N° REG.</th>
		<?php
		if($tipo === 'C') {
		?>
			<th class="text-center">FOTO PRE MAT.</th>
		<?php
		}
		?>
		<th class="text-center">FOTO</th>
		<th class="col-5">NOMBRE</th>
		<th>FECHA</th>
		<th>CR</th>
		<th>DOCUMENTO</th>
		<th>SEXO</th>
	</tr>

	<?php
	$i = 1;
	foreach ($dato_personales as $r) {
		$sexo = $r["cod_sexo"] === 'M' ? "MASCULINO" : "FEMENINO";
		$urlIndividual = $matricula
			? "{$matricula}?tipo=$tipo&c_tipo=$c_tipo&desde={$r['c_cmp']}&hasta={$r['c_cmp']}&v=$v"
			: "#";
	?>
		<tr class="align-middle">
			<td><?= $i++ ?></td>
			<td><a href="<?= $urlIndividual ?>" target="_blank"><?= $r["c_cmp"] ?></a></td>
			<?php
			if($tipo === 'C') {
			?>
				<td class="text-center"><a href="<?= 'https://www.cep.org.pe/colegiacion/imag/fotos/index.php?root=' . $r['num_documento'] . '.jpg' ?>" download><img src="https://www.cep.org.pe/colegiacion/imag/fotos/<?= $r['num_documento'] ?>.jpg" loading="lazy" width="45" class="rounded img-fluid material-shadow" onerror="this.onerror=null; this.src='images/sinfoto.jpg';"></a></td>
				<?php
			}
			?>
			<td class="text-center"><a href="<?= 'https://cep.org.pe/fotos/?root=' . $r['num_documento'] . '.jpg' ?>" download><img src="https://cep.org.pe/fotos/<?= $r['num_documento'] ?>.jpg" loading="lazy" width="45" class="rounded img-fluid material-shadow" onerror="this.onerror=null; this.src='images/sinfoto.jpg';"></a></td>
			<td><?= $r["nombre"] ?></td>
			<td><?= $r["fecha"] ?></td>
			<td><?= $r["c_local_colegiacion"] ?></td>
			<td><?= $r["num_documento"] ?></td>
			<td><?= $sexo ?></td>
		</tr>
	<?php } ?>
</table>