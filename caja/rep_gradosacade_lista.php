<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_personas_especialidad.php");
$bo_general = new bo_general();
$bo_personas = new bo_gen_personas();
$bo_personasesp = new bo_tram_personas_especialidad();
$cc_persona=s_crypt($_REQUEST['cc_persona'],'out');
$data_grado_espe=$bo_personasesp->gradoPersona($cc_persona, 'E');
$data_grado_maes=$bo_personasesp->gradoPersona($cc_persona, 'M');
$data_grado_doc=$bo_personasesp->gradoPersona($cc_persona, 'D');
$data_grado_aud=$bo_personasesp->gradoPersona($cc_persona, 'A');
///print_r($data_grado);
?>
<div class="row">
    <div class="col-xxl-4 col-sm-6">
        <div class="card profile-project-card shadow-none profile-project-success">
            <div class="card-body p-4">
                <div class="d-flex">
                    <div class="flex-grow-1 text-muted overflow-hidden">
                        <h5 class="fs-14 text-truncate">Especialidad</h5>
                    </div>
                </div>
                <?php 
                if (count($data_grado_espe)>0) {
                    foreach ($data_grado_espe as $esp) {?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><?php echo $esp['literal'] ?></h5><small><?php echo $esp['nombre'] ?></small>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <small>Fecha: <?php echo $esp['fecha'] ?></small>
                        </div>
                        <div class="col-md-4">
                            <small>N° <?php echo $esp['c_reg_esp'] ?></small>
                        </div>
                        <div class="col-md-4">
                          <small>Diplom.: <?php echo $esp['fecha_diploma'] ?></small>
                      </div>
                  </div>
                  <div class="border border-dashed my-4"></div>
              <?php }
          }else{
            echo errors("No existe Registro");
        } ?>
    </div>
</div>
</div>

<div class="col-xxl-4 col-sm-6">
    <div class="card profile-project-card shadow-none profile-project-info">
       <div class="card-body p-4">
        <div class="d-flex">
            <div class="flex-grow-1 text-muted overflow-hidden">
                <h5 class="fs-14 text-truncate">Maestría</h5>
            </div>
        </div>
        <?php 
        if (count($data_grado_maes)>0) {
            foreach ($data_grado_maes as $maes) {?>
                <div class="row">
                    <div class="col-sm-12">
                        <h5><?php echo $maes['literal'] ?></h5><small><?php echo $maes['nombre'] ?></small>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <small>Fecha: <?php echo $maes['fecha'] ?></small>
                </div>
                <div class="col-md-4">
                    <small>N° <?php echo $maes['c_reg_esp'] ?></small>
                </div>
                <div class="col-md-4">
                    <small>Diplom.:<?php echo $maes['fecha_diploma'] ?></small>
                </div>
            </div>
            <div class="border border-dashed my-4"></div>
        <?php }?>
    <?php }else{
        echo errors("No existe Registro");
    } ?>
</div>
</div>
</div>
<!--end col-->
<div class="col-xxl-4 col-sm-6">
    <div class="card profile-project-card shadow-none profile-project-primary">
        <div class="card-body p-4">
            <div class="d-flex">
                <div class="flex-grow-1 text-muted overflow-hidden">
                    <h5 class="fs-14 text-truncate">Doctorado</h5>
                </div>
            </div>
            <?php 
            if (count($data_grado_doc)>0) {
                foreach ($data_grado_doc as $doc) {?>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5><?php echo $doc['literal'] ?></h5><small><?php echo $doc['nombre'] ?></small>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <small>Fecha: <?php echo $doc['fecha'] ?></small>
                    </div>
                    <div class="col-md-4">
                        <small>N° <?php echo $doc['c_reg_esp'] ?></small>
                    </div>
                    <div class="col-md-4">
                        <small>Diplom.:<?php echo $doc['fecha_diploma'] ?></small>
                    </div>
                </div>
                <div class="border border-dashed my-4"></div>
            <?php }?>
        <?php }else{
            echo errors("No existe Registro");
        } ?>
    </div>
</div>
</div>

<div class="col-xxl-4 col-sm-6">
    <div class="card profile-project-card shadow-none profile-project-info">
       <div class="card-body p-4">
        <div class="d-flex">
            <div class="flex-grow-1 text-muted overflow-hidden">
                <h5 class="fs-14 text-truncate">Auditoría</h5>
            </div>
        </div>
        <?php 
        if (count($data_grado_aud)>0) {
            foreach ($data_grado_aud as $aud) {?>
                <div class="row">
                    <div class="col-sm-12">
                        <h5><?php echo $aud['literal'] ?></h5><small><?php echo $aud['nombre'] ?></small>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <small>Fecha: <?php echo $aud['fecha'] ?></small>
                </div>
                <div class="col-md-4">
                    <small>N° <?php echo $aud['c_reg_esp'] ?></small>
                </div>
                <div class="col-md-4">
                    <small>Diplom.:<?php echo $aud['fecha_diploma'] ?></small>
                </div>
            </div>
            <div class="border border-dashed my-4"></div>
        <?php }?>
    <?php }else{
        echo errors("No existe Registro");
    } ?>
</div>
</div>
</div>

</div>