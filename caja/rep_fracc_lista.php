 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_prestamos_socios.php");
    require_once(u_src() . "bo/bo_general.php");
    require_once(u_src() . "bo/bo_gen_personas.php");

    $bo_personas = new bo_gen_personas();

    $ent_personas = new gen_personas();
    $bo_general = new bo_general();
    $bo = new bo_prestamos_socios();
    $ent = new prestamos_socios();


$c_persona = s_crypt($_REQUEST['cc_persona'], 'out');
  
    $ent->setC_persona($c_persona);
    $data = $bo->ListarPersona($ent);
 if (count($data) < 1) {
    echo "  No existen registros de fraccionamiento.";

 }
 
    ?>


 <table class="table table-nowrap">
     <thead class='table-light'>
         <tr>
             <th>N°</th>
             <th>ID</th>
             <th>Fecha</th>
             <th>CR</th>
             <th>Usuario</th>
             <th class="text-end">Deuda</th>
             <th class="text-end">Cuotas</th>
             <th class="text-end">Cuota</th>
             <th class="text-center">Estado</th>
             <th class="text-center">OPC</th>
         </tr>
     </thead>
     <tbody>
         <?php $n = 0;
            foreach ($data as $row) {
                $n++;
            ?>
             <tr>
                 <td><?php echo $n; ?></td>
                 <td><?php echo $row['cc_fraccionamiento'] . ' (' . $row['c_ano'] . '-' . $row['numero'] . ')'; ?></td>
                 <td><?php echo $row['fecha_texto'] ?></td>
                 <td><?php echo $row['c_local'] ?></td>
                 <td ><?php echo $row['c_usuario'] ?></td>
                 <td class="text-end"><?php echo  decimal($row['capital'], 2); ?></td>
                 <td class="text-end"><?php echo $row['num_cuotas'] ?></td>
                 <td class="text-end"><?php echo  decimal($row['valor_cuota'], 2); ?></td>
          
                 <td class="text-center">
                        <?php
                        echo u_estado($row["flag_text"], $color_flag_listar[$row['flag']]);
                        ?>

                    </td>
                  <td  class="text-center"><a href="#" onclick="redireccionar_ventana('<?php echo url('caja/fracc_print?cc_fraccionamiento=' . s_crypt($row['cc_fraccionamiento'])); ?>', 750);" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                            <i class="fas fa-print"></i>
                        </a>
                       
                    </td>
             </tr>
         <?php } ?>
     </tbody>
      
 </table>
 </div>