<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_cap_eventos.php");
require_once(dirname(__DIR__) . "/util/config_file.php");

$bo_eventos = new bo_cap_eventos();

$es_admin_general = (s_local() === '28');

$nombre   = trim((string) ($_REQUEST['fnombre'] ?? ''));
$anho     = (string) ($_REQUEST['fanho'] ?? '');
$tipo     = (string) ($_REQUEST['ftipo'] ?? '');
// Fuera del Consejo Nacional solo se listan los cursos del propio consejo
$c_local  = $es_admin_general ? (string) ($_REQUEST['fc_local'] ?? '') : s_local();
$pagina   = max(1, (int) ($_REQUEST['pagina'] ?? 1));
$por_pagina = 9;

$data_evento = $bo_eventos->listarPaginado($nombre, $anho, $c_local, $tipo, $pagina, $por_pagina);
if (!is_array($data_evento)) {
	$data_evento = array();
}
$total = isset($data_evento[0]['total']) ? (int) $data_evento[0]['total'] : 0;
$total_paginas = max(1, (int) ceil($total / $por_pagina));

$h = function ($v) {
	return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8', false);
};

// Estado de certificados (flag) y del portal
$estado_flag = array(
	'PU' => array('Certificados publicados', 'success', 'ri-award-fill'),
	'PE' => array('Certificados pendientes', 'warning', 'ri-time-line'),
	'A'  => array('Anulado', 'danger', 'ri-close-circle-line'),
);
$opc_sc = s_crypt('SC', 'in');
$opc_ec = s_crypt('EC', 'in');
$opc_pu = s_crypt('PU', 'in');
$opc_dp = s_crypt('DP', 'in');
?>
<?php if (empty($data_evento)): ?>
	<div class="col-12">
		<div class="text-center p-5 text-muted">
			<i class="ri-book-open-line fs-1 d-block mb-2"></i>
			No se encontraron cursos para este filtro.
		</div>
	</div>
<?php endif; ?>

<?php if ($total > 0): ?>
	<div class="col-12">
		<p class="text-muted fs-13 mb-0"><?= $total ?> curso(s) encontrado(s)</p>
	</div>
<?php endif; ?>

<?php foreach ($data_evento as $row):
	$cc_evento = (int) $row['cc_evento'];
	$flag   = strtoupper(trim((string) ($row['flag'] ?? '')));
	$portal = (strtoupper(trim((string) ($row['portal'] ?? ''))) === 'S');
	$anulado = ($flag === 'A');
	$est = isset($estado_flag[$flag]) ? $estado_flag[$flag] : array('Sin estado', 'secondary', 'ri-question-line');

	$cod = s_crypt($cc_evento, 'in');

	// El detalle viene en HTML (CKEditor): se muestra como texto plano resumido
	$resumen = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $row['detalle']), ENT_QUOTES, 'UTF-8')));
	$resumen = mb_strimwidth($resumen, 0, 140, '...', 'UTF-8');

	$fecha_texto = trim((string) ($row['fecha_evento_text'] ?? ''));
