<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_personas_exoneraciones.php");

$bo_personas = new bo_gen_personas();
$bo_personas_exo = new bo_gen_personas_exoneraciones();
$ent_personas = new gen_personas();
$ent_personas_exo = new gen_personas_exoneraciones();

$cc_persona = s_crypt($_REQUEST["cc_persona"], 'out');

if (empty($cc_persona)) { echo "Seleccione persona"; exit;}

$ent_personas->setCc_persona($cc_persona);
$ent_personas_exo->setC_persona($cc_persona);

$data_exoneraciones = $bo_personas_exo->listarIDXPersona($ent_personas_exo);
$data_personas = $bo_personas->listarShowID($cc_persona);
foreach ($data_personas as $per) {
    $cod_documento = $per["cod_documento"];
    $num_documento = $per["num_documento"];
    $nombre = $per["nombre_completo"];
    $cep = $per["c_cmp"];
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
 


?>
<div id="container_pagos_historial">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">HISTORIAL DE EXONERACIONES REGISTRADAS</h4>
            <div class="d-flex align-items-center">
                <div class="p-1 flex-shrink-1 align-self-center"><img src="<?= url('images/logo_print.jpg'); ?>" width="80" /></div>
                <div class="p-1 flex-fill">
                    <div class="row p-0">
                        <div class="col-sm-5">
                            <ul class="list-group list-group-flush small-list" style="font-size: .775rem!important;">
                                <li class="list-group-item py-1 border-0">CEP : <b><?= $cep ?></b></li>
                                <li class="list-group-item py-1 border-0">DOC : <b><?= $cod_documento . " => " . $num_documento ?></b></li>
                                <li class="list-group-item py-1 border-0">NOMBRE : <b><?= $nombre ?></b> </li>

                            </ul>
                        </div>
                        <div class="col-sm-5">
                            <ul class="list-group list-group-flush small-list" style="font-size: .775rem!important;">
                                <li class="list-group-item py-1 border-0">CR: <b><?= $c_local_texto ?> </b></li>
                                <li class="list-group-item py-1 border-0">ENTIDAD : <b><?= $ent_pagadora ?></b></li>
                                <li class="list-group-item py-1 border-0">ESTADO : <b class="fs-6 <?= ($habil == 'H') ? 'badge bg-success' : 'badge bg-danger'; ?>"><?= $habil_text . " => " . $abono_favor . " [ " . $estado . " ]"  ?></b></li>
                            </ul>
                        </div>
                        <div class="col-sm-2 text-end">
                            <button class="btn btn-success" type="button" title="Nueva Exoneración" onclick="fn_nuevaExoneracion('<?= $cc_persona ?>','I')"><i class="fa fa-plus"></i> Nueva Exoneración</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="table_exoneracion">
                    <thead>
                        <tr class="table-active">
                            <th>#</th>
                            <th>TIPO</th>
                            <th>PAIS</th>
                            <th>FECHA</th>
                            <th>SUSTENTO</th>
                            <th>USUARIO</th>
                            <th>DESDE</th>
                            <th>HASTA</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1;
                        foreach ($data_exoneraciones as $row) {
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $row["motivo_text"]; ?></td>
                                <td><?= $row["n_pais"]; ?></td>
                                <td><?= $row["fecha"]; ?></td>
                                <td><?= $row["sustento"]; ?></td>
                                <td><?= $row["usuario"]; ?></td>
                                <td><?= $row["mes_salida"] . "-" . $row["year_salida"]; ?></td>
                                <td><?php if ($row["flag_no_retorno"] == '&') {
                                        echo $row["mes_retorno"] . "-" . $row["year_retorno"];
                                    } else {
                                        echo "**Sin Retorno**";
                                    } ?></td>
                            </tr>
                        <?php $i++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
