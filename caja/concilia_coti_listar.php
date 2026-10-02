 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();
    $bo_teso_conc = new bo_teso_conciliacion_mensual();

    $ent_teso_conc = new teso_conciliacion_mensual();

    $cc_local = s_local();
    $cod_anho = substr($_REQUEST['cod_anho'],0,4) ?? '';
     $cod_mes = substr($_REQUEST['cod_anho'],4,2) ?? '';
    //$cod_mes = $_REQUEST['cod_mes'] ?? '';
 
    $ent_teso_conc->setCod_anho($cod_anho);
    $ent_teso_conc->setCod_mes($cod_mes);
    $ent_teso_conc->setCc_local($cc_local);

    $user_color1 = 'Dark';
    $user_color2 = 'Dark';
    $data_concilacion = $bo_teso_conc->ListarPeriodo($ent_teso_conc);
    foreach ($data_concilacion as $bbva) {
        $usuario1 = $bbva['usuario'];
        $usuario2 = $bbva['usuario2'];
        $user_color1 = !empty($usuario1) ? 'text-success' : '';
        $user_color2 = !empty($usuario2) ? 'text-success' : '';
    }
    ?>
 <!-- warning Alert -->
 <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
     <i class="ri-error-warning-line label-icon"></i><strong><?php echo $cod_mes.'/'.$cod_anho; ?> OJO</strong> - Este documento solo será <strong>válido</strong> si tiene las dos firmas &nbsp;&nbsp;&nbsp; || Primera firma
     <i class='fas fa-check-circle <?= $user_color1; ?>' style='font-size:20px'></i> &nbsp;&nbsp;&nbsp; || Segunda firma
     <i class='fas fa-check-circle <?= $user_color2; ?>' style='font-size:20px'></i>
 </div>
<div class="table-responsive">
 <table class="table table-nowrap">
     <thead class='table-light'>
         <tr>
             <th>PERIODO</th>
             <th>PERIODO/LIQ</th>
              <th>Detalle</th>
             <th>Referencia</th>
             <th class="text-center">Cantidad</th>
             <th class="text-end">Total</th>
             <th class="text-end">Regional</th>
             <th class="text-end">Nacional</th>
             <th class="text-end">%</th>
         </tr>
     </thead>
     <tbody>
         <?php foreach ($data_concilacion as $bbva) { ?>
             <tr>
                 <td><?php echo $bbva['cod_mes'].'/'.$bbva['cod_anho'] ?></td>
                 <td><?php if($bbva['periodo']=='*PEND*'){echo $bbva['periodo'];}else{echo substr($bbva['periodo'],4,2).'/'.substr($bbva['periodo'],0,4);} ?></td>
                 <td><?php echo $bbva['entidad_text'] ?></td>
                 <td><?php echo $bbva['referencia'] ?></td>
                 <td class="text-center"><?php echo $bbva['cantidad'] ?></td>
                 <td class="text-end"><?php echo decimal($bbva['regional'] + $bbva['nacional'], 2) ?></td>
                 <td class="text-end"><?php echo decimal($bbva['regional'], 2) ?></td>
                 <td class="text-end"><?php echo decimal($bbva['nacional'], 2) ?></td>
                 <td class="text-end"><?php echo decimal($bbva['porcentaje'], 0) . '%' ?></td>
             </tr>
         <?php } ?>
     </tbody>
     <tfoot>
         <tr>
             <td class="text-center" colspan='2'>
                <?php if($usuario2==null){ ?>
                 <button type="button" class="btn btn-outline-success waves-effect waves-light shadow-none" onclick="fn_concil_from('<?= $cod_anho ?>','<?= $cod_mes ?>')">
                    <?= ((int)$data_concilacion > 0) ? 'Actualiza' : 'Crear Conciliación' ?>
                 </button>
                 <?php } ?>
             </td>
             <td class="text-center" colspan='2'>                
                 <button type="button" class="btn btn-outline-info waves-effect waves-light shadow-none" onclick="fn_imprimir('<?= s_crypt($cod_anho) ?>','<?= s_crypt($cod_mes) ?>','<?= s_crypt($cc_local) ?>')">
                     Imprimir
                 </button>
             </td>
             <td class="text-center" colspan='2'>
                <?php if($usuario2==null){ ?>
                <?php if((int)$data_concilacion > 0) {?>
                <button type="button" class="btn btn-outline-info waves-effect waves-light shadow-none" onclick="fn_segundaFirma('<?= $cod_anho ?>','<?= $cod_mes?>','<?= $cc_local ?>','F')">
                     Segunda Firma
                 </button>
                 <?php }?>
                 <?php }?>
             </td>
         </tr>
     </tfoot>
 </table>
 </div>