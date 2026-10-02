<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
 

$bo_general = new bo_general();
$data_bancos    = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');


$mes=u_meses();
$data_anho = listarAnhos();
?>
<div class="row">
	<div class="col-xxl-12">
		<div class="card">
			<div class="card-body">
			<form id="frmFormSaldos" action="bancos/rep_saldos_listar.php" method="post"  target="divReporteSaldos" >
				<div class="row g-2 align-items-end justify-content-center">
					    <div class="col-sm-4">
                        <label class="form-label text-muted fs-13 mb-1">Cuenta bancaria</label>
                        <select name="c_banco" id="c_banco_saldos" class="form-control" onchange="submit()">
                            <?php
                            foreach ($data_bancos as $ban) { ?>
                                <option value="<?= "{$ban['c_banco']}-{$ban['c_cta_corriente']}" ?>">
                                    <?= "{$ban['nombre']} =>> {$ban['c_cta_corriente']}" ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
			 
				 
					 
					<div class="col-sm-3">
						<?php echo bt_buscar("Buscar")  ?> <?php bt_cancelar("Cancelar") ?>
					</div>
				</div>
			</form>
			</div>
		</div>

		<div class="row mb-3">
            <div class="col-lg-12 table-responsive">
                <div class="text-center spinner-content d-none" aria-live="polite">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
                <iframe name="divReporteSaldos" loading="lazy" class="iframe-loader d-none" id="divReporteSaldos" style="width: 100%; height: 600px; border: none;" onload="cargadorReportes(this)"></iframe>
            </div>
        </div>
	 
	</div>
</div> <!-- end col -->
