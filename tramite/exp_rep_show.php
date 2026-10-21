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

$estadoMap = [
    'A' => ['Atendido',  'bg-success-subtle text-success border border-success-subtle'],
    'T' => ['Recibido',  'bg-info-subtle text-info border border-info-subtle'],
];

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

    <?php if (empty($data_detalle)): ?>
        <div class="alert alert-info border-0 mb-0 py-2">
            <i class="ri-information-line me-1"></i>
            Sin derivaciones registradas
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Área / Acción</th>
                        <th>Envía</th>
                        <th>Recibe</th>
                        <th>Ejecución</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">O/C</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($data_detalle as $det): ?>
                        <?php
                        $flag = trim((string)($det['flag'] ?? ''));
                        [$estadoTexto, $estadoClase] = $estadoMap[$flag] ?? ['Pendiente', 'bg-warning-subtle text-warning border border-warning-subtle'];
                        $ejecucionValor = (isset($det['accion_a_tomar']) && trim((string)$det['accion_a_tomar']) !== '&') ? trim((string)$det['accion_a_tomar']) : '';
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td class="text-nowrap fs-12"><?= htmlspecialchars($det['fecha_entrega_text'] ?? '') ?></td>
                            <td>
                                <div class="fw-semibold fs-13"><?= htmlspecialchars($det['c_area_adm_text'] ?? '') ?></div>
                                <?php if (!empty($det['c_accion_text'])): ?>
                                    <div class="text-muted fs-12"><?= htmlspecialchars($det['c_accion_text']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($det['observacion'])): ?>
                                    <div class="text-muted fs-12 fst-italic">"<?= htmlspecialchars($det['observacion']) ?>"</div>
                                <?php endif; ?>
                            </td>
                            <td class="fs-13"><?= htmlspecialchars($det['c_usuario'] ?? '') ?></td>
                            <td class="fs-13">
                                <?php if (!empty($det['usu_recep'])): ?>
                                    <?= htmlspecialchars($det['usu_recep']) ?>
                                    <div class="text-muted fs-11"><?= htmlspecialchars($det['feha_respuesta_text'] ?? '') ?></div>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="fs-13">
                                <?= $ejecucionValor !== '' ? htmlspecialchars($ejecucionValor) : '<span class="text-muted">—</span>' ?>
                            </td>
                            <td class="text-center">
                                <span class="badge <?= $estadoClase ?>"><?= $estadoTexto ?></span>
                            </td>
                            <td class="text-center fs-12">
                                <?= htmlspecialchars($det['cod_original_text'] ?? '') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <?= bt_cerrar() ?>
</div>
