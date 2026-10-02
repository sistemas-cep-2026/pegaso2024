<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");

$bo_general           = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos     = new bo_tram_documentos_recibidos();
$bo_doc_recibidos_det = new bo_tram_seguimiento_documentos_recibid();

$ent_doc_recibidos     = new tram_documentos_recibidos();
$ent_doc_recibidos_det = new tram_seguimiento_documentos_recibid();

$est_estado = $bo_parametro_detalle->listarParametroDet('seguimiento_documentos_recibid',    'flag');

$est_original = $bo_parametro_detalle->listarParametroDet('seguimiento_documentos_recibid',    'cod_original');

$cc_local = s_local();
$sede = ($cc_local == '28') ? 'CN' : 'CR';

$c_area_adm = isset($_REQUEST['c_area_adm'])    ? trim($_REQUEST['c_area_adm'])    : '';
$gestion = isset($_REQUEST['gestion'])    ? (int)$_REQUEST['gestion']    : 0;
$c_expediente = isset($_REQUEST['c_expediente'])    ? (int)$_REQUEST['c_expediente']    : 0;

$seccion_req = isset($_REQUEST['seccion'])    ? trim($_REQUEST['seccion'])    : '';

$data_area   = $bo_general->AreaAdministrativa($sede);
$data_accion = $bo_general->tram_accion();

$numero =    str_pad($cc_local, 2, '0', STR_PAD_LEFT) .
    str_pad($gestion, 2, '0', STR_PAD_LEFT) .
    str_pad($c_expediente, 7, '0', STR_PAD_LEFT);

$ent_doc_recibidos->setC_local($cc_local);
$ent_doc_recibidos->setC_expediente($numero);

$data_doc = $bo_doc_recibidos->listarDerivacion($ent_doc_recibidos, $c_area_adm);

$opcd_u = s_crypt('U', 'in');


