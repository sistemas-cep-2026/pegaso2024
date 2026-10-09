<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_cap_eventos.php");
$bo_general = new bo_general();
$bo_det = new bo_gen_parametro_det();
$bo_eventos = new bo_cap_eventos();

$ent_eventos = new cap_eventos();
$cc_local = s_local();
$usuario = s_usuario();
$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');


$opc = s_crypt($_REQUEST['opc'], 'out');
$cc_evento = !empty($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : null;

$data_tipo = $bo_det->listarParametroDet('cap_eventos', 'tipo');
$ent_eventos->setPrint_documento('https://www.cep.org.pe/portaldelcolegiado/public/course.php');
$option = "NUEVO EVENTO";
if ($opc == 'U') {
    $ent_eventos->setCc_evento($cc_evento);
    $dat_ac = $bo_eventos->listarID($ent_eventos);
    foreach ($dat_ac as $row) {
        $ent_eventos->setNombre($row['nombre']);
        $ent_eventos->setCc_local($row['cc_local']);
        $ent_eventos->setTipo($row['tipo']);
        $ent_eventos->setFecha_ini($row['fecha_inicio']);
        $ent_eventos->setFecha_fin($row['fecha_fin']);
        $ent_eventos->setImg_asistente($row['img_asistente']);
        $ent_eventos->setImg_ponente($row['img_ponente']);
        $ent_eventos->setFecha_evento_text($row['fecha_evento_text']);
        $ent_eventos->setDetalle($row['detalle']);
        $ent_eventos->setDetalle_ponente($row['detalle_ponente']);
        $ent_eventos->setPrint_documento($row['print_documento']);
        $ent_eventos->setText_documento($row['text_documento']);
        $ent_eventos->setPrint_documento($row['print_documento']);
        $ent_eventos->setFlag($row['flag']);
        $img_asistente = $row['img_asistente'];
        $img_ponente = $row['img_ponente'];
    }
    $option = "MODIFICAR EVENTO";
}
?>
<div class="row">
    <div class="col-xl-7">
        <div class="card card-height-100">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title flex-grow-1 mb-0"><?= $option ?></h4>
            </div><!-- end cardheader -->
            <div class="card-body">
                <div class="col-xxl-12">
                    <form action="javascript:fn_guardarEvento();" id="frmRegistroEvento" novalidate>
                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="mb-3">
                                            <label for="tipo" class="form-label">Tipo de Evento</label>
                                            <select name="tipo" id="tipo" class="form-select" required>
                                                <option value="">Selecciona</option>
                                                <?php foreach ($data_tipo as $tp) {
                                                    $tipotext = $ent_eventos->getTipo() === $tp['cc_codigo'] ? 'selected' : ''; ?>
                                                    <option value="<?= $tp['cc_codigo']; ?>" <?= $tipotext; ?>><?= $tp['detalle']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="mb-3">
                                            <label for="cc_local" class="form-label">Organiza</label>
                                            <select class="form-control" id="cc_local" name="cc_local">
                                                <option value="">Selecciona...</option>
                                                <?php foreach ($data_local as $loc): ?>
                                                    <option value="<?= $loc['c_local'] ?>" <?= $loc['c_local'] == s_local() ? 'selected' : '' ?>>
                                                        <?= $loc['nombre'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre del evento</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $ent_eventos->getNombre(); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="fecha_ini" class="form-label">Fecha inicio</label>
                                            <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" value="<?php echo $ent_eventos->getFecha_ini(); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="fecha_fin" class="form-label">Fecha final</label>
                                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo $ent_eventos->getFecha_fin() ?: ''; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="mb-3">
                                            <label for="fecha_evento_text" class="form-label">Fecha diploma: </label>
                                            <input type="text" class="form-control" name="fecha_evento_text" id="fecha_evento_text" value="<?php echo $ent_eventos->getFecha_evento_text() ?: ''; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="mb-3">
                                            <label for="print_documento" class="form-label">Plantilla : https://www.cep.org.pe/portaldelcolegiado/public/course.php </label>
                                            <input type="text" class="form-control" name="print_documento" id="print_documento" value="<?php echo $ent_eventos->getPrint_documento() ?: ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-11">
                                        <div class="mb-3">
                                            <label for="detalle_ponente" class="form-label">Texto cuerpo ponente </label>
                                            <textarea class="form-control ckeditor-classic" name="detalle_ponente" id="detalle_ponente" rows="2" required><?php echo $ent_eventos->getDetalle_ponente() ?: ''; ?></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-3 d-block">
                                            <label for="detalle" class="form-label">Texto cuerpo asistente : </label>
                                            <textarea class="form-control ckeditor-classic" name="detalle" id="detalle" rows="3" required><?php echo htmlspecialchars($ent_eventos->getDetalle() ?: '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <?php if ($ent_eventos->getFlag() === 'PU') { ?>
                                            <div class="alert alert-danger material-shadow" role="alert">
                                                <strong> Ojo! </strong> Este evento ya ha sido publicado en la página web y en el Portal del Colegiado.
                                            </div>
                                        <?php } ?>
                                        <?php echo bt_guardar(); ?> <?php echo bt_volver(); ?>
                                        <input type="hidden" name="cc_evento" id="cc_evento" value="<?php echo s_crypt($cc_evento) ?>">
                                        <input type="hidden" name="opc" id="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 py-1">Modelo certificado</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="card" id="card-block" style="zoom: 1;">
                    <?php if ($opc == 'U') {
                        include 'eve_from_diploma.php';
                    } ?>
                </div>
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->