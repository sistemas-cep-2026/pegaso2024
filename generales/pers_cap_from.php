<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_general = new bo_general();
$bo_personas = new bo_gen_personas();

$ent_personas = new gen_personas();

$c_persona = s_crypt($_REQUEST["c_persona"], 'out');
$opc = s_crypt($_REQUEST["opc"], 'out');

$option = "NUEVO REGISTRO DE PERSONA";
$bloquero = '';
if ($opc == 'U') {

    $ent_personas->setC_persona($c_persona);
    $data_persona = $bo_personas->listarID($ent_personas);
    foreach ($data_persona as $per) {
        $ent_personas->setC_persona($per['c_persona']);
        $ent_personas->setGrado($per['grado']);
        $ent_personas->setC_cmp($per['c_cmp']);
        $ent_personas->setNum_documento($per['num_documento']);
        $ent_personas->setNombre($per['nombre_completo']);
    }
    $option = "MODIFICAR REGISTRO DE PERSONA";
    $bloquero = ((int)$ent_personas->getC_cmp() > 0) ? 'readonly' : '';
}
?>

<div class="modal-header">
    <h4 class="modal-title"><?= $option ?></h4>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"> </button>
</div>
<div class="modal-body">

    <form method="post" action="javascript:fn_guardarRegistro();" id="frmFormRegistro" novalidate>
        <div class="row">
            <div class="col-md-3 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Grado: </span>
                    <input type="text" class="form-control" placeholder="Grado" name="grado" id="grado" value="<?= $ent_personas->getGrado(); ?>">
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Nombre: </span>
                    <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" value="<?= $ent_personas->getNombre(); ?>" <?= $bloquero ?>>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">CEP: </span>
                    <input type="text" class="form-control" placeholder="CEP" name="c_cmp" id="c_cmp" value="<?= $ent_personas->getC_cmp(); ?>" readonly>
                </div>
            </div>

            <div class="col-md-5 col-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">DNI: </span>
                    <input type="text" class="form-control" placeholder="DNI" name="num_documento" id="num_documento" value="<?= $ent_personas->getNum_documento(); ?>"
                        <?= $bloquero ?>>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="mb-3">
                    <input type="hidden" name="c_persona" value="<?php echo s_crypt($c_persona, 'in'); ?>">
                    <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in'); ?>">
                    <?php echo bt_guardar(); ?>
                    <?php echo bt_cerrar(); ?>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    (function($) {
        $("#frmFormRegistro").validate();
    })(jQuery);
</script>