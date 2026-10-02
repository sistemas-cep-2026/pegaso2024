 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_banc_beneficiofam.php");
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();
    $bo_fam = new bo_banc_beneficiofam();

    $ent_fam = new banc_beneficiofam();

    $rep_tipo = $_REQUEST['rep_tipo'] ?? '';
    $cc_local_pedido = $_REQUEST['cc_local'] ?? '';

    // el consolidado de "todos los consejos" (cc_local1='') solo puede
    // pedirlo el admin general (Consejo Nacional); cualquier otro usuario
    // queda forzado a su propio consejo, sin importar qué venga en la
    // petición.
    $es_admin_general = (s_local() === '28');
    $cc_local = $es_admin_general ? $cc_local_pedido : s_local();

    $cod_anho = $_REQUEST['cod_anho'] ?? '';
    $cod_mes = $_REQUEST['cod_mes'] ?? '';

    if ($cc_local === '28') {
        $cc_local1 = '';
    }else{
       $cc_local1 = $cc_local; 
    }
    $ent_fam->setCod_anho($cod_anho);
    $ent_fam->setCod_mes($cod_mes);
    $ent_fam->setCc_local($cc_local1);
    $user_nombre=s_usu_nombre();
    ?>
 <div class="table-responsive">
     <?php if ($rep_tipo == 'D') {
         $data_fam = $bo_fam->listar($ent_fam);
        ?>
         <table class="table" id="table-fam">
             <thead class='table-light'>
                 <tr>
                     <th class="col-1">#</th>
                     <th class="col-1">fecha</th>
                     <th class="col-2">Beneficiario</th>
                     <th class="col-1">Tipo</th>
                     <th class="col-4">Referencia</th>
                     <th class="col-3">Financiero</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                    $i = 1;
                    foreach ($data_fam as $row) { ?>
                     <tr>
                         <td><?= $i ?></td>
                         <td><?= $row['fecha_crea'] ?></td>
                         <td><?= '[' . $row['cep'] . '] ' . $row['nombre_completo'] ?></td>
                         <td><?= $row['cod_tipo_text'] ?></td>
                         <td><?= $row['referencia'] ?></td>
                         <td><?php
                        $partes_banco_fam = explode('-', trim((string) $row['c_banco']), 2);
                        $cuenta_bancaria_fam = $partes_banco_fam[1] ?? $row['c_banco'];
                        echo $cuenta_bancaria_fam . ' =>' . $row['fecha_operacion'] . ' => S/. ' . decimal($row['monto'], 2) . ' =>' . $row['operacion'];
                     ?></td>
                     </tr>
                 <?php $i++;
                    } ?>
             </tbody>
         </table>
     <?php } else { 
        $data_resumen = $bo_fam->resumen($ent_fam);
        ?>
        <div id="print-section" class="print-section">
            <table class="table table-borderless table-sm">
            <tr class="texto_printer">
                <td class="text-center" colspan="2"><h3>FONDO DE AYUDA MUTUA (FAM) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $cod_mes."/".$cod_anho?></h3>
                </td>
            </tr>
            <tr class="texto_printer">
                <td>Usuario: <strong><?php echo $user_nombre ?></strong></td>
                <td class="text-end"><?php echo fecha_hora_hoy() ?></td>
            </tr>
	</table>
         <table class='table table-sm table-bordered'>
             <thead class='table-light'>
                 <tr>
                     <th rowspan="2">#</th>
                     <th rowspan="2">CONSEJO REGIONAL</th>
                     <th colspan="2" class="text-center">SIN DATO</th>
                     <th colspan="2" class="text-center">ENFERMEDAD</th>
                     <th colspan="2" class="text-center">CAPACITACION</th>
                     <th colspan="2" class="text-center">FALLECIMIENTO</th>
                     <th colspan="2" class="text-center">RECREACIÓN</th>
                     <th colspan="2" class="text-center">COVID-19</th>
                 </tr>
                 <tr>
                     <td class="text-center">Cant.</td>
                     <td class="text-end">Monto</td>
                     <td class="text-center">Cant.</td>
                     <td class="text-end">Monto</td>
                     <td class="text-center">Cant.</td>
                     <td class="text-end">Monto</td>
                     <td class="text-center">Cant.</td>
                     <td class="text-end">Monto</td>
                     <td class="text-center">Cant.</td>
                     <td class="text-end">Monto</td>
                     <td class="text-center">Cant.</td>
                     <td class="text-end">Monto</td>
                 </tr>
             </thead>
             <tbody>
                <?php $i=1;
                foreach ($data_resumen as $res) {?>
                 <tr>
                     <td><?= $i?></td>
                     <td><?= $res['nombre1']?></td>
                     <td class="text-center"><?= $res['cantidad0']?></td>
                     <td class="text-end"><?= decimal($res['total0'],2)?></td>
                     <td class="text-center"><?= $res['cantidad1']?></td>
                     <td class="text-end"><?= decimal($res['total1'],2)?></td>
                     <td class="text-center"><?= $res['cantidad2']?></td>
                     <td class="text-end"><?= decimal($res['total2'],2)?></td>
                     <td class="text-center"><?= $res['cantidad3']?></td>
                     <td class="text-end"><?= decimal($res['total3'],2)?></td>
                     <td class="text-center"><?= $res['cantidad4']?></td>
                     <td class="text-end"><?= decimal($res['total4'],2)?></td>
                     <td class="text-center"><?= $res['cantidad5']?></td>
                     <td class="text-end"><?= decimal($res['total5'],2)?></td>
                 </tr>
                 <?php $i++;} ?>
                 <tfoot class="table-light">
                    <?php 
                    $data_resumen_t = $bo_fam->resumen_total($ent_fam);
                    foreach ($data_resumen_t  as $tot) {?>
                    <tr>
                       <th colspan="2" class="text-end">Total</th>
                       <th class="text-center"><?= $tot['cantidad_tipo_0']?></th>
                       <th class="text-end"><?= decimal($tot['monto_tipo_0'],2)?></th>
                       <th class="text-center"><?= $tot['cantidad_tipo_1']?></th>
                       <th class="text-end"><?= decimal($tot['monto_tipo_1'],2)?></th>
                       <th class="text-center"><?= $tot['cantidad_tipo_2']?></th>
                       <th class="text-end"><?= decimal($tot['monto_tipo_2'],2)?></th>
                       <th class="text-center"><?= $tot['cantidad_tipo_3']?></th>
                       <th class="text-end"><?= decimal($tot['monto_tipo_3'],2)?></th>
                       <th class="text-center"><?= $tot['cantidad_tipo_4']?></th>
                       <th class="text-end"><?= decimal($tot['monto_tipo_4'],2)?></th>
                       <th class="text-center"><?= $tot['cantidad_tipo_5']?></th>
                       <th class="text-end"><?= decimal($tot['monto_tipo_5'],2)?></th>
                    </tr>
                    <?php } ?>
                 </tfoot>
             </tbody>
         </table>
        </div>
        <div class="flex-grow-1 ms-2 text-center">
	        <?= bt_imprimirDiv();?>
        </div>
     <?php } ?>
 </div>