function renderDerivNode($node, $rowDoc, $nivel, $data_area, $data_accion, $est_original, $est_estado, $seccion, $editable_doc, $opcd_u, $area_filtro, $areaPadre = null)
{

    $cc_docrecibidos_det_enc = s_crypt($node['cc_docrecibidos_det'], 'in');

    $cc_docrecibidos_enc = s_crypt($rowDoc['cc_docrecibidos'], 'in');

    $opcd_insert_enc   = s_crypt('I', 'in');
    $opcd_recibir_enc  = s_crypt('DA', 'in');
    $opcd_delete_enc   = s_crypt('E', 'in');
    $opcd_atendido_enc = s_crypt('AT', 'in');

    $marginLeft = ($nivel - 1) * 18;

    $flag = trim((string)($node['flag'] ?? ''));

    $flagP = ($flag === 'P');
    $flagT = ($flag === 'T');
    $flagA = ($flag === 'A');

    $areaNodo = trim((string)($node['c_area_adm'] ?? ''));

    $areaPadre = ($areaPadre !== null) ? trim((string)$areaPadre) : null;

    $mismaArea = ($area_filtro !== '' &&  $areaNodo !== '' && $areaNodo == $area_filtro);
    $puedeEditarDerivacion = ($editable_doc &&  $flagP &&  $areaPadre !== null && $areaPadre == $area_filtro);
    $showAceptar = ($editable_doc && $flagP && $mismaArea);
    $mostrar_form_aceptado = ($editable_doc && $flagT && $mismaArea);
    $showDerivar = ($editable_doc && $flagT && $mismaArea);
    $showAtendido = ($editable_doc && $flagT &&  $mismaArea);

    $ejecucionValor = (isset($node['accion_a_tomar']) && trim((string)$node['accion_a_tomar']) !== '&') ? trim((string)$node['accion_a_tomar']) : '';

    if ($flagA) {
        $estadoBorde = 'border-success';
        $estadoBadgeClase = 'bg-success-subtle text-success border border-success-subtle';
        $estadoBadgeTexto = 'Atendido';
        $estadoIcono = 'ri-checkbox-circle-line';
    } elseif ($flagT) {
        $estadoBorde = 'border-info';
        $estadoBadgeClase = 'bg-info-subtle text-info border border-info-subtle';
        $estadoBadgeTexto = 'Recibido';
        $estadoIcono = 'ri-inbox-archive-line';
    } else {

        $estadoBorde = 'border-warning';
        $estadoBadgeClase = 'bg-warning-subtle text-warning border border-warning-subtle';
        $estadoBadgeTexto = 'Pendiente';
        $estadoIcono = 'ri-time-line';
    }

?>
    <li class="dd-item mb-2"
        data-id="<?= (int)$node['cc_docrecibidos_det'] ?>">
        <div style="margin-left: <?= $marginLeft ?>px;">
            <?php if ($puedeEditarDerivacion): ?>
                <div class="card border border-warning-subtle shadow-none mb-2">
                    <div class="card-body p-2">
                        <form class="det-form" data-opcd-u="<?= $opcd_u ?>" data-seccion="<?= $seccion ?>">
                            <input type="hidden" name="cc_docrecibidos_det" value="<?= $cc_docrecibidos_det_enc ?>">
                            <input type="hidden" name="cc_docrecibidos" value="<?= $cc_docrecibidos_enc ?>">
                            <input type="hidden" name="flag" value="<?= htmlspecialchars($flag) ?>">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label text-muted fs-12 mb-1">
                                        <i class="ri-building-line me-1"></i>
                                        Área destino
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="c_area_adm" class="form-select form-select-sm auto-save">
                                        <option value=""> Seleccionar área...
                                        </option>
                                        <?php foreach ($data_area as $area): ?>
                                            <?php
                                            $val = trim((string)$area['cc_area_adm']);
                                            $txt = $area['nombre'];
                                            if ($areaPadre !== null && $val == $areaPadre) {
                                                continue;
                                            }
                                            $sel = ($val == $areaNodo) ? 'selected' : '';
                                            ?>
                                            <option value="<?= htmlspecialchars($val) ?>" <?= $sel ?>>
                                                <?= htmlspecialchars($txt) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-12 mb-1">
                                        <i class="ri-task-line me-1"></i>
                                        Acción
                                    </label>
                                    <select name="c_accion" class="form-select form-select-sm auto-save">
                                        <option value="">
                                            Seleccionar acción...
                                        </option>
                                        <?php foreach ($data_accion as $acc): ?>
                                            <?php
                                            $val = trim((string)$acc['c_accion']);
                                            $sel = ($val == trim((string)($node['c_accion'] ?? '')))  ? 'selected'   : '';
                                            ?>
                                            <option value="<?= htmlspecialchars($val) ?>" <?= $sel ?>>
                                                <?= htmlspecialchars($acc['nombre_accion']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- ORIGINAL / COPIA -->
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-12 mb-1">
                                        <i class="ri-file-copy-line me-1"></i> Original / Copia
                                    </label>
                                    <select name="cod_original"
                                        class="form-select form-select-sm auto-save">
                                        <option value="">
                                            Seleccionar...
                                        </option>
                                        <?php
                                        $currentOriginal = trim((string)($node['cod_original'] ?? ''));
                                        foreach ($est_original as $ori):
                                            $val = trim((string)($ori['cc_codigo'] ?? ''));
                                            $txt = $ori['detalle'] ?? '';
                                            $sel = ($val === $currentOriginal)  ? 'selected' : '';
                                        ?>
                                            <option value="<?= htmlspecialchars($val) ?>" <?= $sel ?>>
                                                <?= htmlspecialchars($txt) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar derivación" onclick="fn_EliminarDeriv('<?= $cc_docrecibidos_det_enc ?>',
                                                '<?= $opcd_delete_enc ?>','<?= $seccion ?>' );">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light-subtle">
                                            <i class="ri-message-2-line"></i>
                                        </span>
                                        <input type="text" name="observacion" class="form-control auto-save" placeholder="Observación..." value="<?= htmlspecialchars($node['observacion'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="accion_a_tomar" value="<?= htmlspecialchars($ejecucionValor) ?>">
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card border-0 border-start border-3 <?= $estadoBorde ?> shadow-sm mb-2">
                    <div class="card-body py-2 px-3">
                        <div class="row align-items-center g-2">
                            <div class="col-lg-4 col-md-5">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs flex-shrink-0 me-2">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded">
                                            <i class="ri-file-text-line fs-16"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center flex-wrap gap-1">
                                            <span class="text-muted fs-12"> Área: </span>
                                            <span class="fw-semibold fs-13">
                                                <?= htmlspecialchars($node['c_area_adm_text'] ?? '') ?>
                                            </span>
                                        </div>
                                        <?php if (!empty($node['c_accion_text'])): ?>
                                            <div class="text-muted fs-12 mt-1"> <i class="ri-arrow-right-s-line"></i> <?= htmlspecialchars($node['c_accion_text']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- ENVÍA -->
                            <div class="col-lg-2 col-md-3">
                                <div class="fs-12 text-muted"> Envía </div>
                                <div class="fw-medium fs-13">
                                    <?= htmlspecialchars($node['c_usuario'] ?? '') ?>
                                </div>
                                <div class="text-muted fs-11">
                                    <?= htmlspecialchars($node['fecha_entrega_text'] ?? '') ?>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <div class="fs-12 text-muted"> Recibe </div>
                                <div class="fw-medium fs-13">
                                    <?= !empty($node['usu_recep']) ? htmlspecialchars($node['usu_recep']) : '<span class="text-muted">—</span>' ?>
                                </div>
                                <div class="text-muted fs-11">
                                    <?= htmlspecialchars($node['feha_respuesta_text'] ?? '') ?>
                                </div>
                            </div>
                            <div class="col-lg-2 d-none d-lg-block">
                                <?php if ($ejecucionValor !== ''): ?>
                                    <div class="fs-12 text-muted">
                                        Ejecución
                                    </div>
                                    <div class="fw-medium fs-12 text-truncate" title="<?= htmlspecialchars($ejecucionValor) ?>">
                                        <?= htmlspecialchars($ejecucionValor) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-2 text-end">
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-1">
                                    <span class="badge <?= $estadoBadgeClase ?>">
                                        <i class="<?= $estadoIcono ?> me-1"></i>
                                        <?= $estadoBadgeTexto ?>
                                    </span>

                                    <?php if (!empty($node['cod_original_text'])): ?>
                                        <span class="badge bg-light text-primary border">
                                            <?= htmlspecialchars($node['cod_original_text']) ?>
                                        </span>
                                    <?php endif; ?>

                                </div>
                                <div class="d-flex justify-content-end gap-1 mt-2">
                                    <?php if ($showDerivar): ?>
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Derivar" onclick="fn_agregarDeriv('<?= $cc_docrecibidos_det_enc ?>','<?= $cc_docrecibidos_enc ?>','<?= $opcd_insert_enc ?>', <?= (int)$node['cc_docrecibidos_det'] ?>, '<?= $seccion ?>');">
                                            <i class="ri-send-plane-line"> Derivar</i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($showAtendido): ?>
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como atendido" onclick="fn_marcarAtendido('<?= $cc_docrecibidos_det_enc ?>','<?= $opcd_atendido_enc ?>', '<?= $seccion ?>');">
                                            <i class="ri-checkbox-circle-line"> Atendido</i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($showAceptar): ?>

                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Recibir derivación" onclick="fn_recibirDeriv('<?= $cc_docrecibidos_det_enc ?>','<?= $cc_docrecibidos_enc ?>','<?= $opcd_recibir_enc ?>','<?= $seccion ?>' );">
                                            <i class="ri-inbox-archive-line"> Recibir</i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($node['observacion'])): ?>
                            <div class="border-top mt-2 pt-2">
                                <small class="text-muted">
                                    <i class="ri-message-2-line me-1"></i>
                                    <?= htmlspecialchars($node['observacion']) ?>
                                </small>
                            </div>
                        <?php endif; ?>
                        <?php if ($mostrar_form_aceptado): ?>
                            <div class="border-top mt-2 pt-2">
                                <form class="det-form" data-opcd-u="<?= $opcd_u ?>" data-seccion="<?= $seccion ?>">
                                    <input type="hidden" name="cc_docrecibidos_det" value="<?= $cc_docrecibidos_det_enc ?>">
                                    <input type="hidden" name="cc_docrecibidos" value="<?= $cc_docrecibidos_enc ?>">
                                    <input type="hidden" name="c_area_adm" value="<?= htmlspecialchars($areaNodo) ?>">
                                    <input type="hidden" name="c_accion" value="<?= htmlspecialchars($node['c_accion'] ?? '') ?>">
                                    <input type="hidden" name="cod_original" value="<?= htmlspecialchars($node['cod_original'] ?? '') ?>">
                                    <input type="hidden" name="observacion" value="<?= htmlspecialchars($node['observacion'] ?? '') ?>">

                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light-subtle">
                                            <i class="ri-edit-line me-1"></i>
                                            Ejecución
                                        </span>
                                        <input type="text" name="accion_a_tomar" class="form-control auto-save" placeholder="Ingrese acción realizada..." value="<?= htmlspecialchars($ejecucionValor) ?>">
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($node['children'])): ?>
            <ol class="dd-list list-unstyled mt-1">
                <?php foreach ($node['children'] as $child): ?>
                    <?php
                    renderDerivNode(
                        $child,
                        $rowDoc,
                        $nivel + 1,
                        $data_area,
                        $data_accion,
                        $est_original,
                        $est_estado,
                        $seccion,
                        $editable_doc,
                        $opcd_u,
                        $area_filtro,
                        $areaNodo
                    );
                    ?>
                <?php endforeach; ?>

            </ol>
        <?php endif; ?>
    </li>
<?php
}
?>
<?php foreach ($data_doc as $row) { ?>
    <?php
    $seccion = $row['cc_docrecibidos'];
    if ($seccion_req !== '' &&        $seccion_req != $seccion) {
        continue;
    }
    $editableDoc = ($row['flag'] == 'P');
    $text_color = $editableDoc ? "bg-info" : "bg-success";
    $ruta =        dirname(__DIR__) . "/file_tramites/" . ($row['file_adjunto'] ?? '');
    ?>
    <div id="sec_<?= $seccion ?>" class="card border shadow-sm mb-3">
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-lg-3 col-md-4 border-end">
                    <div class="d-flex align-items-start mb-3">
                        <div class="avatar-sm flex-shrink-0 me-2">
                            <span class="avatar-title bg-primary-subtle text-primary rounded">
                                <i class="ri-folder-open-line fs-18"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-16 mb-1 text-primary">
                                <?= htmlspecialchars($row['c_expediente'] ?? '') ?>
                            </h5>
                            <span class="badge <?= $text_color ?> fs-11">
                                <?= htmlspecialchars($row['flag_text'] ?? '') ?>
                            </span>
                        </div>
                    </div>
                    <div class="vstack gap-2 fs-12">
                        <div class="d-flex align-items-center">
                            <i class="ri-calendar-line text-muted me-2"></i>
                            <span class="text-muted">
                                <?= htmlspecialchars($row['fecha_documento_text'] ?? '') ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="ri-user-line text-muted me-2 mt-1"></i>
                            <span class="fw-medium">
                                <?= htmlspecialchars($row['nombre_remitente'] ?? ($row['razon_social'] ?? '')) ?>
                            </span>
                        </div>

                        <div class="d-flex align-items-start">
                            <i class="ri-file-list-3-line text-muted me-2 mt-1"></i>
                            <div>
                                <span class="text-muted"> Asunto </span>
                                <div class="fw-medium">
                                    <?= htmlspecialchars($row['asunto'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ri-user-settings-line text-muted me-2"></i>
                            <span class="text-muted me-1"> Registrado: </span>
                            <span class="fw-medium">
                                <?= htmlspecialchars($row['c_usuario'] ?? '') ?>
                            </span>
                        </div>
                    </div>
                    <?php if (!empty($row['file_adjunto']) && file_exists($ruta)): ?>
                        <a href="<?= url('file_tramites/' . rawurlencode($row['file_adjunto'])) ?>" target="_blank" class="btn btn-outline-danger btn-sm w-100 mt-3">
                            <i class="ri-file-pdf-line me-1"></i> Ver adjunto </a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-9 col-md-8">
                    <?php
                    $ent_doc_recibidos_det->setCc_docrecibidos($row['cc_docrecibidos']);
                    $data_detalle =                        $bo_doc_recibidos_det->listaIDExp($ent_doc_recibidos_det);
                    $items = [];
                    $tree = [];
                    foreach ($data_detalle as $det) {
                        $id = (int)$det['cc_docrecibidos_det'];
                        $parent = (int)($det['linea'] ?? 0);
                        $det['children'] = [];
                        $det['parent'] = $parent;
                        $items[$id] = $det;
                    }
                    foreach ($items as $id => &$node) {
                        if ($node['parent'] === 0) {
                            $tree[$id] = &$node;
                        } elseif (
                            isset($items[$node['parent']])
                        ) {
                            $items[$node['parent']]['children'][$id] = &$node;
                        } else {
                            $tree[$id] = &$node;
                        }
                    }
                    unset($node);
                    ?>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <span class="fw-semibold fs-13">
                                <i class="ri-route-line text-primary me-1"></i>
                                Trazabilidad del documento
                            </span>
                        </div>
                        <small class="text-muted">
                            <?= count($data_detalle) ?> registro(s)
                        </small>
                    </div>
                    <div class="dd" data-cc="<?= $row['cc_docrecibidos'] ?>" data-seccion="<?= $seccion ?>">
                        <ol class="dd-list list-unstyled mb-0">
                            <?php
                            if (!empty($tree)) {
                                foreach ($tree as $rootNode) {
                                    renderDerivNode(
                                        $rootNode,
                                        $row,
                                        1,
                                        $data_area,
                                        $data_accion,
                                        $est_original,
                                        $est_estado,
                                        $seccion,
                                        $editableDoc,
                                        $opcd_u,
                                        $c_area_adm,
                                        null
                                    );
                                }
                            } else {
                                echo '
                                <li>
                                    <div class="alert alert-info border-0 mb-0 py-2">
                                        <i class="ri-information-line me-1"></i>
                                        Sin derivaciones registradas
                                    </div>
                                </li>';
                            }
                            ?>
                        </ol>
                    </div>
                    <?php if (!$editableDoc): ?>
                        <div class="alert alert-warning border-0 py-2 mt-2 mb-0">
                            <i class="ri-archive-line me-1"></i>
                            <small>
                                Documento archivado - Solo lectura
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>