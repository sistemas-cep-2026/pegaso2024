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
?>

<div class="modal-header">
	<h4 class="modal-title"><?php echo $cc_articulo . " - " . $nombre_arti; ?></h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12 col-12">
			<div class="table-responsive">
				<small>Desde : <?php echo $desde ?> &nbsp;&nbsp;Hasta : <?php echo $hasta ?> &nbsp;&nbsp;Año : <?php echo $cod_anho ?></small>
				<table class="table table-sm">
					<thead class="table-light">
						<tr>
							<th>#</th>
							<th>COD</th>
							<th>FECHA</th>
							<th>CEP</th>
							<th>NOMBRE</th>
							<th>BANCO</th>
							<th class="text-end">EFECTIVO</th>
							<th class="text-end">VOUCHER</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$total_efectivo = 0;
						$total_voucher = 0;
						foreach ($data_doc_venta as $sh) {
							$total_efectivo += $sh['total_efectivo'];
							$total_voucher += $sh['total_voucher'];
						?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><a href="#"
										onclick="fn_imprimir('<?php echo s_crypt($sh['cc_ventas']); ?>')">
										<?php echo $sh['cod_documento'] . "*" . $sh['num_documento']; ?></a></td>
								<td><?php echo $sh['fecha_texto']; ?></td>
								<td><?php echo $sh['cep']; ?></td>
								<td><?php echo $sh['nombre_cliente']; ?></td>
								<td><?php echo $sh['banco']; ?></td>
								<td class="text-end"><?php echo decimal($sh['total_efectivo'], 2); ?></td>
								<td class="text-end"><?php echo decimal($sh['total_voucher'], 2); ?></td>
							</tr>
						<?php
							$i++;
						} ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="6" class="text-end">SUBTOTAL =></th>
							<th class="text-end"><?php echo decimal($total_efectivo, 2); ?></th>
							<th class="text-end"><?php echo decimal($total_voucher, 2); ?></th>
						</tr>
						<tr>
							<th colspan="7" class="text-end">TOTAL GENERAL =></th>
							<th class="text-end"><?php echo decimal($total_efectivo + $total_voucher, 2); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<?php echo bt_cerrar(); ?>
</div>