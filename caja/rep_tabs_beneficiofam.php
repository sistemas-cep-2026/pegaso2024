 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();

    require_once(u_src() . "bo/bo_general.php");
    require_once(u_src() . "bo/bo_banc_beneficiofam.php");


    $bo_general = new bo_general();
    $bo = new bo_banc_beneficiofam();

    $ent = new banc_beneficiofam();



    $c_persona = s_crypt($_REQUEST['cc_persona'], 'out');

    $ent->setCc_persona($c_persona);
    $data = $bo->listar_id($ent);
    if (count($data) < 1) {
        echo "  No existen Beneficios del Fam Registrados.";
    }

    ?>


 <table class="table table-nowrap">
     <thead class='table-light'>
         <tr>
             <th>N°</th>
             <th>ID</th>
             <th>FECHA</th>
             <th>CR</th>
             <th>USUARIO</th>
             <th class="text-end">MONTO</th>

             <th>CONCEPTO</th>
             <th>REF.</th>
             <th>BANCO</th>


         </tr>
     </thead>
     <tbody>
         <?php $n = 0;
            foreach ($data as $row) {
                $n++;
            ?>
             <tr>
                 <td><?php echo $n; ?></td>
                 <td><?php echo $row['cc_beneficiofam']; ?></td>
                 <td><?php echo $row['fecha'] ?></td>
                 <td><?php echo $row['cc_local'] ?></td>
                 <td><?php echo $row['user_crea'] ?></td>
                 <td class="text-end"><?php echo  decimal($row['monto'], 2); ?></td>
                 <td><?php echo $row['cod_tipo_text'] ?></td>
                 <td><?php echo $row['referencia'] ?></td>
                 <td><?php echo $row['c_banco'] . ' | ' . $row['operacion'] . ' | ' . $row['fecha_operacion'] . ' | '; ?></td>


                  
             </tr>
         <?php } ?>
     </tbody>

 </table>
 </div>