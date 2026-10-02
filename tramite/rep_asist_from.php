<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_cont_asistencia.php");

$id = s_crypt($_REQUEST["id"],'out');
$opc        = s_crypt($_REQUEST["opc"],'out');
$cc_persona = s_crypt($_REQUEST["cc_persona"],'out');


$bo_personas = new bo_gen_personas();
$bo_asistencia  = new bo_cont_asistencia();

$ent_personas=new gen_personas();
$ent_asistencia=new cont_asistencia();

$ent_personas->setC_persona($cc_persona);

if($opc==='U'){
   $data_asistencia   = $bo_asistencia->listarId($id);
   foreach ($data_asistencia as $row) {
    $id=$row['id'];
    $cc_persona=$row['cc_persona'];
    $fecha=$row['punch_time'];
    $hora=$row['hora'];
    $flag=$row['flag'];
    $horario=$row['horario'];
} 

}
?>
<div class="modal-header">
    <h4 class="modal-title">Control de asistencia</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></span></button>
</div>
<div class="modal-body">
    <form method="post" action="javascript:fn_grabarRegistro();" role="form" id="frmGrabarRegistro" novalidate>
        <div class="row pb-1">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Fecha : </span>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo  $fecha; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Hora : </span>
                    <input type="time" class="form-control" id="hora" name="hora" value="<?php echo  $hora; ?>" required>
                </div>
            </div>
        </div>
        <div class="row pb-1">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">horario : </span>
                    <input type="text" class="form-control" id="horario" name="horario" value="<?php echo  $horario; ?>" required>
                </div>
            </div>
            <div class="col-lg-6">
              <?php
              $cheked = "";
              if ($flag == "A") {
                $cheked = 'checked';
            }
            input_checkbox('Estado', 'flag', 'A', $cheked, 'flag');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <?php echo bt_guardar(); ?>
            <?php echo bt_cerrar(); ?>
            <input type="hidden" name="id" id="id" value="<?php echo s_crypt($id,'in') ?>">
            <input type="hidden" name="cc_persona" id="cc_persona" value="<?php echo s_crypt($cc_persona,'in') ?>">
            <input type="hidden" name="opc" value="<?php echo s_crypt($opc,'in');?>">
        </div>
    </div>
</form>
</div>
