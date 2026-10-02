<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_seg_perfil.php");

$bo_general = new bo_general();
$bo_usuarios = new bo_seg_usuarios();
$bo_perfil = new bo_seg_perfil();

$ent_usuarios = new seg_usuarios();
$ent_perfil = new seg_perfil();

$cc_local_sesion = s_local();
$usuario_sesion = s_usuario();

$data_local = $bo_general->listarRegionesAdministrativo($cc_local_sesion, $usuario_sesion, 'A');
$ent_perfil->setFlag('A');
$data_perfil = $bo_perfil->listar($ent_perfil);

$sede = ($cc_local_sesion === '28') ? 'CN' : 'CR';
$data_area = $bo_general->AreaAdministrativa($sede);

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$usuario_original = isset($_REQUEST['usuario']) ? s_crypt($_REQUEST['usuario'], 'out') : '';

$cc_persona = '';
$nombre_persona = '';
$usuario = '';
$cc_perfil = '';
$cc_local = '';
$c_area = '';
$tp_user = '';
$tiempo_sesion = '3600';
$obs = '';
$option = "Nuevo Usuario";

if ($opc == 'U' && $usuario_original) {
    $ent_usuarios->setUsuario($usuario_original);
    $data = $bo_usuarios->listarId($ent_usuarios);
    foreach ($data as $row) {
        $cc_persona = $row['cc_persona'];
        $nombre_persona = $row['nombre'];
        $usuario = $row['usuario'];
        $cc_perfil = $row['cc_perfil'];
        $cc_local = $row['cc_local'];
        $c_area = $row['c_area'];
        $tp_user = $row['tp_user'];
        $tiempo_sesion = $row['tiempo_sesion'];
        $obs = $row['obs'];
    }
    $option = "Modificar Usuario";
} else {
    $tiempo_sesion = '3600';
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardarUsuario();" id="frmRegistroUsuario" novalidate>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <label class="form-label">Persona:</label>
                <?php if ($opc == 'U') { ?>
                    <input type="text" class="form-control" value="<?php echo $nombre_persona ?>" disabled>
                <?php } else { ?>
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <select name="tipo_persona" id="tipo_persona" class="form-control form-select">
                                <option value="C">COLEGIADO</option>
                                <option value="O">OTROS PROF.</option>
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nombre_persona" placeholder="Buscar por nombre...">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-sm-6 mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario ?>" <?php echo ($opc == 'U') ? 'disabled' : 'required' ?>>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="cc_perfil" class="form-label">Perfil:</label>
                <select class="form-control" id="cc_perfil" name="cc_perfil" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($data_perfil as $perf) { ?>
                        <option value="<?php echo $perf['cc_perfil'] ?>" <?= ($perf['cc_perfil'] == $cc_perfil) ? 'selected' : '' ?>>
                            <?php echo $perf['ct_perfil'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-6 mb-3">
                <label for="cc_local" class="form-label">Consejo regional:</label>
                <select class="form-control" id="cc_local" name="cc_local" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($data_local as $loc) { ?>
                        <option value="<?php echo $loc['c_local'] ?>" <?= ($loc['c_local'] == $cc_local) ? 'selected' : '' ?>>
                            <?php echo $loc['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6 mb-3">
                <label for="tp_user" class="form-label">Tipo de usuario:</label>
                <input type="text" class="form-control" id="tp_user" name="tp_user" value="<?php echo $tp_user ?>" maxlength="2" placeholder="Ej. A">
            </div>
            <div class="col-sm-6 mb-3">
                <label for="c_area" class="form-label">Área:</label>
                <select class="form-control" id="c_area" name="c_area">
                    <option value="">Seleccione...</option>
                    <?php foreach ($data_area as $ar) { ?>
                        <option value="<?php echo $ar['cc_area_adm'] ?>" <?= ($ar['cc_area_adm'] == $c_area) ? 'selected' : '' ?>>
                            <?php echo $ar['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <?php if ($opc != 'U') { ?>
                <div class="col-sm-6 mb-3">
                    <label for="clave" class="form-label">Clave:</label>
                    <input type="text" class="form-control" id="clave" name="clave" value="<?php echo generarContrasenaSegura(9) ?>" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="tiempo_sesion" class="form-label">Tiempo de sesión (seg.):</label>
                    <input type="text" class="form-control" id="tiempo_sesion" name="tiempo_sesion" value="<?php echo $tiempo_sesion ?>">
                </div>
            <?php } ?>

            <div class="col-sm-12 mb-3">
                <label for="obs" class="form-label">Observación:</label>
                <textarea class="form-control" id="obs" name="obs" rows="2"><?php echo $obs ?></textarea>
            </div>

            <div class="col-sm-12 text-center">
                <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                <input type="hidden" name="cc_persona" id="cc_persona" value="<?php echo s_crypt($cc_persona, 'in') ?>">
                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                <?php if ($opc == 'U') { ?>
                    <input type="hidden" name="usuario" value="<?php echo s_crypt($usuario, 'in') ?>">
                <?php } ?>
            </div>
        </div>
    </form>
</div>
<?php if ($opc != 'U') { ?>
    <script>
        var dataSetColegiados = newBloodhound({
            url: 'comun/json_colegiado'
        });
        var dataSetEmpresas = newBloodhound({
            url: 'comun/json_personasotros'
        });

        $("#nombre_persona").typeahead(typeaheadOptions, {
            name: 'nombres',
            display: 'nombres',
            limit: 15,
            templates: templates,
            source: function(query, sync, async) {
                let tipo = $('#tipo_persona').val();
                if (tipo === "C") {
                    dataSetColegiados.search(query, sync, async);
                } else {
                    dataSetEmpresas.search(query, sync, async);
                }
            }
        }).bind("typeahead:selected", function(_, datum) {
            $("#cc_persona").val(datum.c_persona);
        });
    </script>
<?php } ?>
<script>
    function fn_guardarUsuario() {
        if (!$("#cc_persona").val()) {
            swalError("Selecciona una persona de la lista.");
            return;
        }
        swalProcesando();
        var str = $("#frmRegistroUsuario").serialize();
        ajax('seguridad/usu_update', str)
            .then(function(res) {
                if (res != '0') {
                    throw res;
                }
                swalOk(750);
                modalRegistro.hide();
                fn_buscarUsuarios();
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>
