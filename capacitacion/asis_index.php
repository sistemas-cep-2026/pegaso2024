<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos.php");


$bo_general = new bo_general();
$bo_eventos = new bo_cap_eventos();
$cc_local = s_local();
$usuario = s_usuario();
$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
$data_anho = $bo_eventos->listarAnhos();
?>
<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">CONTROL SE ASISTENCIA A EVENTOS</h4>
                <div class="col-sm-auto">
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="#" onclick="javascrip:fn_control('', '<?= s_crypt('I', 'in') ?>')" class="btn btn-success add-btn" data-bs-placement="top" title="Nuevo Evento"><i class="ri-add-line align-bottom me-1"></i> Nueva persona</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-12">
                        <form class="needs-validation" id="frmBuscarRegistro" action="javascript:fn_listarRegistro()" method="post" novalidate>
                            <div class="row mb-3 justify-content-center">
                                <!--<div class="col-sm-2">
                                    <select name="anho" id="anho" class="form-control" onchange="cargarEventos()" required>
                                        <option value="">Año</option>
                                        <?php //foreach ($data_anho as $row) { 
                                        ?>
                                            <option value="<?php //echo htmlspecialchars($row['anho']); 
                                                            ?>"
                                                <?php //echo ($row['anho'] == date('Y')) ? 'selected' : ''; 
                                                ?>>
                                                <?php //echo htmlspecialchars($row['anho']); 
                                                ?>
                                            </option>
                                        <?php //} 
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control" id="c_local" name="c_local" onchange="cargarEventos()">
                                        <option value="">Selecciona...</option>
                                        <?php //foreach ($data_local as $loc): 
                                        ?>
                                            <option value="<?php // $loc['c_local'] 
                                                            ?>">
                                                <?php //$loc['nombre'] 
                                                ?>
                                            </option>
                                        <?php //endforeach; 
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <select class="form-control select2" id="cc_evento" name="cc_evento" required>
                                    </select>
                                </div>-->
                                <div class="col-sm-7">
                                    <select class="form-control select2" id="cc_evento" name="cc_evento" required>
                                        <option value="392">III CONGRESO INTERNACIONAL CEP 2026 Empatía en acción, construyendo puentes entre la ciencia, la educación y la sociedad</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" col-sm-6">
                                    <div class="col-xxl-12 col-sm-7">
                                        <div class="search-box">
                                            <input type="hidden" class="form-control" name="c_persona" value="">
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="CEP - Apellidos y nombres" value="" required>
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo fecha_hoy() ?>">
                                </div>

                                <div class="col-sm-3">
                                    <?php echo bt_buscar("Buscar") ?> <?php bt_cancelar() ?>
                                </div>
                            </div>
                        </form>

                        <div class="row mb-3">
                            <div class="col-lg-12 table-responsive">
                                <div id="div_listarRegistro"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- end row -->
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable() . importToolTip() . importTypeahead();
} ?>