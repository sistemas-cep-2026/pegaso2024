 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_general.php");
    require_once(u_src() . "bo/bo_gen_parametro_det.php");
    $bo_general = new bo_general();
    $bo_parametro_detalle = new bo_gen_parametro_det();
    $flag = $bo_parametro_detalle->listarParametroDet('documentos_de_venta', 'flag');
    ?>
 <div class="card-body">
     <form class="needs-validation" id="frmBuscarRecibos" action="javascript:fn_buscarRecibos()" method="post" novalidate>
         <div class="row g-3 justify-content-center">
             <div class="col-sm-3">
                 <div class="input-group mb-3">
                     <span class="input-group-text">Desde : </span>
                     <input type="date" class="form-control" id="cod_desde" name="cod_desde" value="<?= fecha_hoy() ?>">
                 </div>
             </div>
             <div class="col-sm-3">
                 <div class="input-group mb-3">
                     <span class="input-group-text">Hasta : </span>
                     <input type="date" class="form-control" id="cod_hasta" name="cod_hasta" value="<?= fecha_hoy() ?>">
                 </div>
             </div>
             <div class="col-sm-3">
                 <div class="input-group mb-3">
                     <span class="input-group-text">Estado : </span>
                     <select name="flag" class="form-control" id="flag">
                         <?php foreach ($flag as $row) { ?>
                             <option value="<?= $row['cc_codigo'] ?>"
                                 <?= ('*' == $row['cc_codigo']) ? 'selected' : '' ?>>
                                 <?= $row['detalle'] ?>
                             </option>
                         <?php } ?>
                     </select>
                 </div>
             </div>
             <div class="col-xxl-3 col-sm-6">
                 <input type="hidden" name="c_local" id="c_local" value="<?= s_local() ?>">
                 <?php echo bt_filtrar("Buscar") ?>
                 <?php echo bt_cancelar() ?>
             </div>
         </div>
     </form>
 </div>
 <div class="col-xxl-12">
     <div class="card-body">
         <div id="divListarRecibos"></div>
     </div>
 </div>