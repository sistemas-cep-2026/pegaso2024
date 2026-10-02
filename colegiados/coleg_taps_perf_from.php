<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_general = new bo_general();
$bo_personas = new bo_gen_personas();
$bo_gen_parametro_det = new bo_gen_parametro_det();

$ent_personas = new gen_personas();

$cc_persona = s_crypt($_REQUEST['id'], 'out');
$opc = 'U';

$data_pais = $bo_general->listarPais();
$data_ubigeo = $bo_general->listarUbigeoAgrupado();
$data_tpdocumen = $bo_gen_parametro_det->listarParametroDet('personas', 'cod_documento');
$data_sexo = $bo_gen_parametro_det->listarParametroDet('personas', 'cod_sexo');
$data_civil = $bo_gen_parametro_det->listarParametroDet('personas', 'c_e_civil');
$data_activo = $bo_gen_parametro_det->listarParametroDet('personas', 'flag_activo');
$data_sangre = $bo_gen_parametro_det->listarParametroDet('personas', 'grupo_sanguineo');
$data_local = $bo_general->listar28Regiones();
$data_universidad = $bo_general->listarUniversidad();
$data_vin_laboral = $bo_general->listarVinculoLaboral();

$ent_personas->setC_persona($cc_persona);
$data_per = $bo_personas->listarID($ent_personas);
//print_r($data_per);
foreach ($data_per as $row) {
    $ent_personas->setC_persona($row['c_persona']);
    $ent_personas->setC_cmp($row['c_cmp']);
    $ent_personas->setApellido_materno($row['apellido_materno']);
    $ent_personas->setApellido_paterno($row['apellido_paterno']);
    $ent_personas->setNombre1($row['nombre1']);
    $ent_personas->setNombre2($row['nombre2']);
    $ent_personas->setFlag_activo($row['flag_activo']);
    $ent_personas->setCod_documento($row['cod_documento']);
    $ent_personas->setNum_documento($row['num_documento']);
    $ent_personas->setC_local($row['c_local']);
    $ent_personas->setCod_sexo($row['cod_sexo']);
    $ent_personas->setCelular1($row['celular1']);
    $ent_personas->setGrupo_sanguineo($row['grupo_sanguineo_text']);
    $ent_personas->setFecha_de_nacimiento($row['fecha_de_nacimiento']);
    $ent_personas->setEmail1($row['email1']);
    $ent_personas->setFlag_habil($row['flag_habil']);
    $ent_personas->setFecha_fallecido($row['fecha_fallecido']);
    $ent_personas->setC_entidad_pagadora($row['c_entidad_pagadora']);
    $ent_personas->setC_e_civil($row['c_e_civil']);
    $ent_personas->setFactor_sanguineo($row['factor_sanguineo']);
    $ent_personas->setN_folio_cole($row['n_folio_cole']);
    $ent_personas->setN_libro_cole($row['n_libro_cole']);
    $ent_personas->setN_resolucion_cole($row['n_resolucion_cole']);
    $ent_personas->setC_universidad(empty($row['c_universidad']) ? '000000' : $row['c_universidad']);
    $ent_personas->setC_univ_licenciatura(empty($row['c_univ_licenciatura']) ? '000000' : $row['c_univ_licenciatura']);
    $ent_personas->setFecha_licenciatura($row['fecha_licenciatura']);
    //$ent_personas->setN_titulo_licenciatura($row['n_titulo_licenciatura']);
    $ent_personas->setCc_persona($row['c_persona']);
    $ent_personas->setUbigeonac($row['ubigeonac']);
    $ent_personas->setUbigeodirec($row['ubigeodirec']);
    $ent_personas->setPais_nacimiento($row['pais_nacimiento']);
    $ent_personas->setTipo_direccion($row['tipo_direccion']);
    $ent_personas->setC_local_colegiacion($row['c_local_colegiacion']);
    $ent_personas->setFecha_de_inicio($row['fecha_de_inicio']);
    $ent_personas->setFecha_promocion($row['fecha_de_vachiller']);
    $ent_personas->setC_entidad_pagadora($row['c_entidad_pagadora']);
    $ent_personas->setDDIRECTO($row['DDIRECTO']);
}
$foto = buscarFoto($ent_personas->getNum_documento());
$data_ent_pagadora = $bo_general->listarEntidadesPagadoras($ent_personas->getC_local());

