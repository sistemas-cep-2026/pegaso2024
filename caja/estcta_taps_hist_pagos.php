 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");

    s_validar_pagina();

    require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
    require_once(u_src() . "bo/bo_recaud_bbva_proceso_detalle.php");

    $bo_docventa = new bo_fin_documentos_de_venta();
    $bo_recaudadora = new bo_recaud_bbva_proceso_detalle();

    $ent_docventa = new fin_documentos_de_venta();

    $c_persona = s_crypt($_REQUEST['cc_persona'], 'out');

    $ent_docventa->setC_persona($c_persona);

    $data_cab = $bo_docventa->listarPersonasPagos($ent_docventa);

    if (count($data_cab) < 1) {
        echo "  No existen registros de pagos.";
    }
    ?>

 <style>
     .tabla-pagos {
         font-size: 12px;
     }

     .tabla-pagos th {
         background: #f1f3f5;
         text-align: center;
         vertical-align: middle;
         white-space: nowrap;
     }

     .tabla-pagos td {
         padding: 5px;
         vertical-align: top;
     }

     .detalle-box {
         border: 1px solid #dee2e6;
         border-radius: 6px;
         padding: 6px;
         background: #fafafa;
     }

     .detalle-table {
         width: 100%;
         font-size: 11px;
         margin-bottom: 0;
     }

     .detalle-table th {
         background: #e9ecef;
         font-size: 10px;
         padding: 3px;
     }

     .detalle-table td {
         padding: 3px;
         border-top: 1px solid #f1f1f1;
     }

     .monto {
         text-align: right;
         white-space: nowrap;
     }

     .badge-origen {
         padding: 3px 6px;
         border-radius: 4px;
         color: #fff;
         font-size: 11px;
         background: #0d6efd;
     }

     .obs {
         max-width: 250px;
         word-break: break-word;
     }
 </style>

 <div class="table-responsive">

     <table class="table table-bordered table-hover table-sm tabla-pagos">

         <thead>
             <tr>
                 <th width="3%">#</th>
                 <th width="9%">FECHA</th>
                 <th width="7%">ORIGEN</th>
                 <th width="10%">DOCUMENTO</th>
                 <th width="8%">MONTO</th>
                 <th width="18%">DATOS</th>
                 <th width="30%">DETALLE DOCUMENTO</th>
                 <th width="15%">ESTADO CUENTA</th>
             </tr>
         </thead>

         <tbody>

             <?php
                $i = 1;

                foreach ($data_cab as $exo) {

                    $monto = 0;
                    $monto_otros = 0;

                    $data = $bo_docventa->listarPersonasPagos_ec(
                        $exo['origen'],
                        $exo['cod_documento'],
                        $exo['num_documento'],
                        $c_persona
                    );
                    $data_otros = $bo_docventa->listarPersonasooOtrosPagos_ec(
                        $exo['origen'],
                        $exo['cod_documento'],
                        $exo['num_documento'],
                        $c_persona
                    );
                ?>

                 <tr>

                     <td class="text-center">
                         <?php echo $i ?>
                     </td>

                     <td class="text-center">
                         <?php echo $exo['fecha'] ?> <?php if ($exo['flag'] == 'A') { ?>
                             <div style="
            margin-top:5px;
            background-color:#dc3545;
            color:white;
            padding:4px 8px;
            border-radius:5px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;">
                                 ANULADO
                             </div>
                         <?php } ?>
                     </td>

                     <td class="text-center">
                         <?php
                            $color = '';

                            switch (strtoupper($exo['origen'])) {
                                case 'CAJA':
                                    $color = 'background-color: green; color:white;';
                                    break;

                                case 'REC. BCP':
                                    $color = 'background-color: orange; color:white;';
                                    break;

                                case 'REC. BBVA':
                                    $color = 'background-color: blue; color:white;';
                                    break;

                                default:
                                    $color = 'background-color: gray; color:white;';
                                    break;
                            }
                            ?>

                         <span class="badge-origen"
                             style="<?php echo $color; ?> padding:5px 10px; border-radius:5px;">
                             <?php echo $exo['origen']; ?>
                         </span>

                         <?php if ($exo['flag'] == 'A') { ?>
                             <div style="
            margin-top:5px;
            background-color:#dc3545;
            color:white;
            padding:4px 8px;
            border-radius:5px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;">
                                 ANULADO
                             </div>
                         <?php } ?>
                     </td>

                     <td>
                         <?php echo $exo['cod_documento'] . ' - ' . $exo['num_documento']; ?> <?php if ($exo['flag'] == 'A') { ?>
                             <div style="
            margin-top:5px;
            background-color:#dc3545;
            color:white;
            padding:4px 8px;
            border-radius:5px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;">
                                 ANULADO
                             </div>
                         <?php } ?>
                     </td>

                     <td class="monto">
                         <?php echo decimal($exo['valor_venta'], 2) ?>
                     </td>

                     <td>
                         <?php
                            $forma_pago = strtoupper(trim($exo['cod_forma_de_pago'] ?? ''));
                            $tipo_pago = '';
                            if ($forma_pago != '') {

                                switch ($forma_pago) {

                                    case 'V':
                                        $tipo_pago = 'VOUCHER';
                                        break;

                                    case 'E':
                                        $tipo_pago = 'EFECTIVO';
                                        break;

                                    default:
                                        $tipo_pago = $exo['cod_forma_de_pago'];
                                        break;
                                }
                            }
                            ?>

                         <div>
                             <strong>TIPO:</strong>
                             <?php echo  $tipo_pago; ?><?php if ($exo['flag'] == 'A') { ?>
                             <div style="
            margin-top:5px;
            background-color:#dc3545;
            color:white;
            padding:4px 8px;
            border-radius:5px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;">
                                 ANULADO
                             </div>
                         <?php } ?>
                         </div>
                         <div><strong>Banco:</strong> <?php echo $exo['nombre'] ?></div>
                         <div><strong>Cuenta:</strong> <?php echo $exo['cta_cte_deposito'] ?></div>
                         <div><strong>N.Ope.:</strong> <?php echo $exo['num_referencia'] ?></div>
                         <div><strong>Fec.Ref:</strong> <?php echo $exo['fecha_referencia'] ?></div>
                     </td>

                     <td class="obs">
                         <?php echo $exo['observacion'] ?>
                        <span style="color: red;"><?php echo ' ' . $exo['obs1']; ?></span>
                         <?php if (count($data_otros) > 0) { ?>
                             <div class="detalle-box">

                                 <table class="table table-sm detalle-table">

                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>CONCEPTOS CAJA</th>
                                             <th>REF</th>
                                             <th class="text-end">CANTIDAD</th>
                                             <th class="text-end">PU</th>
                                             <th class="text-end">TOTAL</th>
                                         </tr>
                                     </thead>

                                     <tbody>

                                         <?php
                                            $ii = 1;

                                            foreach ($data_otros as $otros) {

                                                $monto_otros += ($otros['cantidad'] * $otros['venta']);
                                            ?>

                                             <tr>
                                                 <td><?php echo $ii ?></td>
                                                 <td><?php echo $otros['c_articulo'] . ' || ' . $otros['nombre_pr']; ?></td>
                                                 <td><?php echo $otros['ano'] . '(' . $otros['mes_desde'] . ':' . $otros['mes_hasta'] . ')'; ?></td>
                                                 <td class="text-end"><?php echo $otros['cantidad']; ?> </td>
                                                 <td class="text-end"> <?php echo decimal(($otros['venta']), 2); ?></td>
                                                 <td class="text-end"> <?php echo decimal(($otros['venta'] * $otros['cantidad']), 2); ?></td>
                                             </tr>

                                         <?php
                                                $ii++;
                                            }
                                            ?>

                                         <tr>
                                             <td colspan="5" class="text-end">
                                                 <strong>TOTAL=><?php if ($monto_otros <> $exo['valor_venta']) {
                                                                    echo '(Dif.)' . $monto_otros - $exo['valor_venta'];
                                                                } ?></strong>
                                             </td>

                                             <td class="text-end">
                                                 <strong>
                                                     <?php echo decimal($monto_otros, 2); ?>
                                                 </strong>
                                             </td>
                                         </tr>

                                     </tbody>

                                 </table>

                             </div>
                         <?php } ?>


                     </td>

                     <td>
                         <?php if ($exo['flag'] == 'A') { ?>
                             <div style="
            margin-top:5px;
            background-color:#dc3545;
            color:white;
            padding:4px 8px;
            border-radius:5px;
            font-size:12px;
            font-weight:bold;
            display:inline-block;">
                                 ANULADO
                             </div>
                         <?php } ?>
                         <span style="color: red;"><?php echo ' ' . $exo['obs1']; ?></span>
                         <?php
                            //echo $exo['origen'].'*'.$exo['cod_documento'].'*'.$exo['num_documento'].'*'.$c_persona;
                            if (count($data) > 0) { ?>
                             <div class="detalle-box">

                                 <table class="table table-sm detalle-table">

                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>COTIZACION</th>
                                             <th class="text-end">MONTO</th>
                                         </tr>
                                     </thead>

                                     <tbody>

                                         <?php
                                            $ii = 1;

                                            foreach ($data as $d) {

                                                $monto += ($d['monto'] * -1);
                                            ?>

                                             <tr>
                                                 <td><?php echo $ii ?></td>
                                                 <td><?php echo $d['num_documento'] ?></td>
                                                 <td class="text-end">
                                                     <?php echo decimal(($d['monto'] * -1), 2); ?>
                                                 </td>
                                             </tr>

                                         <?php
                                                $ii++;
                                            }
                                            ?>

                                         <tr>
                                             <td colspan="2" class="text-end">
                                                 <strong>TOTAL=><?php if (decimal($monto, 2) <> decimal($exo['valor_venta'], 2)) {
                                                                    echo '(Dif.)' . decimal($monto, 2) - decimal($exo['valor_venta'], 2);
                                                                } ?></strong>
                                             </td>

                                             <td class="text-end">
                                                 <strong>
                                                     <?php echo decimal($monto, 2); ?>
                                                 </strong>
                                             </td>
                                         </tr>

                                     </tbody>

                                 </table>

                             </div>
                         <?php } ?>

                     </td>

                 </tr>

             <?php
                    $i++;
                }
                ?>

         </tbody>

     </table>

 </div>