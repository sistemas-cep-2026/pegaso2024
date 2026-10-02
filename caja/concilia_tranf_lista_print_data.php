<!DOCTYPE html>
<html>

<head>
   <title>CONCILIACION COTIZACIONES</title>
   <link rel="stylesheet" type="text/css" href="<?php echo url('css/print_pdf.css'); ?>">
   <style>
   /* Solo aplica bordes a la tabla de datos */
   .tabla-datos,
   .tabla-datos th,
   .tabla-datos td {
      border: 1px solid black;
      border-collapse: collapse;
   }

   .tabla-datos td {
      white-space: nowrap;
      padding: 4px;
   }

   /* Tabla de encabezado sin bordes */
   .tabla-encabezado,
   .tabla-encabezado th,
   .tabla-encabezado td {
      border: none;
   }
</style>
</head>
<table class="tabla-encabezado">
    <thead class="table-light">
                  <tr>
                     <td colspan="2" class="align-middle" style="width: 20%;">
                        <img src="<?php echo logo; ?>" alt="Logo" width="80">
                     </td>
                     <td colspan="6" class="text-center" style="width: 80%;">
                        <h2>CONCILIACION COTIZACIONES <?= $cod_mes . '/' . $cod_anho ?> DETALLE</h2>
                        <p style="text-align:right; font-size:12px; margin:0;">
                           Generado el: <?= date('d/m/Y H:i:s') ?>
                        </p>
                     </td>
                  </tr>

               </thead>
   </table>
<body>
   <div class="row">
      <div class="col-12">
         <div class="table-responsive">
            <table class="tabla-datos table table-nowrap table-sm">
              
               <thead>
                  <tr class="table-active">
                     <th class="text-start">#</th>
                     <th class="text-start">CR</th>
                     <th class="text-start">%</th>
                     <th class="text-end">MONTO A LIQ.</th>
                     <th class="text-start">CUENTA BANCARIA</th>
                     <th class="text-start">OPERACION</th>
                     <th class="text-start">FECHA OP.</th>
                     <th class="text-end">MONTO</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $i = 1;
                  foreach ($data_concilacion as $row) {

                     // Calcular monto total
                     $ent_concilia->setCc_local($row['cc_local']);
                     $data_concilacion_cdn = $bo_teso_conc->ListarPeriodo_resumen_cdn($ent_concilia);
                     $monto_total = 0;
                     foreach ($data_concilacion_cdn as $mon) {
                        $monto_total += $mon['monto'];
                     }

                     // Detalle
                     $ent_tesodetalle->setCc_local($row['cc_local']);
                     $data_concilacion_det = $bo_tesodetalle->ListarConciDetalle($ent_tesodetalle);

                     foreach ($data_concilacion_det as $zzz) {
                  ?>
                        <tr class="align-middle">
                           <td class="col-1"><?= $i ?></td>
                           <td class="col-2"><?= $row['c_local_text1'] ?></td>
                           <td class="col-1 text-end"><?= decimal($row['porc_cotizacion'], 0) ?></td>
                           <td class="col-2 text-end">S/. <?= decimal($monto_total, 2) ?></td>
                           <td class="col-2"><?= $zzz['banco_cuenta'] ?></td>
                           <td class="col-1"><?= $zzz['vnop'] ?></td>
                           <td class="col-2"><?= $zzz['vfecha_text'] ?></td>
                           <td class="col-1 text-end">S/. <?= decimal($zzz['vmonto'], 2) ?></td>
                        </tr>
                  <?php
                     }
                     $i++;
                  }
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</body>

</html>