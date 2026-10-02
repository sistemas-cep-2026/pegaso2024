<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

require_once(u_src() . "bo/bo_comp_rh_plame.php");
$bo_comp_rh_plame = new bo_comp_rh_plame();
$bo_general = new bo_general();
 $ent = new comp_rh_plame();

$cc_local = $_REQUEST['cc_local'] ?? '';
$anho = $_REQUEST['anho']  ?? '';
$periodo = $_REQUEST['periodo']  ?? '';

$ent->setC_local($cc_local);
$ent->setCod_anho($anho);
$ent->setCod_mes($periodo);

$data  = $bo_comp_rh_plame->listar($ent);

 
?>
<div class="table-responsive">
 
	<table class="table table-hover table-sm"   id="table-reporte">
		<thead class="table-light">
		<tr class="messageTOP">
			<th colspan="11"><?php  echo 'RH/Dietas PDT-Plame (CR '.$cc_local.') '.$periodo.'/'.$anho;?></th>
		</tr>
			<tr>
				<th>CR #</th>
				<th>REGISTRO</th>
				
                <th>PROVEEDOR</th>
                <th>DOCUMENTO</th>
				<th>FECHA DOC.</th>
                <th>FECHA PAGO</th>
				
				
				<th class="text-end">MONTO</th>
			<th class="text-end">CUARTA</th>
							
			</tr>
		</thead>
		<tbody>
			<?php $id=0;
			foreach ($data as $row) {
                $id++;
			?>
				<tr>
					<td><?php echo 'CR'.$row['c_local'].' // '.$id; ?></td>
					<td><?php echo $row['fecha_registro'].' - '.$row['c_usuario'] ?></td>
					<td><?php echo $row['ruc'] . '-' .  $row['nombre'] ; ?></td>
					<td><?php echo $row['cod_documento'] . '&nbsp;&nbsp;&nbsp;' . $row['num_documento'] ?></td>
                    <td><?php echo $row['fecha_documento'] ?></td>
                    <td><?php echo $row['fecha_pago'] ?></td>
					<td class="text-end"><?php echo decimal_millar($row['monto'], 2);$monto=$monto+$row['monto']; ?></td>
                       <td  class="text-end"><?php if($row["cuarta"]==="1"){echo "SI";} else { echo "NO";}?></td>
					
				</tr>
			<?php } ?>
            
		</tbody>
        <tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
                    <td></td>
                    <td></td>
					<td class="text-end"><?php echo decimal($monto,2); ?></td>
                       <td></td>
					
				</tr>
	</table>
</div>