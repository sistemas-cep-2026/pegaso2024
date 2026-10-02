<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_peo_ejeestrategico.php");
require_once(u_src() . "bo/bo_peo_objetivos.php");
require_once(u_src() . "bo/bo_peo_actividades.php");

$bo_ejeestra = new bo_peo_ejeestrategico();
$bo_objetivos = new bo_peo_objetivos();
$bo_actividades = new bo_peo_actividades();

$date_ejeestra = $bo_ejeestra->listar();

$anho=date('Y');
?>
<style>
    /* CSS para cambiar el color de fondo y texto al hacer clic */
    .list-group-item.active {
      background-color: bg-gradient !important;
      color: white !important;
  }
</style>
<div class="row">
  <!-- Columna 1 -->
  <div class="col-md-6">
    <div class="accordion custom-accordionwithicon" id="accordionWithicon">
        <?php
        $coneje = 1;
        foreach ($date_ejeestra as $eje) { ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="accordionwithiconExample<?php echo $coneje ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_iconExamplecollapse<?php echo $coneje ?>" aria-expanded="true" aria-controls="accor_iconExamplecollapse<?php echo $coneje ?>">
                        <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> Eje estrategico <?php echo $coneje ?></span>
                        <?php echo $eje["nombre"] ?>
                    </button>
                </h2>
                <div id="accor_iconExamplecollapse<?php echo $coneje ?>" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample<?php echo $coneje ?>" data-bs-parent="#accordionWithicon">
                    <div class="accordion-body">
                        <?php
                        $data_objet = $bo_objetivos->listarIDEje($eje["cc_ejeestrategico"]);
                        $i = 1;
                        foreach ($data_objet as $obj) { ?>
                           <div class="list-group">
                            <a href="javascript:fn_fromobjetivos('<?php echo s_crypt($obj["cc_objetivos"], 'in') ?>','<?php echo s_crypt($anho,'in') ?>');" class="list-group-item list-group-item-action" >
                                <p class="card-text">
                                    <?php echo "<strong>Objetivo " . $coneje . "." . $i . "</strong>.-" . $obj["nombre"] ?>
                                </p>
                            </a>
                        </div>
                        <?php $i++;
                    } ?>
                </div>
            </div>
        </div>
        <?php $coneje++;} ?>
        <!--
        <div class="accordion-item">
            <h2 class="accordion-header" id="accordionwithiconExample2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_iconExamplecollapse2" aria-expanded="false" aria-controls="accor_iconExamplecollapse2">
                    <i class="ri-user-location-line"></i> How Does Link Tracking Work?
                </button>
            </h2>
            <div id="accor_iconExamplecollapse2" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample2" data-bs-parent="#accordionWithicon">
                <div class="accordion-body">
                    Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien.
                </div>
            </div>
        </div>--->
    </div>

</div>
<!-- Columna 2 -->
<div class="col-md-6 ">
    <div class="row">
        <div id="divlistarbjetivosFrom"></div>
    </div>
</div>
</div>
<script>
  // JavaScript para cambiar la clase activa al hacer clic
  $('.list-group-item').click(function () {
    $('.list-group-item').removeClass('active');
    $(this).addClass('active');
});
</script>