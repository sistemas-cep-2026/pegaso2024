<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_rh_plame.php");
$bo_comp_rh_plame = new bo_comp_rh_plame();

$ent = new comp_rh_plame();

$c_local = s_local_vinculado() ?? '';
 
$cod_anho = s_anho() ?? '';
$cod_mes = s_periodo() ?? '';

$ent->setC_local($c_local);
$ent->setCod_anho($cod_anho);
$ent->setCod_mes($cod_mes);

$data  = $bo_comp_rh_plame->listar($ent);

?>
<div class="table-responsive">
	 <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_control('','<?php echo s_crypt('I', 'in') ?>','<?php echo $c_banco; ?>')"><i class="ri-add-line align-bottom me-1"></i> Nuevo Doc.</button>
                        </div>
                    </div>
	<table class="table table-hover table-sm" id="table-cajachica">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>REGISTRO</th>
				<th>PROVEEDOR</th>
				<th>DOCUMENTO</th>
        
                <th>F.DOCUMENTO</th>
                <th>F.PAGO</th>
                <th>4TA</th>
				<th>RENTA</th>
				<th class="text-end">MONTO</th>
				<th class="text-end">OPCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;  
			foreach ($data as $row) {
			?>
				<tr>
					<td><?php echo $i ?></td>
						<td><?php echo $row["fecha_registro"] . ' * ' . $row["c_usuario"];  ?></td>
                    <td><?php echo $row["ruc"] . ' - ' . $row["nombre"]; ?></td>
					<td><?php echo $row["cod_documento"].' '.$row["num_documento"] ?></td>
 
                    <td><?php echo $row["fecha_documento"]?></td>
                    <td><?php echo $row["fecha_pago"] ?></td>
                    <td><?php if($row["cuarta"]<>0.00){echo decimal_millar(($row["monto"]*$row["cuarta"]), 2);} else { echo 'N: '.$row["renta_sus_numero"].'// F:'.$row["renta_sus_fecha"];}?></td>
					 <td><?php if($row["renta"]<>0.00){echo decimal_millar(($row["monto"]*$row["renta"]), 2);} else { echo "NO";}?></td>
					<td class="text-end"><?php echo decimal_millar($row["monto"], 2); ?></td>
					<td class="text-end">
						<button class="btn btn-primary"
							onclick="fn_control('<?php echo s_crypt($row['cc_id'], 'in') ?>','<?php echo s_crypt('U', 'in') ?>')">
							<i class='fas fa-edit'></i> Modificar
						</button>
						<button class="btn btn-danger"
							onclick="fn_eliminar('<?php echo s_crypt($row['cc_id'], 'in') ?>','<?php echo s_crypt('A', 'in') ?>')">
							<i class='fas fa-eye-slash'></i> Eliminar
						</button>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>