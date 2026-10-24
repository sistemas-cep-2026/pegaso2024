<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");

// Busca el PDF adjunto del expediente (mismo criterio que tramite/exp_deriv_lista.php).
// Devuelve la URL del visor (tramite/exp_file_ver) o null si no existe. Los PDF viven fuera de la web (D:/file_tramites).
if (!function_exists('exp_deriv_buscar_pdf')) {
    function exp_deriv_buscar_pdf($row, &$buscados)
    {
        $buscados = [];
        $cc  = (int)($row['cc_docrecibidos'] ?? 0);
        $exp = preg_replace('/[^A-Za-z0-9]/', '', trim((string)($row['c_expediente'] ?? '')));

        $nombres = [];
        foreach (['documento_enviado', 'file_adjunto'] as $campo) {
            $n = trim((string)($row[$campo] ?? ''));
            if ($n !== '') {
                $nombres[] = $n;
            }
        }
        if ($exp !== '') {
            $nombres[] = 'TRAM_' . $exp . '.pdf';
        }

        $dir = null;
        try {
            $dir = u_file_carpeta('pdf', null, false);   // null si la carpeta no existe
        } catch (Throwable $e) {
            $dir = null;
        }
        if ($dir !== null) {
            $patrones = [];
            if ($cc > 0) {
                $patrones[] = $cc . '_*.pdf';
            }
            if ($exp !== '') {
                $patrones[] = 'TRAM_' . $exp . '*.pdf';
            }
            foreach ($patrones as $patron) {
                $buscados[] = $patron;
                $hallados = glob($dir . $patron);
                if ($hallados) {
                    usort($hallados, function ($a, $b) {
                        return filemtime($b) - filemtime($a);   // el más reciente primero
                    });
                    foreach ($hallados as $h) {
                        $nombres[] = basename($h);
                    }
                }
            }
        }

        foreach (array_unique($nombres) as $nombre) {
            if (strtolower(substr($nombre, -4)) !== '.pdf') {
                continue;   // valores antiguos (.doc, etc.) no se enlazan
            }
            $buscados[] = $nombre;
            try {
                if (u_file_ruta('pdf', $nombre) !== null) {
                    return u_file_url('pdf', $nombre);
                }
            } catch (Throwable $e) {
                // un nombre inválido en la BD no debe romper la vista
            }
        }
        return null;
    }
}

// Traza del documento en solo lectura: misma presentación (árbol por derivación padre -> hija) que tramite/exp_deriv_lista.php,
// pero sin botones ni formularios. Estado de cada derivación: P Pendiente, T Recibido, A Atendido, R Retorna.
if (!function_exists('exp_rep_render_traza')) {
    function exp_rep_render_traza($node, $nivel)
    {
        $marginLeft = ($nivel - 1) * 18;
        $flag = trim((string)($node['flag'] ?? ''));

        if ($flag === 'A') {
            $borde = 'border-success';
            $badgeClase = 'bg-success-subtle text-success border border-success-subtle';
            $badgeTexto = 'Atendido';
            $icono = 'ri-checkbox-circle-line';
        } elseif ($flag === 'T') {
            $borde = 'border-info';
            $badgeClase = 'bg-info-subtle text-info border border-info-subtle';
            $badgeTexto = 'Recibido';
            $icono = 'ri-inbox-archive-line';
        } elseif ($flag === 'R') {
            $borde = 'border-secondary';
            $badgeClase = 'bg-secondary-subtle text-secondary border border-secondary-subtle';
            $badgeTexto = 'Retorna';
            $icono = 'ri-arrow-go-back-line';
        } else {
            $borde = 'border-warning';
            $badgeClase = 'bg-warning-subtle text-warning border border-warning-subtle';
            $badgeTexto = 'Pendiente';
            $icono = 'ri-time-line';
        }

        $ejecucion = (isset($node['accion_a_tomar']) && trim((string)$node['accion_a_tomar']) !== '&') ? trim((string)$node['accion_a_tomar']) : '';
?>
        <li class="dd-item mb-2">
            <div style="margin-left: <?= $marginLeft ?>px;">
                <div class="card border-0 border-start border-3 <?= $borde ?> shadow-sm mb-2">
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
                                    <div class="fw-medium fs-12 text-truncate" title="<?= htmlspecialchars($ejecucion) ?>"><?= htmlspecialchars($ejecucion) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-2 text-end">
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-1">
                                    <span class="badge <?= $badgeClase ?>"><i class="<?= $icono ?> me-1"></i><?= $badgeTexto ?></span>
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
                <ol class="dd-list list-unstyled mt-1">
                    <?php foreach ($node['children'] as $child): ?>
                        <?php exp_rep_render_traza($child, $nivel + 1); ?>
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
<?php
    return;
}

$ent_doc_recibidos_det->setCc_docrecibidos($cc_docrecibidos);
$data_detalle = $bo_doc_recibidos_det->listaIDExp($ent_doc_recibidos_det);

// Orden cronológico real (la consulta no trae ORDER BY): por id autoincremental de creación.
usort($data_detalle, function ($a, $b) {
    return ((int)$a['cc_docrecibidos_det']) <=> ((int)$b['cc_docrecibidos_det']);
});

$estadoDocMap = [
    'P' => ['Pendiente', 'bg-warning-subtle text-warning-emphasis border border-warning-subtle'],
    'T' => ['Trámite',   'bg-info-subtle text-info-emphasis border border-info-subtle'],
    'A' => ['Archivado', 'bg-success-subtle text-success-emphasis border border-success-subtle']
];
[$estadoDocTexto, $estadoDocClase] = $estadoDocMap[$row['flag'] ?? ''] ?? ['—', 'bg-light text-muted border'];

// listarId no trae documento_enviado: la búsqueda usa cc_docrecibidos / c_expediente
$pdf_buscados = [];
$url_pdf = exp_deriv_buscar_pdf($row, $pdf_buscados);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <i class="ri-folder-open-line text-primary me-1"></i>
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
                    <i class="ri-file-pdf-2-line fs-16 me-1"></i><span class="fs-12 fw-semibold">PDF</span>
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
    </div>

    <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="fw-semibold fs-13">
            <i class="ri-route-line text-primary me-1"></i>
            Trazabilidad del documento
        </span>
        <small class="text-muted"><?= count($data_detalle) ?> registro(s)</small>
    </div>

    <?php
    // Árbol de derivaciones (igual que exp_deriv_lista.php): "linea" = id de la derivación padre; 0 = raíz.
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
            $tree[$id] = &$node;   // padre inexistente: se muestra como raíz para no ocultar el registro
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
                    <?php exp_rep_render_traza($rootNode, 1); ?>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <?= bt_cerrar() ?>
</div>