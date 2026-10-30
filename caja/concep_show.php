<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
require_once(u_src() . "bo/bo_gen_articulos.php");

$bo_general = new bo_general();
$bo_documento_venta = new bo_fin_documentos_de_venta();
$bo_articulos = new bo_gen_articulos();

$ent_documento_venta = new fin_documentos_de_venta();
$ent_articulos = new gen_articulos();

$cc_local = $_REQUEST['c_local'] ?? '';
$cc_articulo = $_REQUEST['cc_articulo'] ?? '';
$desde = $_REQUEST['desde'] ?? '';
$hasta = $_REQUEST['hasta'] ?? '';
$cod_anho = $_REQUEST['cod_anho'] ?? '';

$ent_documento_venta->setCod_desde($desde);
$ent_documento_venta->setCod_hasta($hasta);
$ent_documento_venta->setC_local($cc_local);
$ent_documento_venta->setC_articulo($cc_articulo);
$ent_documento_venta->setCod_anho($cod_anho);


$ent_articulos->setC_articulo($cc_articulo);
$ent_articulos->setC_local($cc_local);
$data_articulo = $bo_articulos->listarSelect_caja($ent_articulos);
foreach ($data_articulo as $art) {
	$nombre_arti = $art['nombre'];
}
$data_doc_venta = $bo_documento_venta->detalle_ingresosConceptos_articulo($ent_documento_venta);

// Totales para el resumen superior y el pie de la tabla
$total_efectivo = 0;
$total_voucher = 0;
foreach ($data_doc_venta as $sh) {
	$total_efectivo += $sh['total_efectivo'];
	$total_voucher += $sh['total_voucher'];
}
?>
<div class="modal-header">
	<div>
		<h5 class="modal-title mb-1">
			<span class="badge bg-body-secondary text-body me-2"><?php echo $cc_articulo; ?></span><?php echo $nombre_arti; ?>
		</h5>
		<div class="text-muted fs-13">
			<i class="ri-calendar-2-line align-middle"></i>
			<?php echo $desde ?> &ndash; <?php echo $hasta ?>
			<span class="mx-1">·</span>
			Año <?php echo $cod_anho ?>
		</div>
	</div>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<div class="row g-2 mb-3">
		<div class="col-6 col-md-3">
			<div class="d-flex align-items-center gap-3 p-3 rounded bg-body-secondary">
				<i class="ri-file-list-3-line fs-24 text-muted"></i>
				<div>
					<div class="text-uppercase fs-11 fw-semibold text-muted">Documentos</div>
					<h5 class="mb-0"><?php echo count($data_doc_venta); ?></h5>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3">
			<div class="d-flex align-items-center gap-3 p-3 rounded bg-body-secondary">
				<i class="ri-hand-coin-line fs-24 text-muted"></i>
				<div>
					<div class="text-uppercase fs-11 fw-semibold text-muted">Efectivo</div>
					<h5 class="mb-0"><?php echo decimal($total_efectivo, 2); ?></h5>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3">
			<div class="d-flex align-items-center gap-3 p-3 rounded bg-body-secondary">
				<i class="ri-bank-card-line fs-24 text-muted"></i>
				<div>
					<div class="text-uppercase fs-11 fw-semibold text-muted">Voucher</div>
					<h5 class="mb-0"><?php echo decimal($total_voucher, 2); ?></h5>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3">
			<div class="d-flex align-items-center gap-3 p-3 rounded bg-body-secondary">
				<i class="ri-money-dollar-circle-line fs-24 text-muted"></i>
				<div>
					<div class="text-uppercase fs-11 fw-semibold text-muted">Total</div>
					<h5 class="mb-0"><?php echo decimal($total_efectivo + $total_voucher, 2); ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="table-responsive border rounded overflow-auto" style="max-height: 52vh;">
		<table class="table table-sm table-hover align-middle mb-0 fs-13">
			<thead class="table-light text-uppercase fs-11">
				<tr>
					<th class="sticky-top">#</th>
					<th class="sticky-top">COD</th>
					<th class="sticky-top">FECHA</th>
					<th class="sticky-top">CEP</th>
					<th class="sticky-top">NOMBRE</th>
					<th class="sticky-top">BANCO</th>
					<th class="sticky-top text-end">EFECTIVO</th>
					<th class="sticky-top text-end">VOUCHER</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($data_doc_venta)) { ?>
					<tr>
						<td colspan="8" class="text-center text-muted py-5">
							<i class="ri-file-list-3-line fs-1 d-block mb-2"></i>
							No se encontraron documentos para este concepto.
						</td>
					</tr>
				<?php } ?>
				<?php
				$i = 1;
				foreach ($data_doc_venta as $sh) {
				?>
					<tr>
						<td class="text-muted"><?php echo $i; ?></td>
						<td class="text-nowrap"><a href="#" class="fw-semibold link-underline-opacity-0 link-underline-opacity-100-hover"
								onclick="fn_imprimir('<?php echo s_crypt($sh['cc_ventas']); ?>')"><?php echo $sh['cod_documento'] . ' ' . $sh['num_documento']; ?></a></td>
						<td class="text-nowrap"><?php echo $sh['fecha_texto']; ?></td>
						<td><?php echo $sh['cep']; ?></td>
						<td><?php echo $sh['nombre_cliente']; ?></td>
						<td class="text-muted fs-11 lh-sm"><?php echo $sh['banco']; ?></td>
						<td class="text-end text-nowrap <?php echo $sh['total_efectivo'] > 0 ? '' : 'text-muted'; ?>"><?php echo decimal($sh['total_efectivo'], 2); ?></td>
						<td class="text-end text-nowrap <?php echo $sh['total_voucher'] > 0 ? '' : 'text-muted'; ?>"><?php echo decimal($sh['total_voucher'], 2); ?></td>
					</tr>
				<?php
					$i++;
				} ?>
			</tbody>
			<tfoot>
				<tr class="table-light">
					<th colspan="6" class="text-end text-muted">SUBTOTAL</th>
					<th class="text-end text-nowrap"><?php echo decimal($total_efectivo, 2); ?></th>
					<th class="text-end text-nowrap"><?php echo decimal($total_voucher, 2); ?></th>
				</tr>
				<tr>
					<th colspan="7" class="text-end bg-body-secondary">TOTAL GENERAL</th>
					<th class="text-end text-nowrap bg-body-secondary"><?php echo decimal($total_efectivo + $total_voucher, 2); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal-footer">
	<?php echo bt_cerrar(); ?>
</div>