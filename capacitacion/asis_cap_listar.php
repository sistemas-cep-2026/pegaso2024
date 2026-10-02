<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_cap_eventos_asistencia.php");

$bo_personas = new bo_gen_personas();
$bo_asistencias = new bo_cap_eventos_asistencia();

$ent_personas = new gen_personas();
$ent_asistencias = new cap_eventos_asistencia();

$cc_persona = s_crypt($_REQUEST['c_persona'], 'out');
$cc_evento = $_REQUEST['cc_evento'];
$fecha = $_REQUEST['fecha'];

$data_deudax = $bo_personas->Actualiza_deuda($cc_persona);
$cep = 0;
$data_persona = $bo_personas->listarShowID($cc_persona);
foreach ($data_persona as $per) {
    $cod_documento = $per["cod_documento"];
    $num_documento = $per["num_documento"];
    $nombre = $per["nombre_completo"];
    $cep = (int)($per["c_cmp"] ?? 0);
    $habil = $per["flag_habil"];
    $habil_text = $per["flag_habil_text"];
    $correo = $per["Email1"];
    $celular = $per["celular1"];
    $fecha_colegiacion = $per["fecha_colegiacion"];
    $fecha_nacimiento = $per["fecha_nacimiento"];
    $ent_pagadora = $per["ent_pagadora"];
    $estado = $per["flag_activo_text"];
    $c_local_texto = $per["c_local_text"];
    $edad = $per["edad"];
    $edad_meses = $per["edad_meses"];
    $abono_favor = $per["abono_favor"];
    $cc_persona = $per["c_persona"];
}
$data_asistencia = $bo_asistencias->registrados();
$ent_asistencias->setC_persona($cc_persona);
$ent_asistencias->setCc_evento($cc_evento);
$ent_asistencias->setFech_crea($fecha);
$data_existe = $bo_asistencias->validar($ent_asistencias)

?>
<div id="print-section" class="print-section">
    <div class="row p-0">
        <div class="col-md-11">
            <div class="row p-0 ">
                <div class="col-md-4">
                    <?php if ($cep > 0) { ?>
                        <ul class="list-group list-group-flush small-list">
                            <li class="list-group-item py-1 border-0"><i class="ri-file-list-line"></i> CEP : <strong class="fs-5"><?php echo $cep . " =>" . $num_documento ?></strong></li>
                            <li class="list-group-item py-1 border-0"><i class="ri-user-line"></i> Nombre : <strong class="fs-5"><?php echo $nombre ?></strong> </li>
                            <li class="list-group-item py-1 border-0"><i class="ri-award-line"></i> Correo : <strong><?php echo $correo . " Cel:" . $celular ?></strong></li>
                        </ul>
                    <?php } else { ?>

                        <div class="alert alert-warning text-center mb-0" role="alert">
                            <i class="ri-error-warning-line me-1"></i>
                            <strong>No es enfermero colegiado</strong>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <?php if ($cep > 0) { ?>
                        <ul class="list-group list-group-flush small-list">
                            <li class="list-group-item py-1 border-0"><strong><?php echo $c_local_texto ?> </strong></li>
                            <li class="list-group-item py-1 border-0">ESTADO : <strong class="fs-6 <?php echo ($habil == 'H') ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $habil_text . " => " . $abono_favor . " [ " . $estado . " ]"  ?></strong></li>
                            <li class="list-group-item py-1 border-0">FECHA NAC. : <strong><?php echo $fecha_nacimiento . " [ " . $edad . "A " . $edad_meses . "M ]" ?></strong></li>
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-md-4 text-center mx-auto">
                    <h2>
                        Asistente N° :
                        <span class="badge border border-primary text-primary"><?= $data_asistencia[0]['cantidad']; ?></span>
                    </h2>
                    <?php if ($data_existe[0]['existe'] == '1') { ?>
                        <div class="alert alert-danger material-shadow" role="alert">
                            <strong>Ya está registrado</strong>
                        </div>
                    <?php } ?>
                    <button type="button"
                        class="btn btn-outline-success waves-effect waves-light material-shadow-none"
                        onclick="fn_asistente('<?php echo s_crypt($cc_persona, 'in'); ?>','<?php echo s_crypt($cc_evento, 'in'); ?>','<?php echo s_crypt($fecha, 'in'); ?>','<?php echo s_crypt('I', 'in'); ?>')">
                        <i class="fas fa-user-check"></i> Asistir
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>