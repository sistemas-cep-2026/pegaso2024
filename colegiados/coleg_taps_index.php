<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_personas_especialidad.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_especialidad = new bo_tram_personas_especialidad();
$bo_det = new bo_gen_parametro_det();
$bo_personas = new bo_gen_personas();
$bo_general = new bo_general();

$ent_personas = new gen_personas();
$ent_especialidad = new tram_personas_especialidad();

$cc_persona = s_crypt($_REQUEST['cod'], 'out');

$ent_personas->setC_persona($cc_persona);
$data_per = $bo_personas->listarID($ent_personas);

foreach ($data_per as $row) {

	$apaterno = $row['apellido_paterno'];
	$amaterno = $row['apellido_materno'];
	$nombre1 = $row['nombre1'];
	$nombre2 = $row['nombre2'];
	$nombre_completo = $row['nombre_completo'];
	$cep = $row['c_cmp'];
	$cod_documento_text = $row['cod_documento_text'];
	$cr_text = $row['c_local_text'];
	$num_documento = $row['num_documento'];
	$direc = $row['tipo_direccion'];
	$abono_favor = $row['abono_favor'];
	$flag_habil_text = $row['flag_habil_text'];
	$celular = $row['celular1'];
	$correo = $row['email1'];
	$fecha_de_nacimiento = $row['fecha_de_nacimiento'];
	$cod_sexo_text = $row['cod_sexo_text'];
	$c_e_civil_text = $row['c_e_civil_text'];
	$grupo_sanguineo_text = $row['grupo_sanguineo_text'];
	$c_local_textcol = $row['c_local_textcol'];
	$fecha_de_inicio = $row['fecha_de_inicio'];
	$n_folio_cole = $row['n_folio_cole'];
	$n_libro_cole = $row['n_libro_cole'];
	$n_resolucion_cole = $row['n_resolucion_cole'];
	$flag_activo_text = $row['flag_activo_text'];
	$fecha_de_cese = $row['fecha_de_cese'];
	$uni_bachiller = $row['uni_bachiller'];
	$fecha_de_vachiller = $row['fecha_de_vachiller'];
	$ub_nacimiento = $row['ub_nacimiento'];
	$ub_actual = $row['ub_actual'];
	$flag_habil = $row['flag_habil'];
}
$habil_color = ($flag_habil == 'I') ? "danger" : "success";

$foto = buscarFoto($num_documento);

$ent_especialidad->setCc_persona($cc_persona);
$data_lista_grados =  $bo_especialidad->listarXPersona($ent_especialidad);

$data_tipos_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_tipos_grados = array_values(array_filter($data_tipos_grados, function ($item) {
	return !in_array($item['cc_codigo'], ['C', 'H', 'T']);
}));

//$data_sanciones = $bo_general->listarSancionesPersonas($cc_persona);
?>
<input type="hidden" name="cc_persona" id="cc_persona" value="<?= s_crypt($cc_persona, 'in') ?>">
<div class="profile-foreground position-relative mx-n4 mt-n4">
	<div class="profile-wid-bg">
		<img src="images/fondo_col.png" alt="" class="profile-wid-img" />
	</div>
</div>
<div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
	<div class="row g-4 mb-3">
		<div class="col-12">
			<div class="search-box">
				<input type="text" class="form-control search" name="varbuscarcol" id="varbuscarcol"
					placeholder="Búsqueda rápida por CEP o Apellidos">
				<i class="ri-search-line search-icon"></i>
			</div>
		</div>
	</div>
	<div class="row g-4">
		<div class="col-auto">
			<div class="avatar-lg">
				<img src="<?= $foto ?>" alt="user-img" class="img-thumbnail" />
			</div>
		</div>
		<!--end col-->
		<div class="col">
			<div class="p-2">
				<h3 class="text-white mb-1"><?= $cep; ?> - <?= $nombre_completo; ?></h3>
				<p class="text-white text-opacity-75"><?= $cod_documento_text ?>: <?= $num_documento ?></p>
				<p class="text-white text-opacity-75"><?= $cr_text ?></p>
				<div class="hstack text-white-50 gap-1">
					<div class="me-2 text-uppercase">
						<i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>Dirección: <?= $direc ?>
					</div>
				</div>
			</div>
		</div>
		<!--end col-->
		<div class="col-12 col-lg-auto order-last order-lg-0">
			<div class="row text text-white-50 text-center">
				<div class="col-lg-6 col-4">
					<div class="p-2">
						<h3 class="mb-1"><?= u_estado($flag_habil_text, $habil_color) ?></h3>
					</div>
				</div>
				<div class="col-lg-6 col-4">
					<div class="p-2">
						<h4 class="text-white mb-1"><?= 'S/' . decimal_millar($abono_favor, '2') ?></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div>
			<div class="d-flex profile-wrapper">
				<ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
					<li class="nav-item">
						<a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
							<i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Resumen</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fs-14" data-bs-toggle="tab" onclick="fn_editperfil()" href="#editperfil" role="tab">
							<i class="ri-list-unordered d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Editar</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fs-14" data-bs-toggle="tab" href="#tab-grados" role="tab" onclick="fn_editGrados();">
							<i class="ri-price-tag-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Grados</span>
						</a>
					</li>
				
					 
				</ul>
				<div class="flex-shrink-0">
					<a href="<?= url('?id=' . s_crypt(s_mod_id())); ?>" class="btn btn-outline-success" type="button"><i class="fas fa-reply-all"></i> Volver</a>
				</div>
			</div>
			<!-- Tab panes -->
			<div class="tab-content pt-4 text-muted">
				<div class="tab-pane active" id="overview-tab" role="tabpanel">
					<?php include 'coleg_taps_index_lista.php'; ?>
				</div>
				<div class="tab-pane fade" id="editperfil" role="tabpanel">
					<div id="div_editaPerfil"></div>
				</div>
				<div class="tab-pane fade" id="tab-grados" role="tabpanel">
					<div id="divEditarGrados"></div>
				</div>
				<!--end tab-pane-->
				
				 
				<!--end tab-pane-->
			</div>
			<!--end tab-content-->
		</div>
	</div>
	<!--end col-->
</div>
<!--end row-->
<?php
$include_scripts = fn() => importSelect2() . importformmasks() . importTypeahead();
