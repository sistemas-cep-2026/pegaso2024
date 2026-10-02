 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_banc_dietas.php");
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();
    $bo_banc_dietas = new bo_banc_dietas();

    $ent_banc_dietas = new banc_dietas();

    $cc_local = s_local_vinculado();
    $cod_anho = s_anho();
    $cod_mes = s_periodo();

    //    $cod_anho = '2025';
    //  $cod_mes = '12';

    $ent_banc_dietas->setCod_ano($cod_anho);
    $ent_banc_dietas->setCod_mes($cod_mes);
    $ent_banc_dietas->setCc_local($cc_local);

    $data_egresos = $bo_banc_dietas->listar_periodo($ent_banc_dietas);
    ?>
 <div class="table-responsive">
     <table class="table table-nowrap">
         <thead class='table-light'>
             <tr>
                 <th>Dieta</th>
                 <th>Fecha</th>
                 <th>Periodo</th>
                 <th>Benef.</th>
                 <th>Obs.</th>
                 <th class="text-end">Neto</th>
                 <th class="text-end">Estado</th>
                 <th class="text-end">Opciones</th>

             </tr>
         </thead>
         <tbody>
             <?php if (empty($data_egresos)): ?>
                 <tr>
                     <td colspan="8" class="text-center text-muted p-4">No hay dietas registradas para este período.</td>
                 </tr>
             <?php endif; ?>
             <?php foreach ($data_egresos as $banco) { ?>
                 <tr>
                     <td><?php echo $banco['cc_dietas'] ?></td>
                     <td><?php echo $banco['fecha'] ?></td>
                     <td><?php echo $banco['cod_ano'] . '-' . $banco['cod_mes']; ?></td>
                     <td><?php echo $banco['nombre_area'] . '-' . $banco['nombre_persona']; ?></td>
                     <td><?php echo $banco['referencia'] ?></td>
                     <td class="text-end"><?php echo 'S/. ' . decimal($banco['neto'], 2) ?></td>

                     <td class="text-end">
                         <span class="badge rounded-pill <?php echo $color_flag_cont[$banco["flag"]]; ?>"><?php echo $banco["flag_texto"]; ?>
                     </td>
                     <td class="text-center">
                         <a href="#"
                             onclick="redireccionar_ventana('<?php echo url('bancos/dietas_print?cc_dietas=' . s_crypt($banco['cc_dietas'])); ?>',750);"
                             class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Imprimir"> <i class="fas fa-print"></i>
                         </a>

                         <?php if ($banco["flag"] != 'A'): ?>
                             <a href="?id=<?php echo s_crypt('800008') ?>&cod=<?php echo s_crypt($banco['cc_dietas']) ?>&opc=<?php echo s_crypt('U') ?>"
                                 class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="tooltip" title="Modificar"> <i class="fas fa-edit"></i>
                             </a>
                         <?php endif; ?>

                         <?php if ($banco["flag"] != 'A'): ?>
                             <a href="#"
                                 onclick="fn_anularRegistroFrom('<?php echo s_crypt($banco['cc_dietas']) ?>','<?php echo s_crypt('A') ?>');"
                                 class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"><i class="fas fa-eye-slash"></i>
                             </a>
                         <?php endif; ?>
                     </td>
                     <!--<td class="text-end">
                         <div class="dropdown">
                             <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="ri-more-2-fill"></i>
                             </a>
                             <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                 <li><a class="dropdown-item" href="#" onclick="redireccionar_ventana('<?php //echo url('bancos/dietas_print?cc_dietas=' . s_crypt($banco['cc_dietas'])); 
                                                                                                        ?>',750);"><i class='fas fa-print'></i> Imprimir</a></li>
                                 <?php //if ($banco["flag"] != 'A'): 
                                    ?>
                                     <li><a class="dropdown-item" href="?id=<?php // echo s_crypt('800008') 
                                                                            ?>&cc_dietas=<?php //echo s_crypt($banco['cc_dietas']) 
                                                                                            ?>&opc=<?php // echo s_crypt('U') 
                                                                                                    ?>"><i class='fas fa-edit'></i> Modificar</a></li>
                                 <?php //endif; 
                                    ?>
                                 <?php //if ($banco["flag"] != 'A'): 
                                    ?>
                                     <li><a class="dropdown-item" href="#" onclick="fn_anularRegistroFrom('<?php //echo s_crypt($banco['cc_dietas']) 
                                                                                                            ?>','<?php //echo s_crypt('A') 
                                                                                                                    ?>');"><i class='fas fa-eye-slash'></i> Anular</a></li>
                                 <?php //endif; 
                                    ?>

                             </ul>
                         </div>
                     </td>-->
                 </tr>
             <?php } ?>
         </tbody>

     </table>
 </div>