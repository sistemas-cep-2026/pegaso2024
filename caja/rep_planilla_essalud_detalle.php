 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_general.php");
    require_once(u_src() . "bo/bo_fin_estado_cuenta_periodo_detalle.php");

    $bo_general = new bo_general();
    $bo_planillaminsa = new bo_fin_estado_cuenta_periodo_detalle();

    $ent_planillaminsa = new fin_estado_cuenta_periodo_detalle();

    $cc_local = s_crypt($_REQUEST['cc_local'], 'out');
    $periodo = s_crypt($_REQUEST['periodo'], 'out');

    $ent_planillaminsa->setCc_local($cc_local);
    $ent_planillaminsa->setPeriodo($periodo);

    $data_plan_essalud_cab = $bo_planillaminsa->PlanillaEssalud_detalle_cabecera($ent_planillaminsa);
    ?>
 <div class="modal-header">
     <h4 class="modal-title">DETALLE DE PLANILLA DE <?= $periodo ?></h4>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
 </div>
 <div class="modal-body">
     <div class="card-body p-0">
         <div class="table-responsive">
             <?php
                $total = 0.0;
                ?>

             <table class="table table-sm table-borderless mb-0">
                 <thead>
                     <tr class="table-light">
                         <th style="width:2rem"></th>
                         <th colspan="2">DATOS</th>
                         <th class="text-end">COD_PLA_ESSALUD</th>
                     </tr>
                 </thead>

                 <tbody>
                     <?php foreach ($data_plan_essalud_cab as $cab): ?>
                         <tr class="table-primary">
                             <th><i class="far fa-caret-square-right"></i></th>
                             <th><?= htmlspecialchars($cab['epa']) ?></th>
                             <th class="text-end" colspan="2"><?= htmlspecialchars($cab['cod_presupuestal']) ?></th>
                         </tr>
                         <?php
                            $ent_planillaminsa->setCod_presupuestal($cab['cod_presupuestal']);
                            $data_plan_essalud_coleg = $bo_planillaminsa->PlanillaEssalud_detalle_colegiado($ent_planillaminsa);

                            foreach ($data_plan_essalud_coleg as $col):
                                $importe = $col['ed_importe1'];
                                $total += $importe;
                            ?>
                             <tr>
                                 <td class="text-end"><i class="fas fa-angle-right"></i></td>
                                 <td>
                                     <span class="fw-semibold"><?= htmlspecialchars($col['c_cmp']) ?></span>
                                     &nbsp;–&nbsp;<?= htmlspecialchars($col['nombre']) ?>
                                 </td>
                                 <td class="text-end">
                                     <?= htmlspecialchars($col['observacion'] ?? '') ?>
                                 </td>
                                 <td class="text-end">
                                     <?= decimal($importe, 2) ?>
                                 </td>
                             </tr>
                         <?php endforeach; ?>
                         <tr>
                             <td colspan="4" class="py-1"></td>
                         </tr>
                     <?php endforeach; ?>
                 </tbody>

                 <tfoot class="table-light fw-semibold">
                     <tr>
                         <td colspan="3" class="text-end">Total</td>
                         <td class="text-end"><?= decimal($total, 2) ?></td>
                     </tr>
                 </tfoot>
             </table>
             <div class="text-end mt-2">
                 <?php echo bt_cerrar(); ?>
             </div>
         </div>
     </div>
 </div>