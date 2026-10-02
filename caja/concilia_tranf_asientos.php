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
    $data_concilacion = $bo_teso_conc->ListarPeriodoAsientos($ent_teso_conc);
    if (empty($data_concilacion)) {
        echo errors("No existen datos en este periodo");
        exit();
    }
    ?>
 <div class="row">
     <div class="col-12">
         <div class="table-responsive">
             <table class="table table-nowrap table-sm mb-0">
                 <thead class="table-light ">
                     <tr>
                         <th rowspan="2" class="align-middle">#</th>
                         <th rowspan="2" class="align-middle">DETALLE</th>
                         <th colspan="2" class="text-center">BBVA</th>
                         <th colspan="2" class="text-center">BCP</th>
                         <th colspan="2" class="text-center">CAJA</th>
                         <th colspan="2" class="text-center">ESSALUD</th>
                         <th rowspan="2" class="text-end">ASIENTO</th>
                         <th rowspan="2" class="text-center">OPT</th>
                     </tr>
                     <tr>
                         <th class="text-end">NACIONAL</th>
                         <th class="text-end">REGIONAL</th>
                         <th class="text-end">NACIONAL</th>
                         <th class="text-end">REGIONAL</th>
                         <th class="text-end">NACIONAL</th>
                         <th class="text-end">REGIONAL</th>
                         <th class="text-end">NACIONAL</th>
                         <th class="text-end">REGIONAL</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $i = 1;
                        foreach ($data_concilacion as $row) { ?>
                         <tr>
                             <td><?= $i ?></td>
                             <td><?= $row['nombre'] ?></td>
                             <td class="text-end"><?= decimal($row['bbva_nac'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['bbva_reg'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['bcp_nac'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['bcp_reg'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['caja_nac'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['caja_reg'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['essalud_nac'], '2') ?></td>
                             <td class="text-end"><?= decimal($row['essalud_reg'], '2') ?></td>
                             <td class="text-end">
                                 <?php if ($row['asiento'] != null) { ?>
                                     <a href="javascript:void(0);" onclick="fn_imprimirAsientos('<?= s_crypt($row['asiento'], 'in') ?>')">
                                         <?= $row['asiento'] ?>
                                     </a>
                                 <?php } ?>
                             </td>
                             <?php
                                $icono = ($row['asiento'] != null) ? 'fa-ban' : 'fa-paper-plane';
                                $color = ($row['asiento'] != null) ? 'text-danger' : '';
                                ?>
                             <td class="text-end">
                                 <a href="javascript:void(0);" onclick="fn_agregarAsiento('<?= s_crypt($row['cc_local'], 'in') ?>','<?= s_crypt($cod_anho, 'in') ?>','<?= s_crypt($cod_mes, 'in') ?>','<?= s_crypt(s_usuario(), 'in') ?>')" class="btn btn-outline-secondary waves-effect btn-sm">
                                     <i class="fas <?= $icono ?> <?= $color ?>"></i>
                                 </a>
                             </td>
                         </tr>
                     <?php $i++;
                        } ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>