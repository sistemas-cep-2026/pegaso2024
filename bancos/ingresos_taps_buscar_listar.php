 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();
    $bo_bancos_comp = new bo_banc_comprobantes_de_caja();

    $ent_bancos_comp = new banc_comprobantes_de_caja();

    $cc_local = s_local_vinculado();
    $cod_anho = s_anho();
    $cod_mes = s_periodo();

    $ent_bancos_comp->setCod_ano($cod_anho);
    $ent_bancos_comp->setCod_mes($cod_mes);
    $ent_bancos_comp->setC_local($cc_local);

    $ent_bancos_comp->setC_banco(substr($_REQUEST['c_banco'], 0, 6));
    $ent_bancos_comp->setC_cta_corriente(substr($_REQUEST['c_banco'], 7, 35));

    $ent_bancos_comp->setNum_boleta_cheque($_REQUEST['num_boleta_cheque']);
    $ent_bancos_comp->setMonto($_REQUEST['monto']);
    $ent_bancos_comp->setObservacion($_REQUEST['observacion']);


    $ent_bancos_comp->setCod_ingreso_egreso('I');
    $data_egresos = $bo_bancos_comp->listaEgresos($ent_bancos_comp);
    ?>
 <div class="table-responsive">
     <table class="table table-nowrap">
         <thead class='table-light'>
             <tr>
               <th>N°</th>    
             <th>Comprobante</th>

                 <th>fecha</th>
                 <th>Benef.</th>
                 <th>Obs.</th>
                 <th>Entidad</th>
                 <th>Tipo</th>
                 <th>N° Ref.</th>
                 <th class="text-end">Monto</th>
                 <th class="text-center">Estado</th>
                 <th class="text-center">Cont.</th>
                 <th class="text-end">Opciones</th>

             </tr>
         </thead>
         <tbody>
             <?php foreach ($data_egresos as $banco) {
                $n++; ?>
                 <tr>
                     <td><?php echo $n; ?></td>
                     <td><?php echo digitos($banco['comprobante'], 6) ?></td>
                     <td><?php echo $banco['fecha_documento'] ?></td>
                     <td><?php echo $banco['nombre_completo'] ?></td>
                     <td><?php echo $banco['observacion'] ?></td>
                     <td><?php echo $banco['banco_text'] ?></td>
                     <td><?php echo $banco['c_forma_cancelacion'] ?></td>
                     <td><?php echo $banco['num_boleta_cheque'] ?></td>
                     <td class="text-end"><?php echo decimal($banco['monto'], 2)  ?></td>
                     <td class="text-center">
                         <span class="badge rounded-pill <?php echo $color_flag_cont[$banco["flag"]]; ?>"><?php echo $banco["flag_text"]; ?>
                     </td>
                     <td class="text-center">
                         <span class="badge rounded-pill <?php echo $color_flag_cont[$banco["flag_centralizado"]]; ?>"><?php echo $banco["flag_text_centralizado"]; ?>
                     </td>
                     <td class="text-center">
                         <a href="#"
                             onclick="redireccionar_ventana('<?php echo url('bancos/rep_bancos_print?cod=' . s_crypt($banco['cc_documento'])); ?>',750);"
                             class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Imprimir"> <i class="fas fa-print"></i>
                         </a>

                         <?php if ($banco["flag"] != 'A'): ?>
                             <a href="?id=<?php echo s_crypt('800003') ?>&cod=<?php echo s_crypt($banco['cc_documento']) ?>&opc=<?php echo s_crypt('U') ?>"
                                 class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="tooltip" title="Modificar"> <i class="fas fa-edit"></i>
                             </a>
                         <?php endif; ?>

                         <?php if ($banco["flag"] != 'A'): ?>
                             <a href="#"
                                 onclick="fn_anularRegistroFrom('<?php echo s_crypt($banco['cc_documento']) ?>','<?php echo s_crypt('A') ?>');"
                                 class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"><i class="fas fa-eye-slash"></i>
                             </a>
                         <?php endif; ?>
                     </td>
                 </tr>
             <?php } ?>
         </tbody>

     </table>
 </div>