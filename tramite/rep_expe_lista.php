<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_general           = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos     = new bo_tram_documentos_recibidos();

$ent_doc_recibidos = new tram_documentos_recibidos();

$cc_local = s_local();
$sede     = ($cc_local == '28') ? 'CN' : 'CR';

$tipo_filtro      = $_REQUEST['tipo_filtro'] ?? '';
$exp_digitos      = preg_replace('/\D/', '', $_REQUEST['c_expediente'] ?? '');
$nombre_remitente = $_REQUEST["nombre_remitente"] ?? '';
$c_area_adm       = $_REQUEST["c_area_adm"] ?? '';
$gestion          = $_REQUEST["gestion"] ?? '';

// Los campos bloqueados no llegan: sin fecha no se filtra por fecha
$f_desde     = trim($_REQUEST["fecha_desde"] ?? '');
$f_hasta     = trim($_REQUEST["fecha_hasta"] ?? '');
$fecha_desde = ($f_desde !== '') ? u_fecha($f_desde) . ' 01:00' : '';
$fecha_hasta = ($f_hasta !== '') ? u_fecha($f_hasta) . ' 23:59' : '';

// Filtro EXPEDIENTE: el número es obligatorio
if ($tipo_filtro === '01' && (int) $exp_digitos === 0) {
    echo '<div class="alert alert-warning mb-0">Ingrese el número de expediente.</div>';
    exit;
}

// Se acepta el correlativo (hasta 7 dígitos) o el número completo (11 dígitos: local + gestión + correlativo)
if ((int) $exp_digitos === 0) {
    $numero = '';
} elseif (strlen($exp_digitos) === 11) {
    $numero = $exp_digitos;
} elseif (strlen($exp_digitos) <= 7) {
    $numero =
        str_pad($cc_local, 2, '0', STR_PAD_LEFT) .
        str_pad($gestion, 2, '0', STR_PAD_LEFT) .
        str_pad((int) $exp_digitos, 7, '0', STR_PAD_LEFT);
} else {
    echo '<div class="alert alert-warning mb-0">El expediente debe tener hasta 7 dígitos o los 11 completos.</div>';
    exit;
}

$ent_doc_recibidos->setFecha_desde($fecha_desde);
$ent_doc_recibidos->setFecha_hasta($fecha_hasta);
$ent_doc_recibidos->setC_expediente($numero);
// listar() filtra el expediente con Num_desde/Num_hasta (igual que exp_rep_listar.php)
$ent_doc_recibidos->setNum_desde($numero);
$ent_doc_recibidos->setNum_hasta($numero);
$ent_doc_recibidos->setNombre_remitente($nombre_remitente);
$ent_doc_recibidos->setC_area_adm($c_area_adm);
$ent_doc_recibidos->setC_local($cc_local);
$ent_doc_recibidos->setGestion($gestion);
$data_exp = $bo_doc_recibidos->listar($ent_doc_recibidos);

$estadoMap = [
    'P' => ['PENDIENTE', 'warning'],
    'A' => ['ARCHIVADO', 'success'],
    'T' => ['TRAMITE', 'info'],
];
?>

<div class="table-responsive">
    <table class="table table-striped table-hover table-sm align-middle" id="table-reporte">
        <thead>
            <tr class="table-light">
                <th>#</th>
                <th>Fecha</th>
                <th>Expediente</th>
                <th>Nombre</th>
                <th>Número</th>
                <th>Fec. Doc.</th>
                <th>Asunto</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($data_exp as $row): ?>
                <?php
                $flag = trim((string)($row['flag'] ?? ''));
                [$estadoTexto, $estadoColor] = $estadoMap[$flag] ?? ['—', 'secondary'];
                ?>
                <tr data-cc-docrecibidos="<?= (int)$row['cc_docrecibidos'] ?>">
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['fecha_ingreso'] ?? '') ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($row['c_expediente'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['nombre_remitente'] ?? ($row['razon_social'] ?? '')) ?></td>
                    <td><?= htmlspecialchars($row['num_documento'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['fecha_documento_text'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['asunto'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['c_usuario'] ?? '') ?></td>
                    <td><span class="badge bg-<?= $estadoColor ?>-subtle text-<?= $estadoColor ?>"><?= $estadoTexto ?></span></td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="javascript:void(0);" onclick="fn_verSeguimientoExp('<?= s_crypt($row['cc_docrecibidos']) ?>');"
                                class="btn btn-soft-primary btn-sm waves-effect waves-light"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Ver seguimiento" aria-label="Ver seguimiento">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="javascript:void(0);" onclick="redireccionar_ventana('<?= url('tramite/exp_print?cod=' . s_crypt($row['cc_docrecibidos'])) ?>',750);"
                                class="btn btn-soft-secondary btn-sm waves-effect waves-light"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir" aria-label="Imprimir">
                                <i class="ri-printer-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>