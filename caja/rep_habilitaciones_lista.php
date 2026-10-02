<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
 
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_personas_habilitaciones.php");
$bo_general = new bo_general();
 
$bo_personas_habilitaciones = new bo_personas_habilitaciones();
$cc_persona=s_crypt($_REQUEST['cc_persona'],'out');
$data_axoneradas=$bo_personas_habilitaciones->listarID($cc_persona);

 if (count($data_axoneradas) < 1) {
    echo "  No existen registros de Habilitaciones.";

 }
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="table-light">
            <th>#</th>
            <th>CC</th>
            <th>CR</th>
            <th>NUM</th>
            <th>F.DOCUMENTO</th>
            <th>F.VENCIMIENTO</th>
            <th>ESTADO</th>
              <th></th>
        </thead>
        <tbody>
            <?php 
            $i=1;
            foreach ($data_axoneradas as $exo) {?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $exo['cc_habilitacion'] ?></td>
                    <td><?php echo $exo['cc_local'] ?></td>
                    <td><?php echo $exo['numero'] ?></td>
                    <td><?php echo $exo['fecha1'] ?></td>
                    <td><?php echo $exo['caducidad'] ?></td>
                    <td><?php echo $exo['flag'] ?></td>
                    <td  class="text-center"><a href="#" onclick="redireccionar_ventana_hab('<?php echo url('caja/hab_print?cc=' . s_crypt($row['cc_habilitacion'])); ?>', 750);" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                            <i class="fas fa-print"></i>
                        </a>
                       
                    </td>
                </tr>
            <?php $i++;} ?>
        </tbody>
    </table>
</div>
