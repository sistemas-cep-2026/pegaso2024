<div class="modal-header">
    <h4 class="modal-title"><?php echo $opc == 'U' ? $cc_tipo_text[$cc_tipo] : 'NUEVO REGISTRO'; ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form method="post" action="javascript:fn_grabarGrados();" role="form" id="frmRegistroGrados" novalidate>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="denominacion" class="form-label">Denominación</label>
                    <input type="text" class="form-control" id="denominacion" maxlength="200" name="denominacion" placeholder="Denominación" value="<?php echo $ent_estudios->getDenominacion(); ?>" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="facultad" class="form-label">Facultad</label>
                    <input type="text" class="form-control" id="facultad" name="facultad" maxlength="45" placeholder="Facultad" value="<?php echo $ent_estudios->getFacultad(); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="mb-3">
                    <input type="hidden" class="form-control" name="cc_persona" value="<?php echo s_crypt($cc_persona, 'in') ?>">
                    <input type="hidden" class="form-control" name="cc_estudios" value="<?php echo s_crypt($cc_estudios, 'in') ?>">
                    <input type="hidden" class="form-control" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                    <?php echo bt_guardar(); ?>
                    <?php echo bt_cerrar(); ?>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $("#frmRegistroGrados #cc_cap_detalle").select2({
        dropdownParent: $(`#${modalContainer}`)
    });

    $("#frmRegistroGrados").validate();

    function fn_grabarGrados() {
        swalProcesando();
        var str = $("#frmRegistroGrados").serialize();
        ajax('colegiados/aso_grados_update', str)
        .then(function(res) {
            if (res !== '0') {
                throw res;
            }
            swalOk(750);
            modalRegistro.hide();
            fn_showGrados(cc_persona);
        }).catch(function(err) {
            swalError(err);
        });
    }
</script>