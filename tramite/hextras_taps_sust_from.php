<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_tram_actividad_sustento_detalle.php");

$bo_activetalle= new bo_tram_actividad_sustento_detalle();

$ent_actividad_det= new tram_actividad_sustento_detalle();

//$opc=s_crypt($_REQUEST["opc"],'out');
$cc_sustento=s_crypt($_REQUEST["cc_sustento"],'out');



$ent_actividad_det->setCc_sustento($cc_sustento);
$data_deta=$bo_activetalle->ListarIdActividad($ent_actividad_det);

?>
<div class="row">
    <div class="col-12">
        <?php if(count($data_deta)>0){ ?>
            <table class="table table-striped-columns">
              <thead class="table-light">
                <tr>
                    <th class="col-1">#</th>
                    <th class="col-8">Actividad</th>
                    <th class="col-2">Desde-hasta</th>
                    <th class="col-1 text-center">Opción</th>   
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;

                foreach($data_deta as $act){
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td ><?php echo $act["obs"] ?></td>
                        <td ><?php echo $act["horaini"]."-".$act["horafin"] ?></td>
                        <td class="text-center"><a href="javascript: fn_Eliminar('<?php echo $act["cc_sustento_det"] ?>');">
                            <i class='fas fa-window-close text-danger'></i>
                        </a></td>
                    </tr>
                    <?php $i++;} ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<?php if($cc_sustento>'0'){ ?>
<form class="needs-validation" id="frmFormRegistroD" action="javascript:fn_grabarDetalleD()" method="post" novalidate>
    <div class="row d-flex align-items-end">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Actividad</span>
                    <input type="text" class="form-control" id="obsde" name="obsde" aria-describedby="Detalle" placeholder="Ingresa Actividad" maxlength="70" oninput="contar_actividad()" value="" required>
                    <small id="charCount1">0/70</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Desde(00:01)</span>
                    <input type="time" class="form-control" id="horaini" name="horaini" placeholder="hh:mm" aria-describedby="Hora fin" placeholder="1" required>

                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Hasta(23:59)</span>
                    <input type="time" class="form-control" id="horafin" name="horafin" placeholder="hh:mm" aria-describedby="Hora fin" placeholder="2" required>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12 text-center">
            
                <input type="hidden" class="form-control" name="cc_sustento" id="cc_sustento" value="<?php echo $cc_sustento ?>">
                <input type="hidden" class="form-control" name="opcd" id="opcd" value="I">
                <?php echo bt_guardar('Guardar'); ?>
          
        </div>

    </div>
</form>
<?php } ?>
<script type="text/javascript">
    $("#frmFormRegistroD").validate();
    function contar_actividad() {
      const inputField1 = document.getElementById('obsde');
      const charCountLabel = document.getElementById('charCount1');
      const currentLength1 = inputField1.value.length;
      charCountLabel.textContent = `${currentLength1}/70`;
  }
</script>