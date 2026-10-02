 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();
    $bo_teso_conc = new bo_teso_conciliacion_mensual();

    $ent_teso_conc = new teso_conciliacion_mensual();

    $cod_anho = $_REQUEST['cod_anho'] ?? '';
    $cod_mes = $_REQUEST['cod_mes'] ?? '';

    $ent_teso_conc->setCod_anho($cod_anho);
    $ent_teso_conc->setCod_mes($cod_mes);
    $data_concilacion = $bo_teso_conc->ListarPeriodoReporte($ent_teso_conc); ?>
 <div class="row">
     <div class="col-12">
         <div class="table-responsive">
             <table class="table table-nowrap table-sm">
                 <thead class='table-light'>
                     <tr>
                         <th>#</th>
                         <th>Consejo Regional
                             <button type="button" class="btn btn-outline-info waves-effect waves-light shadow-none" onclick="fn_imprimir('<?= s_crypt($cod_anho) ?>','<?= s_crypt($cod_mes) ?>')">
                                 Imprimir
                             </button>
                         </th>
                         <th class="text-end">%</th>
                         <th class="text-end">Monto a Liq.</th>

                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $i = 1;
                        foreach ($data_concilacion as $row) { ?>
                         <tr>
                             <td><?= $i ?></td>
                             <td><a href="javascript:fn_buscarRegistroDetalle('<?php echo s_crypt($row["c_local"], 'in') ?>','<?= s_crypt($cod_anho, 'in') ?>','<?= s_crypt($cod_mes, 'in') ?>');"><?= $row['c_local_text'] ?> <?php if ($row['n'] == '1') { ?> <i class='fas fa-check-circle text-success'></i><?php } ?></a></td>
                             <td class="text-end"><?= decimal($row['porc_cotizacion'], 0) ?></td>
                             <?php $ent_teso_conc->setCc_local($row['c_local']);
                                $data_concilacion_cdn = $bo_teso_conc->ListarPeriodo_resumen_cdn($ent_teso_conc);
                                $monto = 0;
                                foreach ($data_concilacion_cdn as $mon) {
                                    $monto = $monto + $mon['monto'];
                                }
                                ?>
                             <td class="text-end"><?= decimal($monto, 2) ?></td>
                         </tr>
                     <?php $i++;
                        } ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>