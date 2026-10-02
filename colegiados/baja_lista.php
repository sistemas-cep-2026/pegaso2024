<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_personas_suspendidas.php");
require_once(u_src() . "bo/bo_gen_personas_baja_control.php");

$bo_personas = new bo_gen_personas();
$bo_personas_baja = new bo_gen_personas_suspendidas();
$bo_personas_baja_control = new bo_gen_personas_baja_control();

$ent_personas = new gen_personas();
$ent_personas_baja = new gen_personas_suspendidas();
$ent_personas_baja_control = new gen_personas_baja_control();

$c_persona = s_crypt($_REQUEST["c_persona"] ?? '', 'out');
if (empty($c_persona)) {
    echo errors("No se ha seleccionado un colegiado");
    exit;
}

$ent_personas->setC_persona($c_persona);
$data_per = $bo_personas->listarID($ent_personas);
foreach ($data_per as $row) {

    $apaterno = $row['apellido_paterno'];
    $amaterno = $row['apellido_materno'];
    $nombre1 = $row['nombre1'];
    $nombre2 = $row['nombre2'];
    $nombre_completo = $row['nombre_completo'];
    $cep = $row['c_cmp'];
    $cod_documento_text = $row['cod_documento_text'];
    $cr_text = $row['c_local_text'];
    $num_documento = $row['num_documento'];
    $direc = $row['tipo_direccion'];
    $abono_favor = $row['abono_favor'];
    $flag_habil_text = $row['flag_habil_text'];
    $celular = $row['celular1'];
    $correo = $row['email1'];
    $fecha_de_nacimiento = $row['fecha_de_nacimiento'];
    $cod_sexo_text = $row['cod_sexo_text'];
    $c_e_civil_text = $row['c_e_civil_text'];
    $grupo_sanguineo_text = $row['grupo_sanguineo_text'];
    $c_local_textcol = $row['c_local_textcol'];
    $fecha_de_inicio = $row['fecha_de_inicio'];
    $n_folio_cole = $row['n_folio_cole'];
    $n_libro_cole = $row['n_libro_cole'];
    $n_resolucion_cole = $row['n_resolucion_cole'];
    $flag_activo_text = $row['flag_activo_text'];
    $fecha_de_cese = $row['fecha_de_cese'];
    $uni_bachiller = $row['uni_bachiller'];
    $fecha_de_vachiller = $row['fecha_de_vachiller'];
    $ub_nacimiento = $row['ub_nacimiento'];
    $ub_actual = $row['ub_actual'];
}
$abono_color = ($abono_favor > 0) ? "text-danger" : "text-success";
$foto = buscarFoto($num_documento);

