<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");

// Badge de estado del expediente (encabezado): neutro salvo finalizado/pendiente.
if (!function_exists('exp_rep_estado_clase')) {
    function exp_rep_estado_clase($color)
    {
        $mapa = [
            'success'   => 'bg-success-subtle text-success-emphasis border border-success-subtle',
            'warning'   => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
            'secondary' => 'bg-body-secondary text-body border',
        ];
        return $mapa[$color] ?? $mapa['secondary'];
    }
}

// Trazabilidad: mismo diseño y colores que tramite/exp_deriv_lista.php (renderDerivNode), solo lectura.
if (!function_exists('exp_rep_render_traza')) {
    function exp_rep_render_traza($node)
    {
        $flag = trim((string)($node['flag'] ?? ''));

        if ($flag === 'A') {
            $estadoBorde = 'border-success';
            $estadoBadgeClase = 'bg-success-subtle text-success border border-success-subtle';
            $estadoBadgeTexto = 'Atendido';
            $estadoIcono = 'ri-checkbox-circle-line';
        } elseif ($flag === 'T') {
            $estadoBorde = 'border-info';
            $estadoBadgeClase = 'bg-info-subtle text-info border border-info-subtle';
            $estadoBadgeTexto = 'Recibido';
            $estadoIcono = 'ri-inbox-archive-line';
        } elseif ($flag === 'R') {
            $estadoBorde = 'border-secondary';
            $estadoBadgeClase = 'bg-secondary-subtle text-secondary border border-secondary-subtle';
            $estadoBadgeTexto = 'Retorna';
            $estadoIcono = 'ri-arrow-go-back-line';
        } else {
            $estadoBorde = 'border-warning';
            $estadoBadgeClase = 'bg-warning-subtle text-warning border border-warning-subtle';
            $estadoBadgeTexto = 'Pendiente';
            $estadoIcono = 'ri-time-line';
        }

        $ejecucion = (isset($node['accion_a_tomar']) && trim((string)$node['accion_a_tomar']) !== '&') ? trim((string)$node['accion_a_tomar']) : '';
?>
        <li class="dd-item mb-2">
            <div>
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
                                            <span class="fw-semibold fs-13"><?= htmlspecialchars($node['c_area_adm_text'] ?? '') ?></span>
                                        </div>
                                        <?php if (!empty($node['c_accion_text'])): ?>
                                            <div class="text-muted fs-12 mt-1"><i class="ri-arrow-right-s-line"></i> <?= htmlspecialchars($node['c_accion_text']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <div class="fs-12 text-muted"> Envía </div>
                                <div class="fw-medium fs-13"><?= htmlspecialchars($node['c_usuario'] ?? '') ?></div>
                                <div class="text-muted fs-11"><?= htmlspecialchars($node['fecha_entrega_text'] ?? '') ?></div>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <div class="fs-12 text-muted"> Recibe </div>
                                <div class="fw-medium fs-13">
                                    <?= !empty($node['usu_recep']) ? htmlspecialchars($node['usu_recep']) : '<span class="text-muted">—</span>' ?>
                                </div>
                                <div class="text-muted fs-11"><?= htmlspecialchars($node['feha_respuesta_text'] ?? '') ?></div>
                            </div>
                            <div class="col-lg-2 d-none d-lg-block">
                                <?php if ($ejecucion !== ''): ?>
                                    <div class="fs-12 text-muted"> Ejecución </div>
                                    <div class="fs-11" title="<?= htmlspecialchars($ejecucion) ?>"><?= htmlspecialchars($ejecucion) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-2 text-end">
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-1">
                                    <span class="badge <?= $estadoBadgeClase ?>"><i class="<?= $estadoIcono ?> me-1"></i><?= $estadoBadgeTexto ?></span>
                                    <?php if (!empty($node['cod_original_text'])): ?>
                                        <span class="badge bg-light text-primary border"><?= htmlspecialchars($node['cod_original_text']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($node['observacion'])): ?>
                            <div class="border-top mt-2 pt-2">
                                <small class="text-muted"><i class="ri-message-2-line me-1"></i><?= htmlspecialchars($node['observacion']) ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($node['children'])): ?>
                <ol class="dd-list list-unstyled mt-1 ms-3">
                    <?php foreach ($node['children'] as $child): ?>
                        <?php exp_rep_render_traza($child); ?>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </li>
    <?php
    }
}

$bo_doc_recibidos     = new bo_tram_documentos_recibidos();
$bo_doc_recibidos_det = new bo_tram_seguimiento_documentos_recibid();

$ent_doc_recibidos     = new tram_documentos_recibidos();
$ent_doc_recibidos_det = new tram_seguimiento_documentos_recibid();

$cc_docrecibidos = s_crypt($_REQUEST['cod'] ?? '', 'out');

$ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
$data_doc = $bo_doc_recibidos->listarId($ent_doc_recibidos);
$row = $data_doc[0] ?? null;

