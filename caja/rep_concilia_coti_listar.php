 <?php
   require_once(dirname(__DIR__) . "/util/seguridad.php");
   require_once(dirname(__DIR__) . "/util/util.php");
   s_validar_pagina();
   require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
   require_once(u_src() . "bo/bo_general.php");

   $bo_general = new bo_general();
   $bo_teso_conc = new bo_teso_conciliacion_mensual();

   $ent_teso_conc = new teso_conciliacion_mensual();

   //$cc_local = s_local();
   $cod_anho = $_REQUEST['cod_anho'] ?? '';
   $cod_mes = $_REQUEST['cod_mes'] ?? '';

   $ent_teso_conc->setCod_anho($cod_anho);
   $ent_teso_conc->setCod_mes($cod_mes);

   if (s_local_vinculado() == '28') {
      // REPORTE PARA EL cdn
      $user_color1 = 'Dark';
      $user_color2 = 'Dark';
      $data_concilacion = $bo_teso_conc->ListarPeriodoReporte($ent_teso_conc);

      foreach ($data_concilacion as $bbva) {
         $usuario1 = $bbva['usuario'];
         $usuario2 = $bbva['usuario2'];
         $user_color1 = !empty($usuario1) ? 'text-success' : '';
         $user_color2 = !empty($usuario2) ? 'text-success' : '';
      }


   ?>
    <div class="table-responsive">
       <table class="table table-nowrap table-sm">
          <thead class='table-light'>
             <tr>
                <th>#</th>
                <th>Consejo Regional</th>
                <th>Contador(a)</th>
                <th>Fecha</th>
                <th>Tesorera(o)</th>
                <th>Fecha</th>
                <th class="text-end">%</th>
                <th class="text-end">Caja</th>
                <th class="text-end">caja Liq.</th>
                <th class="text-end">Dif.</th>
                <th class="text-end">Monto a Liq.</th>

                <th class="text-center">Print</th>
             </tr>
          </thead>
          <tbody>
             <?php
               $i = 1;
               $total_monto = 0;
               foreach ($data_concilacion as $row) { ?>
                <tr>
                   <td><?= $i ?></td>
                   <td><?= $row['c_local_text'] ?></td>
                   <td><?= $row['usuario'] ?></td>
                   <td><?= $row['fecha'] ?></td>
                   <td><?= $row['usuario2'] ?></td>
                   <td><?= $row['fecha2'] ?></td>

                   <td class="text-end"><?= decimal($row['porc_cotizacion'], 0) ?></td>
                   <?php $ent_teso_conc->setCc_local($row['c_local']);
                     $data_concilacion_cdn = $bo_teso_conc->ListarPeriodo_resumen_cdn($ent_teso_conc);
                     $monto = 0;
                     foreach ($data_concilacion_cdn as $mon) {
                        $monto = $monto + $mon['monto'];
                     }
                     $total_monto += $monto;
                     ?>
                   </td>
                   <td class="text-end"><?php
                                          $cajaj = 0;
                                          $data_concilacion_dif_caja = $bo_teso_conc->ListarPeriodoReporte_dif_caja($ent_teso_conc);
                                          // print_r($data_concilacion_dif_caja);
                                          foreach ($data_concilacion_dif_caja as $caja) {
                                             $cajaj = $caja['total'];
                                          }
                                          echo  decimal($cajaj, 2);
                                          ?>
                   </td>
                   <td class="text-end"><?php $liql = 0;
                                          $data_concilacion_dif_liq = $bo_teso_conc->ListarPeriodoReporte_dif_liq($ent_teso_conc);
                                          foreach ($data_concilacion_dif_liq as $liq) {
                                             $liql = $liq['total'];
                                          }
                                          echo  decimal($liql, 2);
                                          ?>
                   </td>
                   <td class="text-end"><?php
                                          echo  decimal(($cajaj - $liql), 2);
                                          ?>
                   </td>

                   <td class="text-end"><?= decimal($monto, 2);
                                          ?></td>
                   <td class="text-center">
                      <a href="#" onclick="fn_imprimir('<?= s_crypt($cod_anho) ?>','<?= s_crypt($cod_mes) ?>','<?= s_crypt($row['c_local']) ?>')" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i class="fas fa-print"></i></a>
                   </td>

                </tr>
             <?php $i++;
               } ?>
             <tr>
                <th colspan="10" class="text-end">Total=></th>
                <th class="text-end"><?= decimal($total_monto, 2) ?></th>
                <th></th>
             </tr>
          </tbody>
       </table>
    </div>

 <?php } else { //REPORTE PARA LAS REGIONES

      $user_color1 = 'Dark';
      $user_color2 = 'Dark';
      $ent_teso_conc->setCc_local(s_local());
      $data_concilacion = $bo_teso_conc->ListarPeriodoReporte_cr($ent_teso_conc);

      foreach ($data_concilacion as $bbva) {
         $usuario1 = $bbva['usuario'];
         $usuario2 = $bbva['usuario2'];
         $user_color1 = !empty($usuario1) ? 'text-success' : '';
         $user_color2 = !empty($usuario2) ? 'text-success' : '';
      }
   ?>
    <div class="table-responsive">
       <table class="table table-nowrap table-sm">
          <thead class='table-light'>
             <tr>
                <th>#</th>
                <th>Consejo Regional</th>
                <th>Año/Mes</th>

                <th class="text-end">%</th>
                <th class="text-end">Caja</th>
                <th class="text-end">caja Liq.</th>
                <th class="text-end">Dif.</th>
                <th class="text-end">Monto a Liq.</th>
                <th>Fecha Transferencia</th>
                <th>Cuenta Origen</th>
                <th class="text-end">Monto Transferido</th>
                <th>Obs CDN</th>


                <th class="text-center">Print</th>
             </tr>
          </thead>
          <tbody>
             <?php
               $i = 1;
               foreach ($data_concilacion as $row) { ?>
                <tr>
                   <td><?= $i ?></td>
                   <td><?= $row['c_local_text1'] ?></td>
                   <td><?= $row['cod_anho'] . '/' . $row['cod_mes'] ?></td>


                   <td class="text-end"><?= decimal($row['porc_cotizacion'], 0) ?></td>
                   <?php $ent_teso_conc->setCc_local($row['cc_local']);
                     $ent_teso_conc->setCod_mes($row['cod_mes']);
                     $data_concilacion_cdn = $bo_teso_conc->ListarPeriodo_resumen_cdn($ent_teso_conc);
                     $monto = 0;
                     foreach ($data_concilacion_cdn as $mon) {
                        $monto = $monto + $mon['monto'];
                     }
                     ?>
                   </td>
                   <td class="text-end"><?php
                                          $cajaj = 0;
                                          $data_concilacion_dif_caja = $bo_teso_conc->ListarPeriodoReporte_dif_caja($ent_teso_conc);
                                          foreach ($data_concilacion_dif_caja as $caja) {
                                             $cajaj = $caja['total'];
                                          }
                                          echo  decimal($cajaj, 2);
                                          ?>
                   </td>
                   <td class="text-end"><?php $liql = 0;
                                          $data_concilacion_dif_liq = $bo_teso_conc->ListarPeriodoReporte_dif_liq($ent_teso_conc);
                                          foreach ($data_concilacion_dif_liq as $liq) {
                                             $liql = $liq['total'];
                                          }
                                          echo  decimal($liql, 2);
                                          ?>
                   </td>
                   <td class="text-end"><?php
                                          echo  decimal(($cajaj - $liql), 2);
                                          ?>
                   </td>

                   <td class="text-end"><?= decimal($monto, 2);
                                          ?></td>

                   <td><?= $row['vfecha'] ?></td>
                   <td><?= $row['banco_cuenta'] ?></td>
                   <td class="text-end"><?= 'S/. ' . decimal($row['vmonto'], 2); ?></td>
                   <td><?= $row['obs'] ?></td>

                   <td class="text-center">
                      <a href="#" onclick="fn_imprimir('<?= s_crypt($row['cod_anho']) ?>','<?= s_crypt($row['cod_mes']) ?>','<?= s_crypt($row['cc_local']) ?>')" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i class="fas fa-print"></i></a>
                   </td>
                </tr>
             <?php $i++;
               } ?>
          </tbody>
       </table>
    </div>

 <?php } ?>