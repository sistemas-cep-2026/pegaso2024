<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_entrada.php");

$bo_alm_guia = new bo_alm_guias_de_entrada();
 
$cc_local=s_local();
$cc_guia=$_REQUEST["cc_guia"];
$data=$bo_alm_guia->listarRequisciones($cc_local);
?>
<div class="modal-header">
	<h4 class="modal-title">Requisiciones para la guia <?php echo $cc_guia;?></h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<form action="javascript:enviarRequisicion();" id="frmActualiza" novalidate>
		<div class="row  mb-10">
			<div class='col-sm-10'>
				<select name="cc_id" id="cc_id" class="form-control"  required>
				 
					<?php
					foreach ($data as $loc) { ?>
						<option value="<?php echo $loc['cc_requisicion']; ?>" ><?php echo $loc['cc_requisicion'].' //  '.$loc['observacion']; ?></option>
					<?php } ?>
				</select>
			</div>
			 
			<div class='col-sm-2'>
				<?php echo bt_filtrar('Ir'); ?>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
function enviarRequisicion() {
    var requisicion = $("#cc_id").val(); // Obtener el valor seleccionado
    $("#cc_requisicion").val(requisicion); // Asignar el valor al input de la página padre
	$("#cc_requisicion2").val(requisicion); // Asignar el valor al input de la página padre
    $('#modalRequisicion').modal('hide'); // Cerrar el modal
}
</script> 