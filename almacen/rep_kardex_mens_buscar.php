<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_honorabilidad.php");

$bo_general = new bo_general();
$bo_honorabilidad = new bo_tram_honorabilidad();
$mes=u_meses();
$data_anho=$bo_honorabilidad->listarAnhos();
?>
<div class="row">
	<div class="col-xxl-12">		
		<form id="frmFormKardex" action="almacen/rep_kardex_mens_listar.php" method="post"  target="divReporteKardex" >
			<div class="row justify-content-center">
				
				<div class="col-sm-2">
					<select name="anho" id="anho" class="form-control" onchange="submit()">
					 
						<?php
						foreach ($data_anho as $row) {
							?>
							<option value="<?php echo $row['anho'] ?>" <?php if ( $row['anho']==date("Y")) {
								echo "selected";
							} ?> ><?php echo $row['anho'] ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<select name="periodo" id="periodo" class="form-control" onchange="submit()">
						<option value="">Periodo</option>
						<?php
						foreach ($mes as $key=>$value) {
							?>
							<option value="<?php echo $key ?>" <?php if ( $key==date("m")) {
								echo "selected";
							} ?> ><?php echo $value ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-2">
					<?php echo bt_buscar("Buscar")  ?> <?php bt_cancelar("Cancelar") ?>
				</div>
			</div>
		</form>

		<div class="row mb-3">
            <div class="col-lg-12 table-responsive">
                <div class="text-center spinner-content d-none" aria-live="polite">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
                <iframe name="divReporteKardex" loading="lazy" class="iframe-loader d-none" id="divReporteKardex" style="width: 100%; height: 600px; border: none;" onload="cargadorReportes()"></iframe>
            </div>
        </div>
	 
	</div>
</div> <!-- end col -->