if (!$row) {
    ?>
    <div class="modal-header">
        <h5 class="modal-title">Expediente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
        <div class="alert alert-danger border-0 mb-0">
            <i class="ri-error-warning-line me-1"></i>
            No se encontró el expediente solicitado.
        </div>
    </div>
    <div class="modal-footer">
        <?= bt_cerrar() ?>
    </div>
<?php
    return;
}

$ent_doc_recibidos_det->setCc_docrecibidos($cc_docrecibidos);
$data_detalle = $bo_doc_recibidos_det->listaIDExp($ent_doc_recibidos_det);

usort($data_detalle, function ($a, $b) {
    return ((int)$a['cc_docrecibidos_det']) <=> ((int)$b['cc_docrecibidos_det']);
});

$estadoDocMap = [
    'P' => ['Pendiente', 'warning'],
    'T' => ['Trámite',   'secondary'],
    'A' => ['Archivado', 'success']
];
[$estadoDocTexto, $colorDoc] = $estadoDocMap[$row['flag'] ?? ''] ?? ['—', 'secondary'];
$estadoDocClase = exp_rep_estado_clase($colorDoc);

$pdf_buscados = [];
$url_pdf = u_file_buscar_pdf_expediente($row, $pdf_buscados);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <i class="ri-folder-open-line text-muted me-1"></i>
        Expediente <?= htmlspecialchars($row['c_expediente'] ?? '') ?>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
        <div class="d-flex align-items-center text-muted fs-13">
            <i class="ri-calendar-line me-1"></i>
            <?= htmlspecialchars($row['fecha_documento_text'] ?? '') ?>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php if ($url_pdf !== null): ?>
                <a href="<?= htmlspecialchars($url_pdf) ?>" target="_blank" rel="noopener"
                    class="btn btn-outline-danger btn-sm d-inline-flex align-items-center px-2 py-1"
                    title="Ver PDF adjunto" aria-label="Ver PDF adjunto del expediente">
                    <i class="ri-file-pdf-2-line fs-13 me-1"></i><span class="fs-12 fw-semibold">PDF</span>
                </a>
            <?php else: ?>
                <span class="text-muted fs-12 text-nowrap" title="Se buscó: <?= htmlspecialchars(implode(', ', $pdf_buscados)) ?>">
                    <i class="ri-attachment-2 align-middle"></i> Sin archivo
                </span>
            <?php endif; ?>
            <span class="badge <?= $estadoDocClase ?>"><?= $estadoDocTexto ?></span>
        </div>
    </div>
    <div class="row g-2 fs-13 mb-3">
        <div class="col-md-6">
            <span class="text-muted"><i class="ri-user-line me-1"></i>Remitente:</span>
            <span class="fw-medium"><?= htmlspecialchars($row['nombre_remitente'] ?? ($row['razon_social'] ?? '')) ?></span>
        </div>
        <div class="col-md-6">
            <span class="text-muted"><i class="ri-user-settings-line me-1"></i>Registrado por:</span>
            <span class="fw-medium"><?= htmlspecialchars($row['c_usuario'] ?? '') ?></span>
        </div>
        <div class="col-12">
            <span class="text-muted"><i class="ri-file-list-3-line me-1"></i>Asunto:</span>
            <span class="fw-medium"><?= htmlspecialchars($row['asunto'] ?? '') ?></span>
        </div>
        <?php if (trim((string)($row['asunto2'] ?? '')) !== ''): ?>
            <div class="col-12">
                <span class="text-muted"><i class="ri-message-2-line me-1"></i>Obs:</span>
                <span class="fw-medium"><?= htmlspecialchars($row['asunto2']) ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="fw-semibold fs-13">
            <i class="ri-route-line text-muted me-1"></i>
            Trazabilidad del documento
        </span>
        <small class="text-muted"><?= count($data_detalle) ?> registro(s)</small>
    </div>

    <?php
    $items = [];
    $tree = [];
    foreach ($data_detalle as $det) {
        $id = (int)$det['cc_docrecibidos_det'];
        $det['children'] = [];
        $det['parent'] = (int)($det['linea'] ?? 0);
        $items[$id] = $det;
    }
    foreach ($items as $id => &$node) {
        if ($node['parent'] === 0) {
            $tree[$id] = &$node;
        } elseif (isset($items[$node['parent']])) {
            $items[$node['parent']]['children'][$id] = &$node;
        } else {
            $tree[$id] = &$node;
        }
    }
    unset($node);
    ?>
    <?php if (empty($tree)): ?>
        <div class="alert alert-info border-0 mb-0 py-2">
            <i class="ri-information-line me-1"></i>
            Sin derivaciones registradas
        </div>
    <?php else: ?>
        <div class="dd">
            <ol class="dd-list list-unstyled mb-0">
                <?php foreach ($tree as $rootNode): ?>
                    <?php exp_rep_render_traza($rootNode); ?>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <?= bt_cerrar() ?>
</div>