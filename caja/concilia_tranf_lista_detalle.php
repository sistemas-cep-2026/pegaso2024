 <?php
  require_once(dirname(__DIR__) . "/util/seguridad.php");
  require_once(dirname(__DIR__) . "/util/util.php");
  s_validar_pagina();
  require_once(u_src() . "bo/bo_teso_conciliacion_mensual_transferencia.php");
  require_once(u_src() . "bo/bo_general.php");

  $bo_general = new bo_general();
  $bo_tesodetalle = new bo_teso_conciliacion_mensual_transferencia();

  $ent_tesodetalle = new teso_conciliacion_mensual_transferencia();

  $cc_concimen = s_crypt($_REQUEST['cc_concimen'], 'out') ?? '';

  $cc_local = s_crypt($_REQUEST['cc_local'] ?? '', 'out');
  $cc_local = $cc_local ?: '01';

  $cod_anho = s_crypt($_REQUEST['cod_anho'], 'out') ?? '';
  $cod_mes = s_crypt($_REQUEST['cod_mes'], 'out') ?? '';

  $data_local = $bo_general->RegionID($cc_local);
  foreach ($data_local as $loc) {
    $c_local_text = $loc['nombre'];
  }
  $data_cuentas = $bo_general->ListarcuentasBancarias_activas('28', '', '', '');

  $ent_tesodetalle->setCc_local($cc_local);
  $ent_tesodetalle->setCod_anho($cod_anho);
  $ent_tesodetalle->setCod_mes($cod_mes);
  $data_concilacion_det = $bo_tesodetalle->ListarConciDetalle($ent_tesodetalle); ?>
 <h3><i class='fas fa-caret-right'></i> <?= $c_local_text; ?></h3>
 <div class="row">
   <div class="col-12">
     <div class="table-responsive">
       <table class="table table-nowrap">
         <thead class='table-light'>
           <tr>
             <th>#</th>
             <th>Banco</th>
             <th>Fecha</th>
             <th>OP</th>
             <th class="text-end">Monto</th>
             <th class="text-center">Opt</th>
           </tr>
         </thead>
         <tbody>
           <?php
            $i = 1;
            foreach ($data_concilacion_det as $row) { ?>
             <tr>
               <td><?= $i ?></td>
               <td><?= $row['banco_cuenta'] ?></td>
               <td><?= $row['vfecha_text'] ?></td>
               <td><?= $row['vnop'] ?></td>
               <td class="text-end"><?= decimal($row['vmonto'], 2) ?></td>
               <td class="text-center">
                 <a href="javascript:fn_eliminarDeta('<?= s_crypt($row["cc_transferencia"], 'in') ?>','<?= s_crypt('E', 'in') ?>');"><i class='fas fa-trash-alt text-danger'></i></a>
               </td>
             </tr>
           <?php $i++;
            } ?>
         </tbody>
       </table>
     </div>
   </div>
 </div>
 <form action="javascript:fn_GuardarRegistroDetalle();" id="frmGuardarRegistroDetalle" novalidate>
   <div class="row">
     <div class="col-md-6 col-12">
       <div class="input-group mb-3">
         <span class="input-group-text">Cta. Cte :</span>
         <select name="banco_cuenta" id="banco_cuenta" class="form-control" required>
           <option value="">Cuenta bancaria</option>
           <?php foreach ($data_cuentas as $row): ?>
             <option value="<?= $row['c_cta_corriente'] ?>"><?= $row['c_cta_corriente'] ?></option>
           <?php endforeach; ?>
         </select>
       </div>
     </div>
     <div class="col-md-6 col-12">
       <div class="input-group mb-3">
         <span class="input-group-text">Fecha :</span>
         <input type="date" class="form-control" name="vfecha" id="vfecha" value="<?= date('Y-m-d') ?>" required>
       </div>
     </div>
   </div>
   <div class="row">
     <div class="col-md-6 col-12">
       <div class="input-group mb-3">
         <span class="input-group-text">N° OP :</span>
         <input type="text" class="form-control" name="vnop" id="vnop" required>
       </div>
     </div>
     <div class="col-md-6 col-12">
       <div class="input-group mb-3">
         <span class="input-group-text">S/. :</span>
         <input type="text" class="form-control input-decimal" name="vmonto" id="vmonto" placeholder="S/. 0.00" required>
       </div>
     </div>
   </div>
   <div class="row">
     <div class="col-md-12 col-12">
       <div class="input-group mb-3">
         <span class="input-group-text">Observación :</span>
         <input type="text" class="form-control" name="obs" id="obs">
       </div>
     </div>
   </div>

   <div class="row">
     <div class="col-md-12 col-12 text-center">
       <input type="hidden" name="opc" id="opc" value="<?= s_crypt('I', 'in') ?>">
       <input type="hidden" name="cc_locald" id="cc_locald" value="<?= s_crypt($cc_local, 'in') ?>">
       <input type="hidden" name="cod_anhod" id="cod_anhod" value="<?= s_crypt($cod_anho, 'in') ?>">
       <input type="hidden" name="cod_mesd" id="cod_mesd" value="<?= s_crypt($cod_mes, 'in') ?>">
       <?= bt_guardar(); ?> <?= bt_cerrar(); ?>
     </div>
   </div>
 </form>
 <script>
   $("#frmGuardarRegistroDetalle").validate();
   $('.input-decimal').inputmask({
     alias: "decimal",
     integerDigits: 10,
     digits: 2,
     allowMinus: false,
     digitsOptional: false,
     placeholder: "0.00",
     groupSeparator: ',',
     prefix: 'S/ ',
     autoGroup: true,
     rightAlign: false
   });
 </script>