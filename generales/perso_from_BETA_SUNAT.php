<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");

s_validar_pagina();

$bo_general = new bo_general();
$bo_gen_personas = new bo_gen_personas();
$ent = new gen_personas();

$opc = s_crypt($_REQUEST['opc'], 'out');
$c_persona = s_crypt($_REQUEST['c_persona'], 'out');

// Inicializar variables
$ruc = '';
$nombre = '';
$celular = '';
$correo = '';
$direccion = '';
$estado = '';
$condicion = '';

if ($opc == 'U') {
	$ent->setC_persona($c_persona);
	$data = $bo_gen_personas->listarId($ent);
	foreach ($data as $row) {
		$ruc = $row['ruc'];
		$nombre = $row['nombre_completo'];
		$celular = $row['celular1'] ?? '';
		$correo = $row['correo1'] ?? '';
		$direccion = $row['direccion'] ?? '';
	}
}

$disabled = ($opc == 'I') ? '' : 'disabled';
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

	<form method="post" action="javascript:fn_ActualizarClave();" id="frmGrabarClave" novalidate>
		<div class="row">
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
						   required
						   minlength="11"
						   maxlength="11"
						   pattern="[0-9]{11}"
						   data-msg="El RUC debe tener exactamente 11 dígitos numéricos">
					<?php if ($opc == 'I') { ?>
						<button class="btn btn-info" type="button" id="btnBuscarRuc" disabled>
							<i class="ri-search-line"></i> Buscar
						</button>
					<?php } ?>
					<div class="invalid-feedback">
						El RUC debe tener exactamente 11 dígitos numéricos.
					</div>
				</div>
				<!-- Spinner de carga -->
				<?php if ($opc == 'I') { ?>
					<div id="loadingRuc" class="text-center d-none">
						<div class="spinner-border spinner-border-sm text-primary" role="status">
							<span class="visually-hidden">Consultando...</span>
						</div>
						<small class="text-muted ms-2">Consultando SUNAT...</small>
					</div>
				<?php } ?>
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
						El nombre debe tener al menos 3 caracteres y solo texto (letras).
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Dirección: </span>
					<input type="text" 
						   class="form-control text-uppercase" 
						   name="direccion" 
						   id="direccion" 
						   placeholder="Dirección" 
						   value="<?php echo $direccion ?>"
						   style="text-transform: uppercase;">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Estado: </span>
					<input type="text" 
						   class="form-control" 
						   name="estado" 
						   id="estado" 
						   placeholder="Estado" 
						   value="<?php echo $estado ?>"
						   readonly>
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Condición: </span>
					<input type="text" 
						   class="form-control" 
						   name="condicion" 
						   id="condicion" 
						   placeholder="Condición" 
						   value="<?php echo $condicion ?>"
						   readonly>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Celular: </span>
					<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Celular" value="<?php echo $celular; ?>">
				</div>
			</div>
			<div class="col-md-6 col-12">
				<div class="input-group mb-3">
					<span class="input-group-text">Email: </span>
					<input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" value="<?php echo $correo; ?>">
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
	
	// Solo activar funcionalidad de búsqueda en modo INSERTAR
	if (opc === 'I') {
		// Habilitar/deshabilitar botón de búsqueda según longitud de RUC
		$('#ruc').on('input', function() {
			const ruc = $(this).val();
			// Solo números
			this.value = ruc.replace(/[^0-9]/g, '');
			
			if (this.value.length > 11) {
				this.value = this.value.slice(0, 11);
			}
			
			// Habilitar botón si tiene 11 dígitos
			if (this.value.length === 11) {
				$('#btnBuscarRuc').prop('disabled', false);
				// Buscar automáticamente al completar 11 dígitos
				buscarRucSunat(this.value);
			} else {
				$('#btnBuscarRuc').prop('disabled', true);
			}
		});

		// Búsqueda manual con botón
		$('#btnBuscarRuc').on('click', function() {
			const ruc = $('#ruc').val();
			if (ruc.length === 11) {
				buscarRucSunat(ruc);
			}
		});

		// Función para buscar en SUNAT
		function buscarRucSunat(ruc) {
			// Mostrar loading
			$('#loadingRuc').removeClass('d-none');
			$('#btnBuscarRuc').prop('disabled', true);
			
			$.ajax({
				url: '../util/consultar_sunat.php',
				type: 'POST',
				data: { ruc: ruc },
				dataType: 'json',
				success: function(response) {
					$('#loadingRuc').addClass('d-none');
					$('#btnBuscarRuc').prop('disabled', false);
					
					if (response.success) {
						// Llenar campos con datos de SUNAT
						$('#nombre').val(response.data.razonSocial || '');
						$('#direccion').val(response.data.direccion || '');
						$('#estado').val(response.data.estado || '');
						$('#condicion').val(response.data.condicion || '');
						
						// Mostrar mensaje de éxito
						Swal.fire({
							icon: 'success',
							title: 'Datos encontrados',
							text: 'Se cargaron los datos desde SUNAT',
							timer: 2000,
							showConfirmButton: false
						});
					} else {
						Swal.fire({
							icon: 'warning',
							title: 'No encontrado',
							text: response.message || 'No se encontraron datos para este RUC',
							confirmButtonText: 'Continuar manualmente'
						});
					}
				},
				error: function(xhr, status, error) {
					$('#loadingRuc').addClass('d-none');
					$('#btnBuscarRuc').prop('disabled', false);
					
					Swal.fire({
						icon: 'error',
						title: 'Error de conexión',
						text: 'No se pudo consultar SUNAT. Puede continuar manualmente.',
						confirmButtonText: 'Aceptar'
					});
				}
			});
		}
	}

	// Convertir nombre y dirección a mayúsculas
	$('#nombre, #direccion').on('input', function() {
		// Solo permitir letras en nombre
		if ($(this).attr('id') === 'nombre') {
			this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
		}
		this.value = this.value.toUpperCase();
	});

	// Validación del formulario
	$("#frmGrabarClave").validate({
		rules: {
			ruc: {
				required: true,
				digits: true,
				minlength: 11,
				maxlength: 11
			},
			nombre: {
				required: true,
				minlength: 3
			},
			correo: {
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
			nombre: {
				required: "El nombre es obligatorio",
				minlength: "El nombre debe tener al menos 3 caracteres"
			},
			correo: {
				email: "Ingrese un correo válido"
			}
		}
	});
})(jQuery);
</script>