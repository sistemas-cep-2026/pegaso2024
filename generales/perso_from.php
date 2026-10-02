<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_general = new bo_general();
$bo_gen_personas = new bo_gen_personas();
$ent = new gen_personas();

$opc = s_crypt($_REQUEST['opc'], 'out');
$c_persona = s_crypt($_REQUEST['c_persona'], 'out');

// Inicializar variables
$nombre = '';
$ruc = '';
$num_documento = '';
$celular1 = '';
$email1 = '';

if ($opc == 'U') {
	$ent->setC_persona($c_persona);
	$data_usuarios = $bo_gen_personas->listarID($ent);
	foreach ($data_usuarios as $row) {
		$nombre = $row['nombre_completo'];
		$ruc = $row['ruc'];
		$num_documento = $row['num_documento'] ?? '';
		$celular1 = $row['celular1'];
		$email1 = $row['email1'];
	}
}

$disabled = ($opc == 'I') ? '' : 'disabled';
//echo $opc;
?>

<div class="modal-header">
	<h4 class="modal-title"><?php if ($opc == 'I') {
								echo 'Crear Proveedor';
							} else {
								echo 'Mantenimiento Proveedor';
							} ?></h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>

<div class="modal-body">
	<!-- Mensaje de advertencia en ROJO -->
	<?php if ($opc == 'I') { ?>
		<div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
			<i class="ri-error-warning-line me-3 align-middle fs-16"></i>
			<strong>¡ATENCIÓN!</strong><br>
			ANTES DE CREAR PROVEEDOR, EFECTÚE LAS BÚSQUEDAS PERTINENTES, EVITE DUPLICIDADES.<br>
			CASO DESEE RECTIFICAR RUC O RAZÓN SOCIAL, ENVIAR CORREO A
			<a href="mailto:SISTEMAS@CEP.ORG.PE" class="alert-link">SISTEMAS@CEP.ORG.PE</a>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php } ?>

	<form method="post" action="javascript:fn_Actualizar();" id="frmGrabar" novalidate>

		<!-- ✅ SELECTOR DE TIPO DE DOCUMENTO -->
		<?php if ($opc == 'I') { ?>
			<div class="row mb-3">
				<div class="col-md-12">
					<label class="form-label"><strong>Tipo de Proveedor:</strong></label>
					<div class="btn-group w-100" role="group">
						<input type="radio" class="btn-check" name="tipo_proveedor" id="tipo_ruc" value="RUC" checked>
						<label class="btn btn-outline-primary" for="tipo_ruc">
							<i class="ri-building-line"></i> Empresa (RUC)
						</label>

						<input type="radio" class="btn-check" name="tipo_proveedor" id="tipo_dni" value="DNI">
						<label class="btn btn-outline-primary" for="tipo_dni">
							<i class="ri-user-line"></i> Persona Natural (DNI)
						</label>
					</div>
				</div>
			</div>
		<?php } ?>

		<!-- ✅ CAMPO RUC -->
		<div class="row campo-ruc">
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">RUC: </span>
					<input type="text"
						class="form-control"
						name="ruc"
						id="ruc"
						placeholder="RUC (11 dígitos)"
						value="<?php echo $ruc ?>"
						<?php echo $disabled ?>
						minlength="11"
						maxlength="11">
					<div class="invalid-feedback">
						El RUC debe tener exactamente 11 dígitos numéricos.
					</div>
				</div>
			</div>
		</div>

		<!-- ✅ CAMPO DNI -->

		<div class="row campo-dni" <?php echo ($opc == 'I') ? 'style="display: none;"' : ''; ?>>
			<div class="col-md-8 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">DNI: </span>
					<input type="text"
						class="form-control"
						name="num_documento"
						id="num_documento"
						placeholder="DOCUMENTO DNI, CAR. EXT. Y PAS. (9 dígitos)"
						value="<?php echo $num_documento ?>"
						<?php echo $disabled ?>
						minlength="8"
						maxlength="9">
					<div class="invalid-feedback">
						El DNI debe tener exactamente 8 dígitos numéricos.
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Nombre: </span>
					<input type="text"
						class="form-control text-uppercase"
						name="nombre"
						id="nombre"
						placeholder="Nombre (mínimo 3 caracteres)"
						value="<?php echo $nombre ?>"
						<?php echo $disabled ?>
						required
						minlength="3"
						style="text-transform: uppercase;">
					<div class="invalid-feedback">
						El nombre debe tener al menos 3 caracteres.
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Celular: </span>
					<input type="text" class="form-control" id="celular1" name="celular1" placeholder="Celular" value="<?php echo $celular1; ?>">
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Email: </span>
					<input type="email" class="form-control" id="email1" name="email1" placeholder="Email" value="<?php echo $email1; ?>">
					<div class="invalid-feedback">
						Ingrese un email válido.
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="mb-3">
					<input type="hidden" name="c_persona" value="<?php echo s_crypt($c_persona, 'in') ?>">
					<input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
					<?php echo bt_guardar(); ?>
					<?php echo bt_cerrar(); ?>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	(function($) {
		var opc = '<?php echo $opc; ?>';

		// ✅ Mostrar/Ocultar campos según tipo de proveedor
		function toggleTipoProveedor(tipo) {
			if (tipo === 'RUC') {
				$('.campo-ruc').show();
				$('.campo-dni').hide();
				$('#ruc').attr('required', true);
				$('#num_documento').attr('required', false).val('');
			} else {
				$('.campo-ruc').hide();
				$('.campo-dni').show();
				$('#ruc').attr('required', false).val('');
				$('#num_documento').attr('required', true);
			}
		}

		// ✅ Evento al cambiar tipo de proveedor
		$('input[name="tipo_proveedor"]').on('change', function() {
			toggleTipoProveedor($(this).val());
		});

		// ✅ Inicializar al cargar (solo en modo crear)
		if (opc === 'I') {
			toggleTipoProveedor('RUC'); // Por defecto RUC
		}

		// Configurar jQuery Validate
		$("#frmGrabar").validate({
			rules: {
				ruc: {
					digits: true,
					minlength: 11,
					maxlength: 11
				},
				num_documento: {
					digits: true,
					minlength: 8,
					maxlength: 9
				},
				nombre: {
					required: true,
					minlength: 3
				},
				email1: {
					email: true
				}
			},
			messages: {
				ruc: {
					required: "El RUC es obligatorio",
					digits: "El RUC solo debe contener números",
					minlength: "El RUC debe tener exactamente 11 dígitos",
					maxlength: "El RUC debe tener exactamente 11 dígitos"
				},
				num_documento: {
					required: "El DNI es obligatorio",
					digits: "El DNI solo debe contener números",
					minlength: "El DNI debe tener exactamente 8 dígitos",
					maxlength: "El DNI debe tener exactamente 9 dígitos"
				},
				nombre: {
					required: "El nombre es obligatorio",
					minlength: "El nombre debe tener al menos 3 caracteres"
				},
				email1: {
					email: "Ingrese un email válido"
				}
			},
			errorElement: 'div',
			errorClass: 'invalid-feedback',
			highlight: function(element) {
				$(element).addClass('is-invalid').removeClass('is-valid');
			},
			unhighlight: function(element) {
				$(element).removeClass('is-invalid').addClass('is-valid');
			}
		});

		// Permitir solo números en RUC
		$('#ruc').on('input', function() {
			this.value = this.value.replace(/[^0-9]/g, '');
			if (this.value.length > 11) {
				this.value = this.value.slice(0, 11);
			}
		});

		// Permitir solo números en DNI
		$('#num_documento').on('input', function() {
			this.value = this.value.replace(/[^0-9]/g, '');
			if (this.value.length > 9) {
				this.value = this.value.slice(0, 9);
			}
		});

		// Permitir caracteres válidos en Nombre y convertir a MAYÚSCULAS
		$('#nombre').on('input', function() {
			this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,\-&()\/]/g, '');
			this.value = this.value.toUpperCase();
		});
	})(jQuery);
</script>