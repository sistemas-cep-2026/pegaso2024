<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos = new bo_tram_documentos_recibidos();
$bo_usuarios = new bo_seg_usuarios();

$ent_doc_recibidos = new tram_documentos_recibidos();
$ent_usuario = new seg_usuarios();
$cc_local = s_local();
$sede = ($cc_local == '28') ? 'CN' : 'CR';
$data_area   = $bo_general->AreaAdministrativa($sede);
$ent_usuario->setUsuario(s_usuario());
$data_usuario_ses = $bo_usuarios->listarId($ent_usuario);
$area_usuario = '';
foreach ($data_usuario_ses as $usu) {
    $area_usuario = $usu['c_area'];
}
$data_gestion = $bo_general->listarGestionActiva();
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">REGISTRO DE DERIVACIONES</h4>
        </div>
        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center text-center">
                    <form class="needs-validation" id="frmFormRegistroDeriv" action="javascript:fn_buscarRegistroDeriv()" method="post" novalidate>
                        <div class="mb-1 row justify-content-center align-items-center">
                            <div class="col-sm-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Area:</span>
                                    <select name="c_area_adm" id="c_area_adm" class="form-control" required>
                                        <option value="">Selecciona area</option>
                                        <?php foreach ($data_area as $area): ?>
                                            <option value="<?php echo $area['cc_area_adm']; ?>" <?php echo ($area['cc_area_adm'] == $area_usuario) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($area['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Gestión:</span>
                                    <select name="gestion" id="gestion" class="form-control">
                                        <?php foreach ($data_gestion as $acc): ?>
                                            <option value="<?php echo $acc['cod']; ?>" <?php echo ($acc['cod'] == '07') ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($acc['cod']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Expediente:</span>
                                    <input type="text" class="form-control" id="c_expediente" name="c_expediente" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col-sm-3 text-start">

                                <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="card-body pt-2">
                        <div id="div_derivaciones"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable() . importTypeahead() . importToolTip();
} ?>