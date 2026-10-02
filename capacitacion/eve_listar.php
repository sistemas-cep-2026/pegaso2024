<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos.php");
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");

$bo_general = new bo_general();
$bo_eventos = new bo_cap_eventos();
$bo_matricula = new bo_cap_eventos_matricula();

$ent_eventos = new cap_eventos();

$nombre = $_REQUEST['fnombre'] ?? '';
$anho = $_REQUEST['fanho'] ?? null;
$c_local = $_REQUEST['fc_local'] ?? null;
$tipo = $_REQUEST['ftipo'] ?? null;
$pagina = max(1, (int) ($_REQUEST['pagina'] ?? 1));
$por_pagina = 6;

$ent_eventos->setNombre($nombre);
$ent_eventos->setFecha_ini($anho);
$ent_eventos->setCc_local($c_local);
$ent_eventos->setTipo($tipo);

$data_evento_todos = $bo_eventos->listar($ent_eventos);
$total = count($data_evento_todos);
$total_paginas = max(1, (int) ceil($total / $por_pagina));
$pagina = min($pagina, $total_paginas);
$data_evento = array_slice($data_evento_todos, ($pagina - 1) * $por_pagina, $por_pagina);
?>
<?php if (empty($data_evento)): ?>
	<div class="col-12">
		<div class="text-center p-5 text-muted">
			<i class="ri-book-open-line fs-1 d-block mb-2"></i>
			No se encontraron cursos para este filtro.
		</div>
	</div>
<?php endif; ?>

<?php foreach ($data_evento as $row):
	$flag = strtoupper(trim((string) ($row['flag'] ?? '')));
	$publicado = ($flag !== 'A');

	$data_roles = $bo_matricula->resumenRoles($row['cc_evento']);
	$asistentes = (int) ($data_roles[0]['asistentes'] ?? 0);
	$ponentes = (int) ($data_roles[0]['ponentes'] ?? 0);
	$organizadores = (int) ($data_roles[0]['organizadores'] ?? 0);
?>
	<div class="col-xl-4 col-md-6">
		<div class="card h-100 border">
			<div class="position-relative">
				<div style="height:34px; background:linear-gradient(135deg, #1a2b4c 0%, #2c4a7c 100%);"></div>
				<span class="badge bg-dark position-absolute top-0 start-0 m-2"><?= htmlspecialchars($row['tipo']) ?> [<?= $row['cc_evento'] ?>]</span>
				<?php if ($publicado) { ?>
					<span class="badge bg-success position-absolute top-0 end-0 m-2"><i class="ri-check-double-line align-middle"></i> Publicado</span>
				<?php } else { ?>
					<span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">No publicado</span>
				<?php } ?>
			</div>
			<div class="card-body d-flex flex-column">
				<h6 class="mb-2"><?= htmlspecialchars($row['nombre']) ?></h6>
				<p class="text-muted fs-13 mb-2 flex-grow-1"><?= htmlspecialchars(mb_strimwidth((string) $row['detalle'], 0, 110, '...')) ?></p>

				<div class="fs-13 text-muted mb-1">
					<i class="ri-calendar-2-line align-middle me-1"></i>
					<?= $row['fecha_inicio'] ?> — <?= $row['fecha_fin'] ?>
				</div>
				<div class="fs-13 text-muted mb-3">
					<i class="ri-award-line align-middle me-1"></i>
					<?= $row['horascreditos_text'] ?>
				</div>

				<div class="row text-center g-1 mb-3">
					<div class="col-4 border-end">
						<div class="fw-semibold"><?= $asistentes ?></div>
						<div class="fs-11 text-muted text-uppercase">Asistentes</div>
					</div>
					<div class="col-4 border-end">
						<div class="fw-semibold"><?= $ponentes ?></div>
						<div class="fs-11 text-muted text-uppercase">Ponentes</div>
					</div>
					<div class="col-4">
						<div class="fw-semibold"><?= $organizadores ?></div>
						<div class="fs-11 text-muted text-uppercase">Coordinadores</div>
					</div>
				</div>

				<div class="d-flex gap-1">
					<a href="?id=<?= s_crypt('410001') ?>&sec=<?= s_crypt('2') ?>&cod=<?= s_crypt($row["cc_evento"]) ?>&opc=<?= s_crypt('U') ?>"
						class="btn btn-soft-primary btn-sm flex-grow-1 waves-effect waves-light"
						data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar evento" aria-label="Modificar evento">
						<i class="ri-edit-2-line align-middle me-1"></i> Editar
					</a>
					<?php if (!empty($row['img_certificado'])) { ?>
						<a href="javascript:void(0);" onclick="fn_verdiploma('<?= url('capacitacion/img/' . $row['img_certificado']) ?>')"
							class="btn btn-soft-secondary btn-sm waves-effect waves-light"
							data-bs-toggle="tooltip" data-bs-placement="top" title="Ver imagen" aria-label="Ver imagen">
							<i class="ri-image-line"></i>
						</a>
					<?php } ?>
					<?php if (!$publicado) { ?>
						<a href="javascript:void(0);"
							onclick='publicar_evento(<?= json_encode(s_crypt($row["cc_evento"], "in")) ?>,<?= json_encode(s_crypt("PU", "in")) ?>);'
							class="btn btn-soft-info btn-sm waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Publicar evento" aria-label="Publicar evento">
							<i class="ri-upload-cloud-2-line"></i>
						</a>
					<?php } ?>
				</div>
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