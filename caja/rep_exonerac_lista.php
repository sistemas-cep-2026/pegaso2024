<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_personas_exoneraciones.php");
$bo_general = new bo_general();
$bo_personas = new bo_gen_personas();
$bo_personaexoner = new bo_tram_personas_exoneraciones();
$cc_persona=s_crypt($_REQUEST['cc_persona'],'out');
$data_axoneradas=$bo_personaexoner->exoneradoPersona($cc_persona);

 if (count($data_axoneradas) < 1) {
    echo "  No existen registros de exoneraciones.";

 }
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="table-light">
            <th>#</th>
            <th>TIPO</th>
            <th>PAIS</th>
            <th>FECHA</th>
            <th>SUSTENTO</th>
            <th>DESDE</th>
            <th>HASTA</th>
        </thead>
        <tbody>
            <?php 
            $i=1;
            foreach ($data_axoneradas as $exo) {?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $exo['motivo_text'] ?></td>
                    <td><?php echo $exo['pais_text'] ?></td>
                    <td><?php echo $exo['fecha'] ?></td>
                    <td><?php echo $exo['sustento'] ?></td>
                    <td><?php echo $exo['desde'] ?></td>
                    <td><?php echo $exo['hasta'] ?></td>
                </tr>
            <?php $i++;} ?>
        </tbody>
    </table>
</div>