?>
	<div class="col-xxl-4 col-lg-6">
		<div class="card h-100 border shadow-none mb-0 <?= $anulado ? 'opacity-75' : '' ?>">
			<!-- Cabecera compacta, del color del estado de certificados: tipo, código y estados juntos -->
			<div class="rounded-top px-2 py-2 d-flex gap-1 flex-wrap align-items-center bg-<?= $est[1] ?>-subtle border-bottom border-<?= $est[1] ?>">
				<span class="badge bg-primary"><?= $h($row['tipo']) ?></span>
				<span class="badge bg-dark">#<?= $cc_evento ?><?= trim((string) $row['codigo']) !== '' ? ' · ' . $h($row['codigo']) : '' ?></span>
				<span class="badge bg-<?= $est[1] ?>"><i class="<?= $est[2] ?> align-middle me-1"></i><?= $est[0] ?></span>
				<?php if ($portal) { ?>
					<span class="badge bg-info"><i class="ri-global-line align-middle me-1"></i>En el portal</span>
				<?php } else { ?>
					<span class="badge bg-secondary"><i class="ri-eye-off-line align-middle me-1"></i>No está en el portal</span>
				<?php } ?>
			</div>

			<div class="card-body d-flex flex-column">
				<h6 class="mb-1 lh-base"><?= $h($row['nombre']) ?></h6>
				<p class="text-muted fs-12 mb-2"><i class="ri-map-pin-line align-middle me-1"></i><?= $h($row['cc_local_text']) ?></p>

				<p class="text-muted fs-13 mb-3 flex-grow-1"><?= $h($resumen) ?></p>

				<ul class="list-unstyled fs-13 text-muted mb-3">
					<li class="mb-1">
						<i class="ri-calendar-2-line align-middle me-1"></i>
						<?= $h($row['fecha_inicio']) ?> — <?= $h($row['fecha_fin']) ?>
						<?php if ($fecha_texto !== '') { ?><span class="d-block ps-4 fs-12"><?= $h($fecha_texto) ?></span><?php } ?>
					</li>
					<?php if (trim((string) $row['horascreditos_text']) !== '') { ?>
						<li><i class="ri-award-line align-middle me-1"></i><?= $h($row['horascreditos_text']) ?></li>
					<?php } ?>
				</ul>

				<div class="row text-center g-0 mb-3 border rounded py-2">
					<div class="col-4 border-end">
						<div class="fw-semibold"><?= (int) $row['asistentes'] ?></div>
						<div class="fs-11 text-muted text-uppercase">Asistentes</div>
					</div>
					<div class="col-4 border-end">
						<div class="fw-semibold"><?= (int) $row['ponentes'] ?></div>
						<div class="fs-11 text-muted text-uppercase">Ponentes</div>
					</div>
					<div class="col-4">
						<div class="fw-semibold"><?= (int) $row['organizadores'] ?></div>
						<div class="fs-11 text-muted text-uppercase">Coordinadores</div>
					</div>
				</div>

				<!-- Acciones del curso -->
				<div class="d-flex gap-1 mb-2">
					<a href="?id=<?= s_crypt('410001') ?>&sec=<?= s_crypt('2') ?>&cod=<?= $cod ?>&opc=<?= s_crypt('U') ?>"
						class="btn btn-soft-primary btn-sm flex-grow-1 waves-effect waves-light"
						data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar evento" aria-label="Modificar evento">
						<i class="ri-edit-2-line align-middle me-1"></i> Editar
					</a>
					<?php $url_asis = u_file_certificado_url($row['img_asistente'] ?? '');
					if ($url_asis !== '') { ?>
						<a href="javascript:void(0);" onclick="fn_verdiploma(<?= $h(json_encode($url_asis)) ?>)"
							class="btn btn-soft-secondary btn-sm waves-effect waves-light"
							data-bs-toggle="tooltip" data-bs-placement="top" title="Ver diploma asistente" aria-label="Ver diploma asistente">
							<i class="ri-image-line"></i>
						</a>
					<?php } ?>
					<?php $url_pon = u_file_certificado_url($row['img_ponente'] ?? '');
					if ($url_pon !== '') { ?>
						<a href="javascript:void(0);" onclick="fn_verdiploma(<?= $h(json_encode($url_pon)) ?>)"
							class="btn btn-soft-secondary btn-sm waves-effect waves-light"
							data-bs-toggle="tooltip" data-bs-placement="top" title="Ver diploma ponente" aria-label="Ver diploma ponente">
							<i class="ri-user-star-line"></i>
						</a>
					<?php } ?>
				</div>

				<!-- Acciones del portal (solo Consejo Nacional) -->
				<?php if ($es_admin_general && !$anulado) { ?>
					<div class="d-flex gap-1 border-top pt-2">
						<?php if ($flag === 'PU') { ?>
							<button type="button" class="btn btn-outline-danger btn-sm flex-grow-1"
								onclick="fn_portalEvento('<?= $cod ?>','<?= $opc_dp ?>','¿Dejar de publicar los certificados de este curso?')">
								<i class="ri-arrow-go-back-line align-middle me-1"></i> Dejar de publicar
							</button>
						<?php } else { ?>
							<?php if ($portal) { ?>
								<button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1"
									onclick="fn_portalEvento('<?= $cod ?>','<?= $opc_ec ?>','¿Retirar este curso del portal?')">
									<i class="ri-delete-bin-line align-middle me-1"></i> Quitar del portal
								</button>
							<?php } else { ?>
								<button type="button" class="btn btn-outline-info btn-sm flex-grow-1"
									onclick="fn_portalEvento('<?= $cod ?>','<?= $opc_sc ?>','¿Subir este curso al portal?')">
									<i class="ri-upload-cloud-2-line align-middle me-1"></i> Subir al portal
								</button>
							<?php } ?>
							<button type="button" class="btn btn-success btn-sm flex-grow-1"
								onclick="fn_portalEvento('<?= $cod ?>','<?= $opc_pu ?>','¿Publicar el curso con sus certificados, módulos, matrículas y notas?')">
								<i class="ri-award-line align-middle me-1"></i> Publicar
							</button>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php if ($total_paginas > 1): ?>
	<div class="col-12">
		<nav aria-label="Paginación de cursos">
			<ul class="pagination justify-content-center mb-0">
				<li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
					<a class="page-link" href="javascript:void(0);" onclick="fn_listarEventos(<?= $pagina - 1 ?>)">Anterior</a>
				</li>
				<?php for ($p = 1; $p <= $total_paginas; $p++): ?>
					<li class="page-item <?= $p == $pagina ? 'active' : '' ?>">
						<a class="page-link" href="javascript:void(0);" onclick="fn_listarEventos(<?= $p ?>)"><?= $p ?></a>
					</li>
				<?php endfor; ?>
				<li class="page-item <?= $pagina >= $total_paginas ? 'disabled' : '' ?>">
					<a class="page-link" href="javascript:void(0);" onclick="fn_listarEventos(<?= $pagina + 1 ?>)">Siguiente</a>
				</li>
			</ul>
		</nav>
	</div>
<?php endif; ?>