$user_col = ['ADMIN', 'G280028', 'CN00105', 'CN00103'];
$is_user_col = !in_array(s_usuario(), $user_col);
$readonly = !in_array(s_usuario(), $user_col) ? 'readonly' : '';
?>
<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body container-form-registro">
                <h5 class="card-title mb-3">Actualizar Perfil</h5>
                <form class="needs-validation" id="frmFormRegistro" action="javascript:fn_guardarRegistro()" method="post" novalidate>
                    <input type="hidden" class="form-control" name="cc_persona" id="cc_persona" value="<?= s_crypt($cc_persona) ?>">
                    <input type="hidden" class="form-control" name="opc" id="opc" value="<?= s_crypt($opc) ?>">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Flag Activo</span>
                                        <select name="flag_activo" id="flag_activo" class="form-select text-uppercase" required>
                                            <option value="">Seleccione...</option>
                                            <?php
                                            foreach ($data_activo as $activo) {
                                                $selected_activo = ($ent_personas->getFlag_activo() === $activo['cc_codigo']) ? 'selected' : '';
                                                /* if ($selected_activo !== 'selected' && $is_user_col) {
                                                    continue;
                                                } */
                                            ?>
                                                <option value="<?= $activo['cc_codigo'] ?>" <?= $selected_activo; ?>><?= $activo['detalle']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">CEP : </span>
                                        <input type="text" class="form-control" id="c_cmp" name="c_cmp" placeholder="" value="<?= $ent_personas->getC_cmp(); ?>" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">CR Colegiación</span>
                                        <select name="c_local_colegiacion" id="c_local_colegiacion" class="form-select select2" data-placeholder="Selecciona el CR de colegiación" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_local as $local_col) {
                                                $select_local_col = $ent_personas->getC_local_colegiacion() === $local_col['c_local'] ? 'selected' : '';
                                                if ($select_local_col !== 'selected' && $is_user_col) {
                                                    continue;
                                                }
                                            ?>
                                                <option value="<?= $local_col['c_local']; ?>" <?= $select_local_col; ?>><?= $local_col['nombre_abv'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Fecha Inicio</span>
                                        <input type="date" class="form-control" id="fecha_de_inicio" name="fecha_de_inicio" placeholder="" value="<?= $ent_personas->getFecha_de_inicio(); ?>" required <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Fecha Fallecido</span>
                                        <input type="date" class="form-control" id="fecha_fallecido" name="fecha_fallecido" placeholder="" value="<?= $ent_personas->getFecha_fallecido(); ?>" <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">CR Aportes</span>
                                        <select name="c_local" id="c_local" class="form-select select2" data-placeholder="Selecciona el CR de aportes" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_local as $local) {
                                                $select_local = $ent_personas->getC_local() === $local['c_local'] ? 'selected' : '';
                                            ?>
                                                <option value="<?= $local['c_local']; ?>" <?= $select_local; ?>><?= $local['nombre_abv'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Ent. pagadora</span>
                                        <select name="c_entidad_pagadora" id="c_entidad_pagadora" class="form-select select2" data-placeholder="Selecciona la entidad pagadora" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_ent_pagadora as $ent_pagadora) {
                                                $select_ent_pag = $ent_personas->getC_entidad_pagadora() == $ent_pagadora['c_entidad_pagadora'] ? 'selected' : '';
                                            ?>
                                                <option value="<?= $ent_pagadora['c_entidad_pagadora']; ?>" <?= $select_ent_pag; ?> <?= '';//$disabled ?>><?= $ent_pagadora['nombre_entidad_pagadora'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Vínculo Laboral</span>
                                        <select name="condicion_laboral" id="condicion_laboral" class="form-select select2" data-placeholder="Selecciona el vinculo laboral">
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_vin_laboral as $vin_laboral) {
                                                $select_vin_lab = trim($ent_personas->getDDIRECTO()) == trim($vin_laboral['cod_condicion_laboral']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= trim($vin_laboral['cod_condicion_laboral']); ?>" <?= $select_vin_lab; ?> <?= '';//$disabled ?>><?= $vin_laboral['condicion_laboral'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Tipo. Doc. : </span>
                                        <select class="form-select" id="cod_documento" name="cod_documento" required>
                                            <?php
                                            foreach ($data_tpdocumen as $est) {
                                                $tipo_doc_col = $ent_personas->getCod_documento() == $est['cc_codigo'] ? 'selected' : '';
                                                if ($tipo_doc_col !== 'selected' && $is_user_col) {
                                                    continue;
                                                }
                                                ?>
                                                <option value="<?= $est['cc_codigo']; ?>" <?= $tipo_doc_col ?>>
                                                    <?= $est['detalle']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"># Doc :</span>
                                        <input type="text" class="form-control" id="num_documento" name="num_documento" placeholder="" value="<?= $ent_personas->getNum_documento(); ?>" required <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">A. Paterno : </span>
                                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="" value="<?= $ent_personas->getApellido_paterno(); ?>" required <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">A. Materno : </span>
                                        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="" value="<?= $ent_personas->getApellido_materno(); ?>" required <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Primer nombre : </span>
                                        <input type="text" class="form-control" id="nombre1" name="nombre1" placeholder="" value="<?= $ent_personas->getNombre1(); ?>" required <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Segundo Nombre : </span>
                                        <input type="text" class="form-control" id="nombre2" name="nombre2" placeholder="" value="<?= $ent_personas->getNombre2(); ?>" <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Pais de Nacimiento : </span>
                                        <select class="form-select select2" id="pais_nacimiento" name="pais_nacimiento" required data-placeholder="Selecciona un país" width="100%">
                                            <option value="" disabled selected>Selecciona un país</option>
                                            <?php foreach ($data_pais as $pais) { ?>
                                                <option value="<?= $pais['cc_pais']; ?>" <?= ($ent_personas->getPais_nacimiento() == $pais['cc_pais']) ? 'selected' : ''; ?>>
                                                    <?= $pais['nombre']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Ubigeo Nacimiento</span>
                                        <select name="ubigeonac" id="ubigeonac" class="form-select select2"
                                            data-placeholder="Selecciona el ubigeo de nacimiento"
                                            <?= $ent_personas->getPais_nacimiento() !== '192' ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_ubigeo as $ubigeo) {
                                                $selected_ubi_nac = (trim($ent_personas->getUbigeonac()) == trim($ubigeo['cc_ubigeo'])) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $ubigeo['cc_ubigeo'] ?>" <?= $selected_ubi_nac; ?>><?= $ubigeo['nombre_ubigeo'] ?></option>
                                            <?php

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Ubigeo dirección</span>
                                        <select name="ubigeodirec" id="ubigeodirec" class="form-select select2" data-placeholder="Selecciona el ubigeo de dirección" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_ubigeo as $ubigeo_direc) {
                                                $selected_ubi_direc = ($ent_personas->getUbigeodirec() == $ubigeo_direc['cc_ubigeo']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $ubigeo_direc['cc_ubigeo'] ?>" <?= $selected_ubi_direc; ?>><?= $ubigeo_direc['nombre_ubigeo'] ?></option>
                                            <?php

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Dirección : </span>
                                        <input type="text" class="form-control" id="tipo_direccion" name="tipo_direccion" placeholder="" value="<?= $ent_personas->getTipo_direccion(); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Fecha de Nacimiento</span>
                                        <input type="date" class="form-control" id="fecha_de_nacimiento" name="fecha_de_nacimiento" placeholder="" value="<?= $ent_personas->getfecha_de_nacimiento(); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Grupo Sanguineo</span>
                                        <select name="grupo_sanguineo" id="grupo_sanguineo" class="form-select" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($data_sangre as $sangre) {
                                                $select_sangre = $ent_personas->getGrupo_sanguineo() === $sangre['cc_codigo'] ? 'selected' : '';
                                            ?>
                                                <option value="<?= $sangre['cc_codigo']; ?>" <?= $select_sangre; ?>><?= $sangre['detalle_corto'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Estado Civil</span>
                                        <select name="c_e_civil" id="c_e_civil" class="form-select text-uppercase" required>
                                            <?php
                                            foreach ($data_civil as $civil) {
                                                $selected_civil = ($ent_personas->getC_e_civil() == $civil['cc_codigo']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $civil['cc_codigo'] ?>" <?= $selected_civil ?>><?= $civil['detalle']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Cod Sexo</span>
                                        <select name="cod_sexo" id="cod_sexo" class="form-select text-uppercase" required>
                                            <?php
                                            foreach ($data_sexo as $sexo) {
                                                $selected_sexo = ($ent_personas->getCod_sexo() == $sexo['cc_codigo']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $sexo['cc_codigo'] ?>" <?= $selected_sexo; ?>><?= $sexo['detalle']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Celular : </span>
                                        <input type="text" class="form-control" id="celular1" name="celular1" placeholder="" value="<?= $ent_personas->getCelular1(); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Correo : </span>
                                        <input type="email" class="form-control" id="email1" name="email1" placeholder="" value="<?= $ent_personas->getEmail1(); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Bachillerato : </span>
                                        <select name="c_universidad" id="c_universidad" class="form-select select2" data-placeholder="Selecciona la universidad de bachillerato">
                                            <?php
                                            foreach ($data_universidad as $universidad) {
                                                $selected_bach = ($ent_personas->getC_universidad() == $universidad['c_universidad']) ? 'selected' : '';
                                                if ($selected_bach !== 'selected' && $is_user_col) {
                                                    continue;
                                                }
                                            ?>
                                                <option value="<?= $universidad['c_universidad']; ?>" <?= $selected_bach; ?>>
                                                    <?= $universidad['nombre']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Fecha Bachillerato</span>
                                        <input type="date" class="form-control" id="fecha_promocion" name="fecha_promocion" placeholder="" value="<?= $ent_personas->getFecha_promocion(); ?>" <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Licenciatura : </span>
                                        <select name="c_univ_licenciatura" id="c_univ_licenciatura" class="form-select select2" data-placeholder="Selecciona la universidad de licenciatura">
                                            <?php
                                            foreach ($data_universidad as $universidad) {
                                                $selected_univ = ($ent_personas->getC_univ_licenciatura() == $universidad['c_universidad']) ? 'selected' : '';
                                                if ($selected_univ !== 'selected' && $is_user_col) {
                                                    continue;
                                                }
                                            ?>
                                                <option value="<?= $universidad['c_universidad']; ?>" <?= $selected_univ; ?>>
                                                    <?= $universidad['nombre']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="d-flex">
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Fecha Licenciatura</span>
                                        <input type="date" class="form-control" id="fecha_licenciatura" name="fecha_licenciatura" placeholder="" value="<?= $ent_personas->getFecha_licenciatura(); ?>" <?= $readonly ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12 text-center">
                            <?= bt_guardar('Actualizar'); ?>
                        </div>
                    </div>
                </form>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div><!-- end card -->
    </div>
</div>
<script>
    var validateForm = $('#frmFormRegistro').validate({
        rules: {
            apellido_materno: {
                required: () => {
                    return $('#pais_nacimiento').val() === '192';
                }
            }
        },
        messages: {},
        ignore: [],
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('.select2')); // después del select2 visible
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2').find('.select2-selection').addClass('is-invalid');
            } else {
                $(element).addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2').find('.select2-selection').removeClass('is-invalid');
            } else {
                $(element).removeClass('is-invalid');
            }
        }
    });

    $('select.form-select.select2').select2({
        width: 'resolve',
        dropdownAutoWidth: true,
        dropdownParent: $('.container-form-registro'),
        placeholder: $(this).data('placeholder'),
        language: {
            noResults: function() {
                return "No hay resultados";
            }
        }
    });

    $('#pais_nacimiento').on('select2:select', function(e) {
        var data = e.params.data;
        if (data.id !== "192") {
            return $('#ubigeonac').prop('disabled', !0);
        }
        $('#ubigeonac').prop('disabled', !1);

    });

    $('select.form-select.select2').on('select2:select', function(e) {
        validateForm.form();
    });
</script>