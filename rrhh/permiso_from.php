<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_general.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_general = new bo_general();

$sede = (s_local() === '28') ? 'CN' : 'CR';
$data_tipo_permisos = $bo_parametro_detalle->listarParametroDet("tram_permisos", "tipo_permisos");
$data_area = $bo_general->AreaAdministrativa($sede);

// este formulario es exclusivamente de alta: no existe edición para tram_permisos
$opc = 'I';

$tipo_permisos = '';
$fecha = fecha_hoy();
$fecha_ida = '';
$fecha_retorno = '';
$cc_area_adm = '';
$cc_usuario_e = '';
$motivo = '';
$destinos = '';
$data_usuarios = [];
$option = "NUEVA HOJA DE TRAMITE";
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardarPermiso();" id="frmRegistroPermiso" novalidate>
        <div class="row">
            <div class="col-sm-6">
                <label for="tipo_permisos" class="form-label">Tipo Permiso:</label>
                <select class="form-control" id="tipo_permisos" name="tipo_permisos" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($data_tipo_permisos as $tp) { ?>
                        <option value="<?php echo $tp['cc_codigo'] ?>" <?= ($tp['cc_codigo'] == $tipo_permisos) ? 'selected' : '' ?>>
                            <?php echo $tp['detalle'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6 ">
                <label for="tipo_permisos" class="form-label">Fecha:</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="fecha_ida" class="form-label">*Hora Salida</label>
                <div class="input-group">
                    <input type="time" class="form-control" id="fecha_ida" name="fecha_ida" value="<?php echo $fecha_ida ?>" required>
                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="fecha_retorno" class="form-label">*Hora Retorno</label>
                <div class="input-group">
                    <input type="time" class="form-control" id="fecha_retorno" name="fecha_retorno" value="<?php echo $fecha_retorno ?>" required>
                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label for="cc_area_adm" class="form-label">Área:</label>
                <select class="form-control" id="cc_area_adm" name="cc_area_adm" onchange="cargarSolicitantes()" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($data_area as $ar) { ?>
                        <option value="<?php echo $ar['cc_area_adm'] ?>" <?= ($ar['cc_area_adm'] == $cc_area_adm) ? 'selected' : '' ?>>
                            <?php echo $ar['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="cc_usuario_e" class="form-label">Solicitante:</label>
                <select class="form-control" id="cc_usuario_e" name="cc_usuario_e" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($data_usuarios as $us) { ?>
                        <option value="<?php echo $us['usuario'] ?>" <?= ($us['usuario'] == $cc_usuario_e) ? 'selected' : '' ?>>
                            <?php echo $us['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <label for="motivo" class="form-label">Motivo:</label>
                <textarea class="form-control" id="motivo" name="motivo" rows="3" maxlength="100"
                    placeholder="ESCRIBA EL MOTIVO" required><?php echo $motivo ?></textarea>
                <div class="form-text text-end" id="contador_motivo">Max. caracteres: <?php echo strlen($motivo) ?>/100</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <label for="destinos" class="form-label">Registro de Destinos:</label>
                <textarea class="form-control" id="destinos" name="destinos" rows="3"
                    placeholder="ESCRIBA LOS DESTINOS A REGISTRAR"><?php echo $destinos ?></textarea>
                <div class="form-text">
                    Especifique los destinos a ingresar delimitado por comas. Ejemplo: Destino1, Destino2, etc.<br>
                    <strong>*Formato: 24 horas.</strong>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 text-center">
                <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
            </div>
        </div>
    </form>
</div>
<script>
    $("#frmRegistroPermiso").validate();
    $("#motivo").on("input", function() {
        $("#contador_motivo").text("Max. caracteres: " + $(this).val().length + "/100");
    });

    function cargarSolicitantes() {
        var cc_area_adm = $("#cc_area_adm").val();
        if (!cc_area_adm) {
            $("#cc_usuario_e").html("<option value=''>Seleccione...</option>");
            return;
        }
        $.ajax({
            url: 'comun/json_area_usuarios.php',
            data: {
                cc_area_adm: cc_area_adm
            },
            type: 'post',
            success: function(data) {
                $("#cc_usuario_e").html(data);
            }
        });
    }

    function fn_guardarPermiso() {
        swalProcesando();
        var str = $("#frmRegistroPermiso").serialize();
        ajax('tramite/permiso_update', str)
            .then(function(res) {
                var data = JSON.parse(res);
                if (data.error) {
                    throw data.message;
                }
                swalOk(750);
                modalRegistro.hide();
                fn_listarReporte();
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>