<?php 
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_peo_objetivos.php");
require_once(u_src() . "bo/bo_peo_iniciativas.php");
require_once(u_src() . "bo/bo_peo_actividades.php");
require_once(u_src() . "bo/bo_general.php");

$cc_objetivos=s_crypt($_REQUEST['cc_objetivos'], 'out');
$anho=s_crypt($_REQUEST['anho'], 'out');

$bo_objetivos = new bo_peo_objetivos();
$bo_iniciativas=new bo_peo_iniciativas();
$bo_actividades=new bo_peo_actividades();
$bo_general=new bo_general();

$cc_local=s_local();
$data_obj=$bo_objetivos->listarID($cc_objetivos);
foreach($data_obj as $obj){
	$objnombre=$obj["nombre"];
}

$data_perio=$bo_general->peridolista();
$dta_inic=$bo_iniciativas->listarIdObj($cc_objetivos);

$cc_local=s_local();
$data_activ=$bo_actividades->peo_periodo();


?>
<div class="row">
	<!-- Clickable inside dropdown -->
	<div class="col-sm-6"></div>
	<div class="col-sm-6 text-end">
		<div class="btn-group text-end">
			<button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
				Plan Operativo
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
				<?php foreach ($data_activ as $key) {?>
					<li><a class="dropdown-item" href="javascript:fn_fromobjetivos('<?php echo s_crypt($cc_objetivos, 'in') ?>','<?php echo s_crypt($key['periodo'],'in')?>')"><?php echo $key['periodo'] ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>

<div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
	<strong>Objetivo.- <?php echo $objnombre ?></strong>
</div>
<?php 
$ix=1;
if(count($dta_inic)>0){
	foreach($dta_inic as $ini){ ?>
		<!-- Secondary Alert -->
		<br>
		<div class="alert alert-secondary alert-border-left alert-dismissible fade show" role="alert">
			<?php echo "<strong>Iniciativa ".$ix."</strong>.- ".$ini["nombre"] ?>
			<a href="#"><i class='fas fa-plus-circle'></i></a>
		</div>
		<?php 
		$i=1;
		$date_actividades = $bo_actividades->listarIdIni($ini['cc_iniciativas'], $cc_local,$anho);
		foreach ($date_actividades as $act) { ?>
			<div class="row">
				<div class="col-sm-9" > 
					<?php echo $i.'.- ' ?><?php echo $act['nombre'] ?>
				</div>
				<div class="col-sm-1">
					activo
				</div>
				<div class="col-sm-2">
					<a href="#" class="btn btn-icon bg-transparent text-info"><i class="fa fa-edit"></i></a>
					<a href="#" class="btn btn-icon bg-transparent text-danger"><i class="fa fa-trash"></i></a>
				</div>
			</div>
			<?php $i++;} ?>

			<?php $ix++;}
		}else{
			echo errors("No existe registro");
		} ?>


