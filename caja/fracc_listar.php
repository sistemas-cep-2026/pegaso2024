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


    $c_persona = s_crypt($_REQUEST["c_persona"], 'out');
    $cc_local = s_local();
    $ent->setC_persona($c_persona);
    $data = $bo->ListarPersona($ent);

    $data_persona = $bo_personas->listarShowID($c_persona);
    foreach ($data_persona as $per) {
        $cod_documento = $per["cod_documento"];
        $num_documento = $per["num_documento"];
        $nombre = $per["nombre_completo"];
        $cep = $per["c_cmp"];
        $habil = $per["flag_habil"];
        $habil_text = $per["flag_habil_text"];
        $correo = $per["Email1"];
        $celular = $per["celular1"];
        $fecha_colegiacion = $per["fecha_colegiacion"];
        $fecha_nacimiento = $per["fecha_nacimiento"];
        $ent_pagadora = $per["ent_pagadora"];
        $estado = $per["flag_activo_text"];
        $c_local_texto = $per["c_local_text"];
        $edad = $per["edad"];
        $edad_meses = $per["edad_meses"];
        $abono_favor = $per["abono_favor"];
        $cc_persona = $per["c_persona"];
    }
    $foto = buscarFoto($num_documento);
    ?>
 <!-- warning Alert -->
 <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
     <i class="ri-error-warning-line label-icon"></i><strong><?php echo $c_persona; ?> OJO</strong> - Fraccionamiento activo permite la habilidad

 </div>
 <div class="table-responsive">

     <div class="col-md-11">
         <div class="row p-0 ">
             <div class="col-md-5">
                 <ul class="list-group list-group-flush small-list">
                     <li class="list-group-item py-1 border-0"><i class="ri-file-list-line"></i> CEP : <strong class="fs-5"><?php echo $cep ?></strong></li>
                     <li class="list-group-item py-1 border-0"><i class="ri-file-list-line"></i> DOC : <strong><?php echo $cod_documento . " : " . $num_documento ?></strong></li>
                     <li class="list-group-item py-1 border-0"><i class="ri-user-line"></i> Nombre : <strong class="fs-5"><?php echo $nombre ?></strong> </li>
                     <li class="list-group-item py-1 border-0"><i class="ri-award-line"></i> Correo : <strong><?php echo $correo ?></strong></li>
                     <li class="list-group-item py-1 border-0"><i class="ri-phone-line"></i> Celular : <strong><?php echo $celular ?></strong></li>
                 </ul>
             </div>
             <div class="col-md-5">
                 <ul class="list-group list-group-flush small-list">
                     <li class="list-group-item py-1 border-0"><strong><?php echo $c_local_texto ?> </strong></li>
                     <li class="list-group-item py-1 border-0">FECHA RESOL : <strong><?php echo $fecha_colegiacion ?></strong> </li>
                     <li class="list-group-item py-1 border-0">ENTIDAD : <strong><?php echo $ent_pagadora ?></strong></li>
                     <li class="list-group-item py-1 border-0">ESTADO : <strong class="fs-6 <?php echo ($habil == 'H') ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $habil_text . " => " . $abono_favor . " [ " . $estado . " ]"  ?></strong></li>
                     <li class="list-group-item py-1 border-0">FECHA NAC. : <strong><?php echo $fecha_nacimiento . " [ " . $edad . "A " . $edad_meses . "M ]" ?></strong> ID: <?php echo $cc_persona; ?></li>
                      
                 </ul>
             </div>
             <div class="col-md-2">
                 <ul class="list-group list-group-flush small-list">
                     <img src="<?php echo $foto ?>" alt="" class="avatar-lg img-thumbnail shadow">
                     <span class="contact-active position-absolute rounded-circle bg-success"><span class="visually-hidden"></span>
                     </span>
                      
                     <button type="button" class="btn btn-outline-success waves-effect waves-light shadow-none" onclick="fn_fracc_from('<?= $cc_persona ?>','<?= $abono_favor ?>')">
                        Fraccionar Deuda 
                     </button>
           
             </div>
         </div>
     </div>
 </div>

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
                        <?php if ($row['flag'] == '&' or  $row['flag'] == '*'): ?>
                            <!--<a href="#" onclick="fn_Eliminar('<?php echo s_crypt($row['cc_fraccionamiento']) ?>','<?php echo s_crypt('A') ?>');" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"> <i class='fas fa-trash'></i></a>-->
                            <a href="#" onclick="fn_Eliminar('<?php echo $row['cc_fraccionamiento'] ?>','A');" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"> <i class='fas fa-trash'></i></a>
                        <?php endif; ?>
                    </td>
             </tr>
         <?php } ?>
     </tbody>
     <tfoot>
         <tr>
             <td class="text-center" colspan='2'>
                 
             </td>
         </tr>
     </tfoot>
 </table>
 </div>