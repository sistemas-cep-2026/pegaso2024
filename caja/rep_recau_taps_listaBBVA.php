<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_recaud_bbva_proceso_detalle.php");
$bo_general = new bo_general();
$bo_recaudobbva = new bo_recaud_bbva_proceso_detalle();

$ent_recaudobbva = new recaud_bbva_proceso_detalle();

$tipo = $_GET['c_tipo'] ?? $_POST['c_tipo'] ?? '';
$var = $_GET['periodo'] ?? $_POST['periodo'] ?? '';

$periodo = substr($var, 3, 4) . substr($var, 0, 2);
if ($tipo == 'H') {
    $periodo = date('Ym');
}
$cc_local = (s_local() === '28') ? '%' : s_local();

$ent_recaudobbva->setTipo($tipo);
$ent_recaudobbva->setPeriodo($periodo);
$ent_recaudobbva->setC_local($cc_local);

$tipo_val = 'bbva571';
$estado = '0';
$tts100 = 0;

$date_estado = $bo_recaudobbva->recaudadora_conciliado($ent_recaudobbva);
foreach ($date_estado as $rowsd) {
  $estado = $rowsd["recaudo_bbva_571"];
}

if (in_array($tipo, ['H', 'D'])) {

  $data_bbvahoy = $bo_recaudobbva->listar($ent_recaudobbva);
  $data_bbvatotal = $bo_recaudobbva->total_recaudo($ent_recaudobbva);
  foreach ($data_bbvatotal as $tot) {
    $cantidad = $tot['cantidad'];
    $t = $tot['total_total_distribuir'];
    $tn = $tot['total_nacional'];
    $tcr = $tot['total_region'];
    $tfijoregion = $tot['total_fijoregion'];
    $tfijon = $tot['total_fijon'];
  }

  $date_estado = $bo_general->periodos_recaudadoras($periodo);
  $bcp = $date_estado[0]['bcp'] ?? null;
?>

   <table width="100%">
    <tr>
      <td align="center">CUENTA RECAUDADORA BBVA DETALLLE <?php if($tipo==='H'){ echo "DIA.";}else{ ECHO "MES.";} ?></strong></td>
    </tr>
    <tr>
      <td align="center">PERIODO=&gt; <?php echo $periodo ?> <?php echo essalud_y_recaudo($tipo_val, $estado); ?></strong></td>
    </tr>
  </table>
	 
    <table class="table table-hover table-sm" id="table-reportebbva">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>NOMBRE</th>
          <th>CEP/DNI</th>
          <th>FECHA</th>
          <th>HORA</th>
          <th>FECHA SIS</th>
          <th>CONCEPTO</th>
          <th>OP</th>

          <th>CR</th>
          <th class="text-end">MONTO</th>
          <th class="text-end">=&gt;</th>
          <th class="text-end">FIJO CDN</th>
          <th class="text-end">%CDN</th>
          <th class="text-end">%CR</th>
          <th class="text-end">FIJO CR</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($data_bbvahoy as $row) {
        ?>
          <tr>
            <td><?php echo $i . '-' . $row["id"]; ?></td>
            <td><?php echo $row["nombre2"] ?></td>
            <td><?php echo $row["c_cmp"] ?></td>
            <td><?php echo $row["fecha"] ?></td>
            <td><?php echo $row["hora"] ?></td>
            <td><?php echo $row["fecha_id"] ?></td>
            <td><?php echo $row["nombre1"] ?></td>
            <td><?php echo   $row["operacion_canal"]; ?></td>

            <td><?php echo $row["c_local"] ?></td>
            <td class="text-end"><?php echo decimal($row["total_distribuir"], 2) ?></td>
            <td class="text-end"><span>=&gt;</span></td>
            <td class="text-end"><?php echo decimal($row["fijonacional"], 2) ?></td>
            <td class="text-end"><?php echo decimal($row["nacional"], 2) ?></td>
            <td class="text-end"><?php echo decimal($row["region"], 2) ?></td>
            <td class="text-end"><?php echo decimal($row["fijoregion"], 2) ?></td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
      <footer>
        <tr>
          <th colspan="7"></th>
          <th class="text-end">TOTAL :</th>
          <th><?php echo $cantidad ?></th>
          <th class="text-end"><?php echo decimal($t, 2) ?></th>
          <th class="text-end"><span>=&gt;</span></th>
          <th class="text-end"><?php echo decimal($tfijon, 2) ?></th>
          <th class="text-end"><?php echo decimal($tn, 2) ?></th>
          <th class="text-end"><?php echo decimal($tcr, 2) ?></th>
          <th class="text-end"><?php echo decimal($tfijoregion, 2) ?></th>
        </tr>
      </footer>
    </table>
  </div>
<?php } elseif ($tipo == 'R') {

  $data_local = $bo_general->listar28Regiones();

?>
  <table width="100%">
    <tr>
      <td align="center">CUENTA RECAUDADORA BBVA (RESUMEN POR MES)</strong></td>
    </tr>
    <tr>
      <td align="center">PERIODO=&gt; <?php echo $periodo ?> <?php echo essalud_y_recaudo($tipo_val, $estado); ?></strong></td>
    </tr>
  </table>
  <div style="font-size: 9px; color:#000">
    <table width="100%">
      <tr>

        <?php  
        $t = 0;
        $tn = 0;
        $tcr = 0;
        $tfcr = 0;

        foreach ($data_local as $row) {
          
        ?>



          <th> <strong>CR <?php echo $row["nombre1"] ?> </th>
          <th class="text-end">RECAUDADO</th>
          <th class="text-end">FIJO CN</th>
          <th class="text-end">(100 CN-&gt;CR)</th>
          <th class="text-end">FIJO CR</th>
          <th class="text-end">COTI. X DIST.</th>
          <th class="text-end">CN <?php echo $row["porc_cotizacion"]; ?>%</th>
          <th class="text-end">CR <?php echo 100 - $row["porc_cotizacion"] ?>%</th>



      </tr>

      <?php $t2 = 0;
          $s100 = 0;
          $ts100 = 0;
          $tn2 = 0;
          $tcr2 = 0;
          $tfcr2 = 0;
          $tfcn = 0;
          $fcn = 0;
          $vcn = 0;
          $tvcn = 0;
          $x_distribuir_t = 0;
          $ent_recaudobbva->setC_local($row["c_local"]);
          $data2 = $bo_recaudobbva->recaudo_resumen($ent_recaudobbva);
          foreach ($data2 as $row2) {
            $fcn = 0;
            $t = $t + $row2["total"];
            $tn = $tn + $row2["nacional"];
            $tcr = $tcr + $row2["region"];
            $tfcr = $tfcr + $row2["fijoregion"];
            if ($row2["dd"] == 'M') {
               
              $rango = (substr($periodo, 0, 4) . substr($periodo, 4, 2));
              if ($rango >= 200101 && $rango <= 202207) {
                $tfcn = ($tfcn + (400 * $row2["tt"]));
                $fcn = (400 * $row2["tt"]);
                $vcn = $row2["nacional"] - (400 * $row2["tt"]);
              }
              if ($rango >= 202208 && $rango <= 202412) {
                if ($row["c_local"] <> '03') {
                  $tfcn = ($tfcn + (670 * $row2["tt"]));
                  $fcn = (670 * $row2["tt"]);
                  $s100 = (100 * $row2["tt"]);
                  $vcn = $row2["nacional"] - (670 * $row2["tt"]) - $s100;
                } else {
                  $tfcn = ($tfcn + (770 * $row2["tt"]));
                  $fcn = (770 * $row2["tt"]);
                  $s100 = (0 * $row2["tt"]);
                  $vcn = $row2["nacional"] - (770 * $row2["tt"]);
                }
              }
              if ($rango >= 202501 && $rango <= 202812) {

                $tfcn = ($tfcn + (770 * $row2["tt"]));
                $fcn = (770 * $row2["tt"]);
                $s100 = (0 * $row2["tt"]);
                $vcn = $row2["nacional"] - (770 * $row2["tt"]);
              }
            } else {
              $vcn = $row2["nacional"];
              $fcn = $row2["fijocn"];
              $tfcn = $tfcn + $fcn;
            }
            $tvcn = $tvcn + $vcn;
            $t2 = $t2 + $row2["total"];
            $tn2 = $tn2 + $row2["nacional"];
            $tcr2 = $tcr2 + $row2["region"];
            $tfcr2 = $tfcr2 + $row2["fijoregion"];
            $x_distribuir_t = $x_distribuir_t + ($row2["total"] - ($fcn + $s100));
            $ts100 = $ts100 + $s100;
      ?>
        <tr>

          <td><?php echo $row2["nombre1"] ?></td>
          <td align="right"><?php echo decimal($row2["total"], 2) ?></td>
          <td align="right"><?php echo decimal($fcn, 2); ?></td>
          <td align="right"><?php echo decimal($s100, 2);  ?></td>
          <td align="right"><?php echo decimal($row2["fijoregion"], 2) ?></td>
          <td align="right"><?php echo decimal($row2["total"] - $fcn - $s100, 2) ?></td>
          <td align="right"><?php echo decimal($vcn, 2); ?></td>
          <td align="right"><?php echo decimal($row2["region"], 2);
                            $s100 = 0; ?></td>

        </tr>

      <?php    }  ?>
      <tr>


        <td align="right"><strong> =></strong></td>
        <td align="right"> <strong>
            <?php echo decimal($t2, 2) ?>
          </strong></td>
        <td align="right"> <strong>
            <?php echo decimal($tfcn, 2) ?>
          </strong></td>
        <td align="right"><strong>
            <?php echo  decimal($ts100, 2) ?>
          </strong></td>
        <td align="right"><strong>
            <?php echo  decimal($tfcr, 2) ?>
          </strong></td>
        <td align="right"> <strong>
            <?php echo decimal($x_distribuir_t, 2) ?>
          </strong></td>
        <td align="right"><strong>
            <?php echo decimal($tvcn, 2) ?>
          </strong></td>
        <td align="right"><strong>
            <?php echo  decimal($tcr2 + $tfcr2, 2) ?>
          </strong></td>
      </tr>
      <tr>

        <td colspan="8" align="right">=<?php $dif = decimal(($x_distribuir_t * ($row["porc_cotizacion"] / 100) - $tvcn), 2);

 

                                        if ($dif > 0.00) {
                                          echo 'REDONDEO A FAVOR CR = S/.' . $dif;
                                        } elseif ($dif < 0.00) {
                                          echo 'AJUSTE AL CR= S/.' . $dif;
                                        }
                                        ?></td>

      </tr>

      <tr>
        <td colspan="7" align="right"><strong> CDN FIJO (<?php echo decimal($tfcn, 2) ?>) + <?php echo decimal($row["porc_cotizacion"], 0); ?>%(<?php echo  decimal($tvcn, 2) ?>) ==&gt;
          </strong></td>
        <td align="right"><strong><?php echo decimal($tfcn + $tvcn, 2) ?></strong>
      </tr>
      <tr>
        <td colspan="7" align="right"><strong>CR FIJO  (<?php echo decimal($tfcr, 2) ?>) + SOLIDARIO 100 (<?php echo decimal($ts100, 2);
                                                                                                                                                    $tts100 = $tts100 + $ts100; ?>) + <?php echo decimal(100 - $row["porc_cotizacion"], 0); ?>%(<?php echo  decimal($tcr2 + $tfcr2, 2) ?>) ==&gt;
          </strong></td>
        <td align="right"><strong> <?php echo decimal($tcr2 + $ts100, 2) ?>
          </strong></td>
      </tr>
      <tr>

        <td colspan="7" align="right"><strong> TOTAL RECAUDADO ==&gt; </strong></td>
        <td align="right"><strong><?php echo decimal($t2, 2) ?></strong></td>
      </tr>
      <tr>
        <td colspan="7" align="center">***************************</strong></td>
      </tr>
    <?php } ?>

    <tr>



      <th class="text-right"><?php echo essalud_y_recaudo($tipo_val, $estado); ?>*JUL/22 - DIC/24 BONO SOLIDARIO 100 SOLES</th>
      <th></th>
      <td></td>
      <td></td>

      <td></td>
      <td align="right"></td>
      <td align="right"><strong>CR =&gt;</strong> </td>
      <td align="right"><strong> S/. <?php echo decimal($tcr + $tfcr + $tts100, 2) ?></strong></td>
    </tr>

    <th class="text-right"><?php echo essalud_y_recaudo($tipo_val, $estado); ?></th>
    <th></th>
    <td></td>

    <td></td>
    <td></td>
    <td align="right"></td>

    <td align="right"><strong>CN=&gt; </strong></td>
    <td align="right"><strong>S/. <?php echo decimal($tn - $tts100, 2)  ?></strong></td>
    </tr>
    <th class="text-right"><?php echo essalud_y_recaudo($tipo_val, $estado); ?></th>
    <th></th>
    <td></td>

    <td></td>
    <td></td>
    <td></td>

    <td align="right"><strong> ===&gt;</strong></td>
    <td align="right"><strong>S/. <?php echo decimal($t, 2) ?></strong></td>
    </tr>
    </table>
  </div>
<?php }  ?>