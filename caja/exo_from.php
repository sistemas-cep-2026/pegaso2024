<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_gen_personas_exoneraciones.php");

$bo_personas_especialidad = new bo_gen_personas_exoneraciones();
$bo_det = new bo_gen_parametro_det();
$bo_personas = new bo_gen_personas();
$bo_general = new bo_general();

$ent_personas_exo = new gen_personas_exoneraciones();
$ent_personas = new gen_personas();

//$cc_persona = s_crypt($_REQUEST['cc_persona'], 'out');
//$opc = $_REQUEST['opc'] ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_persona = $_REQUEST['cc_persona'];
$opc = $_REQUEST['opc'] ? $_REQUEST['opc'] : 'I';

$data_pais = $bo_general->listarPais();
$data_motivo_exo = $bo_det->listarParametroDet('personas_exoneraciones', 'motivo');

$ent_personas->setC_persona($cc_persona);
$data_per = $bo_personas->listarID($ent_personas);

foreach ($data_per as $row) {
    $nombres = $row['nombre_completo'];
    $cep = $row['c_cmp'];
    $num_documento = $row['num_documento'];
    $cod_documento = $row['cod_documento'];
}

?>
<div class="modal-header">
    <h2 class="modal-title">Nueva Exoneración  <br>[<?= $cep; ?> - <?= $nombres; ?>]<br><small><?= $cod_documento; ?>: <?= $num_documento; ?></small></h2>
    
</div>

<div class="modal-body">
    <form class="needs-validation" id="frmFormRegistroExoneracion" action="javascript:fn_guardarRegistroExoneracion()" method="post" novalidate>
        <input type="hidden" class="form-control" name="c_persona" id="c_persona" value="<?= s_crypt($cc_persona); ?>">
        <input type="hidden" class="form-control" name="opc" id="opc" value="<?= s_crypt($opc); ?>">
        <div class="row">
        <div class="col-md-12 p-2">
                <div class="row">
                   <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Motivo:</span>
                            <select name="motivo" id="motivo" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php
                                foreach ($data_motivo_exo as $motivo_exo) {
                                ?>
                                    <option value="<?= $motivo_exo['cc_codigo']; ?>"><?= $motivo_exo['detalle']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">País:</span>
                            <select class="form-select select2" id="pais" name="pais" required data-placeholder="Seleccione..." width="100%">
                                <option value="">Seleccione...</option>
                                <?php foreach ($data_pais as $pais) { ?>
                                    <option value="<?= $pais['cc_pais']; ?>">
                                        <?= $pais['nombre']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                        <div class="input-group mb-6">
                            <span class="input-group-text">Sustento:</span>
                            <input type="text" class="form-control" id="sustento" name="sustento" placeholder="Sustento de la exoneración" spellcheck="true" placeholder="Sustento" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Salida:</span>
                            <input type="month" class="form-control" id="desde" name="desde" value="<?= date('Y-m') ?>" placeholder="Salida" required>
                        </div>
                    </div>
         
                    <div class="col-lg-6 pt-2 d-flex flex-row-reverse">
                        <div class="form-check form-switch form-switch-md form-check-inline" dir="dtr">
                            <label class="form-check-label">Sin retorno</label>
                            <input class="form-check-input" type="checkbox" role="switch" name="sin_retorno" id="sin_retorno" value="*" aria-invalid="false" checked onchange="fn_sinRetorno($(this));">
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Retorno:</span>
                            <input type="month" class="form-control" id="hasta" name="hasta" value="<?= date('Y-m') ?>" placeholder="Retorno" required disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           <div class="row">
        <div class="col-sm-12 text-center">
                <?= bt_guardar('Procesar registro'); ?>
                <?= bt_cerrar(); ?>
            </div>
        </div>
    </form>
</div>
<script>
    var validateFormExo = $('#frmFormRegistroExoneracion').validate();

    $('select.form-select.select2').select2({
        width: 'resolve',
        dropdownAutoWidth: true,
        dropdownParent: $(`#${modalContainerXl}`),
        placeholder: $(this).data('placeholder'),
        language: {
            noResults: function() {
                return "No hay resultados";
            }
        }
    });

    $('select.form-select.select2').on('select2:select', function(e) {
        validateFormExo.form();
    });

    function fn_sinRetorno(el) {
        var $this = el;
        return $('#hasta').prop('disabled', ($this.is(':checked')));
    }

    function fn_guardarRegistroExoneracion() {
        swalProcesando();
        var str = $("#frmFormRegistroExoneracion").serialize();
        ajax('caja/exo_update', str).then(function(res) {
            if (res != '0') {
                throw res;
            }
            swalOk(750);
            modalRegistro.hide();
            fn_buscarRegistro();
        }).catch(function(err) {
            swalError(err);
        });
    }
</script>