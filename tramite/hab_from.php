<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
$disabled = '';
$c_tipo = '03';
$desde = date('Y-m-d');
$hasta = date('Y-m-d');
$numero = '';
$flag = 'T';
$flag_text = $arr_color = [
    'T' => 'PENDIENTE',
    '*' => 'PROCESADO',
    'A' => 'ANULADO',
];
$arr_color = [
    'T' => 'secondary',
    '*' => 'success',
    'A' => 'danger',
];
if (isset($_REQUEST['opc']) && s_crypt($_REQUEST['opc'], 'out') === 'U') {
    require_once(u_src() . "bo/bo_tram_documentos_internos.php");
    $bo_tram_internos = new bo_tram_documentos_internos();
    $ent_tram_internos = new tram_documentos_internos();

    $id_doc = s_crypt($_REQUEST['cod'], 'out');
    $ent_tram_internos->setId_doc($id_doc);
    $doc_emitidos = $bo_tram_internos->listarID($ent_tram_internos);
    foreach ($doc_emitidos as $cab) {
        $numero = digitos(abs($cab["numero"]), 6);
        $nombre = $cab["nombre"];
        $cod_sexo = $cab["cod_sexo"];
        $c_cmp = $cab["c_cmp"];
        $fecha = $cab["fecha"];
        $desde = $cab["desde"];
        $hasta = $cab["hasta"];
        $c_tipo = $cab["c_tipo"];
        $flag = $cab["flag"];
        $cod_codigo = $cab["cod_codigo"];
        $obs = $cab["obs"];
        $c_expediente = $cab["c_expediente"];
        $nombre_institucion = $cab["nombre_institucion"];
        $nombre = ' - ' . $cab["nombre"];
        $c_cmp = empty($cab["c_cmp"]) ? $cab["num_documento"] : $cab["c_cmp"];
    }
    $disabled = 'disabled';
}
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Emisión de Habilitaciones <?= !empty($numero) ? u_estado($numero, 'success') : ''; ?> <?= u_estado($flag_text[$flag], $arr_color[$flag]) ?></h4>
    </div>
    <div class="card-body">
        <form method="post" action="javascript:fn_grabarRegistro();" id="frmGrabarRegistro" novalidate>
            <div class="row">
                <div class="col-md-9">
                    <input type="hidden" name="c_persona" id="c_persona" value="">
                    <input type="hidden" name="c_persona_institucion" id="c_persona_institucion" value="">
                    <input type="hidden" name="c_expediente" id="c_expediente" value="">
                    <input type="hidden" name="id_doc" id="id_doc" value="<?= s_crypt($id_doc) ?>">
                    <input type="hidden" name="opc" id="opc" value="<?= s_crypt($opc) ?>">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Fecha registro</span>
                                <input type="text" class="form-control" id="fecha" name="fecha" placeholder="" value="<?= date('d/m/Y H:i:s'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Tipo Documento</span>
                                <select name="c_tipo" id="c_tipo" class="form-control form-select" required onchange="fn_cambioTipoDoc(this.value);" <?= $disabled ?>>
                                    <?php foreach ($arr_tipo_docs as $tipo_doc) { ?>
                                        <option value="<?= $tipo_doc["c_tipo_de_documento"] ?>" <?= $c_tipo === $tipo_doc["c_tipo_de_documento"] ? 'selected' : '' ?>>
                                            <?= $tipo_doc["nombre"] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">País</span>
                                <select class="form-select select2" id="cod_codigo" name="cod_codigo" required data-placeholder="A emigrar o procedente" width="100%" <?= $disabled ?>>
                                    <option value="" disabled selected>A emigrar o procedente</option>
                                    <?php foreach ($data_pais as $pais) { ?>
                                        <option value="<?= $pais['cc_pais']; ?>" <?= ($cod_codigo == $pais['cc_pais']) ? 'selected' : ''; ?>>
                                            <?= $pais['nombre']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 temporal <?= $c_tipo == '04' ? '' : 'd-none' ?>">
                        <div class="col-lg-4">
                            <input type="number" class="form-control" id="expediente" name="expediente" placeholder="N° Expediente" value="<?= $c_expediente ?>" required <?= $disabled ?>>
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="nombre_institucion" name="nombre_institucion" placeholder="Institución u Organismo" value="<?= $nombre_institucion; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder="CEP o Apellidos y nombres" value="<?= ($c_cmp ?? '') . ' ' . ($nombre ?? '') ?>" required <?= $disabled ?>>
                        </div>
                    </div>

                    <div class="row temporal <?= $c_tipo == '04' ? '' : 'd-none' ?>">
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Fecha Inicio</span>
                                <input type="date" class="form-control fechas_inicio_fin" id="fecha_visado" name="fecha_visado" placeholder="" value="<?= $desde; ?>" required <?= $disabled ?>>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Fecha Término</span>
                                <input type="date" class="form-control fechas_inicio_fin" id="fecha_entrega" name="fecha_entrega" placeholder="" value="<?= $hasta; ?>" required <?= $disabled ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Observaciones</span>
                                <input type="text" class="form-control" id="obs" name="obs" placeholder="" value="<?= $obs ?? '' ?>" <?= $disabled ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="d-grid gap-1">
                                <?php
                                if ($flag === 'T') {
                                ?>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Procesar</button>
                                    <button type="button" class="btn btn-outline-info" onclick="redireccionar_ventana('<?= url('?id=' . s_crypt('100005')) ?>')"><i class="fa fa-user"></i> Nueva Persona</button>
                                <?php
                                } else {
                                ?>
                                    <button type="button" class="btn btn-info" onclick="redireccionar_ventana('<?= url('tramite/hab_print?id_doc=' . s_crypt($id_doc) . '&firma=Y') ?>')"><i class="fa fa-print"></i> Imprimir con firma</button>
                                    <button type="button" class="btn btn-light" onclick="redireccionar_ventana('<?= url('tramite/hab_print?id_doc=' . s_crypt($id_doc) . '&firma=N') ?>')"><i class="fa fa-print"></i> Imprimir sin firma</button>
                                <?php
                                }
                                ?>
                                <button class="waves-effect btn btn-outline-danger" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                                    <i class="fa fa-times"></i> Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>