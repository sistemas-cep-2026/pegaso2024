<div class="row">
	<div class="col-xxl-3">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title mb-5">Datos completados</h5>
				<div class="progress animated-progress custom-progress progress-label">
					<div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
						<div class="label">30%</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<h5 class="card-title mb-3">Información</h5>
				<div class="table-responsive">
					<table class="table table-borderless mb-0">
						<tbody>
							<tr>
								<th class="ps-0" scope="row">Celular:</th>
								<td class="text-muted"><?php echo $celular ?></td>
							</tr>
							<tr>
								<th class="ps-0" scope="row">Correo:</th>
								<td class="text-muted"><?php echo $correo ?></td>
							</tr>
							<tr>
								<th class="ps-0" scope="row">Género:</th>
								<td class="text-muted"><?php echo $cod_sexo_text ?>
								</td>
							</tr>
							<tr>
								<th class="ps-0" scope="row">Fec. Nac.:</th>
								<td class="text-muted"><?php echo $fecha_de_nacimiento ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div><!-- end card body -->
		</div><!-- end card -->

		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center mb-4">
					<div class="flex-grow-1">
						<h5 class="card-title mb-0">Observados</h5>
					</div>
				</div>
				<div>
					<div class="d-flex align-items-center py-1">
						<div class="flex-grow-1">
							<div>
								<h5 class="fs-14 mb-1">...</h5>
								<!--<p class="fs-13 text-muted mb-0">Frontend Developer</p>-->
							</div>
						</div>
					</div>
				</div>
			</div><!-- end card body -->
		</div>
	</div>
	<!--end col-->
	<div class="col-xxl-9">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title mb-3">Colegiación</h5>
				<div class="row">
					<div class="col-6 col-md-4">
						<div class="d-flex">
							<div class="flex-grow-1 overflow-hidden">
								<p class="mb-1"><strong> CR COL. :</strong> <?php echo $c_local_textcol ?></p>
								<p class="mb-1"><strong> CEP :</strong> <?php echo digitos($cep, 6) ?></p>
								<p class="mb-1"><strong> Fecha Colegiación :</strong> <?php echo $fecha_de_inicio ?></p>

							</div>
						</div>
					</div>
					<!--end col-->
					<div class="col-6 col-md-4">
						<div class="d-flex">
							<div class="flex-grow-1 overflow-hidden">
								<p class="mb-1"><strong>Resolución :</strong> <?php echo $n_resolucion_cole ?></p>
								<p class="mb-1"><strong>Folio:</strong> <?php echo $n_folio_cole; ?></p>
								<p class="mb-1"><strong>Libro :</strong> <?php echo $n_libro_cole ?></p>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="d-flex">
							<div class="flex-grow-1 overflow-hidden">
								<p class="mb-1"><strong>Estado :</strong> <?php echo $flag_activo_text ?></p>
								<p class="mb-1"><strong>Fecha cese :</strong> <?php echo !empty($fecha_de_cese) ? $fecha_de_cese : '--/--/----'; ?></p>
								<p class="mb-1"><strong>ID :</strong> <?php echo $cc_persona ?></p>
							</div>
						</div>
					</div>
					<!--end col-->
				</div>
				<!--end row-->
			</div>
			<!--end card-body-->
		</div><!-- end card -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0  me-2">Datos Personales</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-6 col-md-4">
								<div class="d-flex">
									<div class="flex-grow-1 overflow-hidden">
										<p class="mb-1"><strong>A. Paterno: </strong> <?php echo $apaterno ?></p>
										<p class="mb-1"><strong>A. Materno:</strong> <?php echo $amaterno; ?></p>
										<p class="mb-1"><strong>Primer Nombre:</strong> <?php echo $nombre1; ?></p>
										<p class="mb-1"><strong>Segundo Nombre:</strong> <?php echo $nombre2; ?></p>
									</div>
								</div>
							</div>
							<!--end col-->
							<div class="col-6 col-md-3">
								<div class="d-flex">
									<div class="flex-grow-1 overflow-hidden">
										<p class="mb-1"><strong>Fec. Nac. :</strong> <?php echo $fecha_de_nacimiento ?></p>
										<p class="mb-1"><strong>Género :</strong> <?php echo $cod_sexo_text ?></p>
										<p class="mb-1"><strong>Est. Civil :</strong> <?php echo $c_e_civil_text ?></p>
										<p class="mb-1"><strong>G. Sang. :</strong> <?php echo $grupo_sanguineo_text ?></p>
									</div>
								</div>
							</div>
							<div class="col-6 col-md-5">
								<div class="d-flex">
									<div class="flex-grow-1 overflow-hidden">
										<p class="mb-1"><strong>Lug. Nac. :</strong> <?php echo $ub_nacimiento ?></p>
										<p class="mb-1"><strong>Dir. Actual :</strong> <?php echo $ub_actual ?></p>
										<p class="mb-1"><strong>Dirección :</strong> <?php echo $direc ?></p>
									</div>
								</div>
							</div>
							<!--end col-->
						</div>
					</div><!-- end card body -->
				</div><!-- end card -->
			</div><!-- end col -->
		</div><!-- end row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0  me-2">Estudios Universitarios</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-6 col-md-6">
								<div class="d-flex">
									<div class="flex-grow-1 overflow-hidden">
										<p class="mb-1"><strong>Bachiller: </strong> <?php echo $uni_bachiller ?></p>
										<p class="text-truncate mb-0"><strong>Fecha:</strong> <?php echo $fecha_de_vachiller; ?></p>
									</div>
								</div>
							</div>
							<!--end col-->
							<div class="col-6 col-md-6">
								<div class="d-flex">
									<div class="flex-grow-1 overflow-hidden">
										<p class="mb-1"><strong>Título :</strong> <?php echo $uni_titulo ?? ''; ?></p>
										<p class="text-truncate mb-0"><strong>Fecha :</strong> <?php echo $fecha_licenciatura ?? ''; ?></p>
									</div>
								</div>
							</div>
							<!--end col-->
						</div>
					</div><!-- end card body -->
				</div><!-- end card -->
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Grados académicos</h5>
				<?php
				if (!empty($data_lista_grados)) {
				?>
					<div class="row">
						<div class="col-lg-12 table-responsive">
							<table class="table table-borderless align-middle mb-0">
								<thead class="table-light">
									<tr>
										<th scope="col">#</th>
										<th scope="col">Grado</th>
										<th scope="col">N° Registro</th>
										<th scope="col">Fecha registro</th>
										<th scope="col">Literal / Mención</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$k = 1;
									foreach ($data_lista_grados as $grados) {
									?>
										<tr>
											<td><?= $k; ?></td>
											<td>
												<div class="flex-shrink-0 avatar-sm">
													<div class="avatar-title bg-primary text-white rounded-3 fs-18 shadow-lg">
														<?= $grados['tipo_especialidad']; ?>
													</div>
												</div>
											</td>

											<td><?= $grados['c_reg_esp']; ?></td>
											<td><?= $grados['fecha']; ?></td>
											<td>
												<div class="flex-grow-1">
													<h6><?= $grados['literal']; ?></h6>
													<p class="text-muted mb-0"><?= $grados['c_especialidad'] . '-' . $grados['mencion']; ?></p>
												</div>
											</td>
										</tr>
									<?php
										$k++;
									}
									?>

								</tbody>
							</table>
						</div>
					</div>
				<?php
				}
				?>
				<!-- Swiper -->
			</div>
			<!-- end card body -->
		</div><!-- end card -->
		<?php
		if (!empty($data_sanciones)) {
		?>
			<div class="card border border-danger-subtle alert alert-danger">
				<div class="card-body ">
					<h5 class="card-title text-danger">Desafiliaciones o sanciones</h5>
					<div class="row">
						<div class="col-lg-12 table-responsive ">
							<table class="table table-borderless table-sm align-middle mb-0">
								<thead class="table-light">
									<tr>
										<th scope="col">#</th>
										<th scope="col">Motivo</th>
										<th scope="col">Resoluciones</th>
										<th scope="col">Desde / Hasta</th>
										<th scope="col">Documento</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$g = 1;
									foreach ($data_sanciones as $sanciones) {
									?>
										<tr>
											<td><?= $g; ?></td>
											<td><?= $sanciones['sancion']; ?></td>
											<td><?= $sanciones['resol2']; ?></td>
											<td><?= $sanciones['desde'] . ' / ' . $sanciones['hasta']; ?></td>
											<td><a href="<?= $sanciones['url']; ?>" target="_blank">Abrir</a></td>
										</tr>
									<?php
										$g++;
									}
									?>
								</tbody>
							</table>
						</div>
					</div>

					<!-- Swiper -->
				</div>
				<!-- end card body -->
			</div><!-- end card -->
		<?php
		}
		?>
	</div>
	<!--end col-->
</div>