?>
<div class="row g-4">
    <div class="col-auto">
        <div class="avatar-lg">
            <img src="<?= $foto ?>" alt="user-img" class="img-fluid rounded float-start" />
        </div>
    </div>
    <!--end col-->
    <div class="col">
        <div class="p-2">
            <h3 class="mb-1"><?= $cep; ?> - <?= $nombre_completo; ?></h3>
            <p class="text-opacity-75"><?= $cod_documento_text ?>: <?= $num_documento ?></p>
            <p class="text-opacity-75"><?= $cr_text ?></p>
            <div class="hstack 50 gap-1">
                <div class="me-2">
                    <span class="mt-2"><i class="fa fa-location-dot me-1 text-opacity-75 fs-16 align-middle"></i>Dirección: <?= $direc ?></span><br>
                    <span class="mt-2"><i class="fa fa-envelope me-1 text-opacity-75 fs-16 align-middle"></i>Correo: <?= $correo ?></span><br>
                    <span class="mt-2"><i class="fa fa-phone me-1 text-opacity-75 fs-16 align-middle"></i>Telefono: <?= $celular ?><span>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-12 col-lg-auto order-last order-lg-0">
        <div class="row text 50 text-center">
            <div>
                <div>
                    <h4 class="mb-1 <?= $abono_color; ?>"><?= 'S/' . decimal_millar($abono_favor, '2') ?></h4>
                </div><br>
                <div>
                    <h4 class="mb-1 "><?= $flag_habil_text ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-12">
        <?php
        /* if ($abono_favor > 0) {
            echo errors("El colegiado tiene un deuda pendiente por lo que se recomienda no continuar con el proceso de baja hasta que se regularice.");
        } */
        $ent_personas_baja->setC_persona($c_persona);
        $data_persona_baja = $bo_personas_baja->listarXPersona($ent_personas_baja);
        //print_r($data_persona_baja);
        if (empty($data_persona_baja)) {
            errors("Aun no hay registro");
        ?>
            <div class="text-center">
                <button class="btn btn-primary" type="button" onclick="fn_inicioBajaCEP({c_persona: '<?= s_crypt($c_persona) ?>', opc: '<?= s_crypt('I') ?>'})"><i class="fa-solid fa-person-arrow-down-to-line"></i> INICIAR REGISTRO DE BAJA</button>
            </div>
        <?php
        } else {
        ?>
            <h4>Estado de tramite</h4>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $arr_estado = [
                                    'T' => 'EN REVISION',
                                    'R' => 'RECHAZADO',
                                    'A' => 'ACEPTADO',
                                    'P' => 'COMPLETADO',
                                ];

                                $arr_estado_color = [
                                    'T' => 'secondary',
                                    'R' => 'danger',
                                    'A' => 'success',
                                    'P' => 'info',
                                ];

                                foreach ($data_persona_baja as $row) {
                                    $cc_psuspendidas = $row['cc_psuspendidas'];
                                    $flag_activo = $row['flag_activo'];
                                }

                                $ent_personas_baja_control->setCc_baja($cc_psuspendidas);
                                $data_persona_baja_control = $bo_personas_baja_control->listarXCcBaja($ent_personas_baja_control);

                                foreach ($data_persona_baja_control as $row) {
                                    $cc_psuspendidas_ctrl = $row['cc_baja_ctrl'];
                                    $flag = $row['flag'];
                                    $obs = $row['obs'];
                                    $fecha_crea = $row['fecha_crea'];
                                    $user_crea = $row['user_crea'];
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $fecha_crea ?></td>
                                        <td><?= u_estado($arr_estado[$flag], $arr_estado_color[$flag]) ?></td>
                                        <td><?= $obs ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <?php
                        if ($flag_activo !== 'D') {
                        ?>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="fn_abrirProcesoBaja({cc_psuspendidas: '<?= s_crypt($cc_psuspendidas) ?>',c_persona: '<?= s_crypt($c_persona) ?>', flag: '<?= s_crypt('P') ?>'})"><i class="fa fa-circle-arrow-down"></i> ¡PROCESAR BAJA DEFINITIVA!</button>
                                <button class="btn btn-success" onclick="fn_agregarRegistro({cc_psuspendidas: '<?= s_crypt($cc_psuspendidas) ?>',c_persona: '<?= s_crypt($c_persona) ?>', flag: '<?= s_crypt('A') ?>'})"><i class="fa fa-check"></i> Aceptar</button>
                                <button class="btn btn-danger" onclick="fn_agregarRegistro({cc_psuspendidas: '<?= s_crypt($cc_psuspendidas) ?>',c_persona: '<?= s_crypt($c_persona) ?>', flag: '<?= s_crypt('R') ?>'})"><i class="fa fa-times"></i> Rechazar</button>
                                <a class="btn btn-outline-warning" href="<?= url('images/document/FORMATO-RENUNCIA-CEP.pdf') ?>" target="_blank"><i class="fa fa-print"></i> Imprimir formato</a>
                                <!-- <a class="btn btn-outline-info" href="<?= url('colegiados/baja_print') ?>" target="_blank"><i class="fa fa-print"></i> Imprimir ficha</a> -->
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>