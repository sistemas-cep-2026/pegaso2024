<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_web_tram_colegiacion.php");
require_once u_src() . 'bo/bo_web_tram_colegiacion_doc.php';
require_once(u_src() . "bo/bo_web_tram_colegiacion_control.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_tram_colegiacion = new bo_web_tram_colegiacion();
$bo_colegiacion_doc = new bo_web_tram_colegiacion_doc();
$bo_web_tram_colegiacion_cont = new bo_web_tram_colegiacion_control();
$bo_personas = new bo_gen_personas();

$ent_tram_colegiacion = new web_tram_colegiacion();
$ent_colegiacion_doc = new web_tram_colegiacion_doc();
$ent_web_tram_colegiacion_cont = new web_tram_colegiacion_control();

$disabled = s_local() !== '28' ? 'disabled' : '';
$num_documento = $_REQUEST["num_documento"];

if (empty($num_documento)) {
    die(errors());
}
$fotoper = '';
$documento = '';
$ent_tram_colegiacion->setNum_documento($num_documento);

$data_coleg = $bo_tram_colegiacion->showNuevoColegiadoId($ent_tram_colegiacion);
foreach ($data_coleg as $row) {
    $c_persona = $row["c_persona"];
    $documento = $row["cod_documento_text"] . ":  " . $row["num_documento"];
    $num_documento = $row["num_documento"];
    $cr_texto = $row["nombre_region"];
    $pais = $row["pais_nacim"];
    $nombre_completo = $row["nombres"];
    $correo = $row["Email"];
    $celular = $row["celular"];
    $genero = $row["genero_text"];

    $direccion = $row["direccion"];
    $ubigeodirec = $row["ubigeodirec"];
    $ubigeonac = $row["ubigeonac"];
    $estado_civil = $row["estado_civil"];
    $grupo_sanguineo = $row["grupo_sanguineo"];
    $factor_sanguineo = $row["factor_sanguineo"];

    $fec_nac = $row["fec_nac"];
    $sunedu = $row["prof_sunedu"];
    $universidad = $row["univ_lic"];
    $lugar_nacimiento = $row["lugar_nacimiento"];
    $lugar_direccion = $row["lugar_direccion"];
    $direccion = $row["direccion"];
    $fecha_registro = $row["fecha_registro"];
    $cep = $row["cep"];
    $recaudo = $row["recaudo"];
}
//datos => 32 = 100%
//imagenes => 33 = 100%
//recaudo => 35 = 100%
$ent_colegiacion_doc->setC_persona($c_persona);
$data_doc = $bo_colegiacion_doc->listarFotos($ent_colegiacion_doc);

$dir_foto = "https://www.cep.org.pe/colegiacion/imag/fotos/";
$foto = $dir_foto . $num_documento . '.jpg';

$cant_datos = array_filter(array_values($data_coleg[0]), function ($item) {
    return !empty($item);
});

$cant_imagenes = (count($data_doc) + 20);
$cant_datos = (count($cant_datos) - 4);
$cant_recaudo = empty($recaudo) ? 0 : 35;

$cant_max = 100;
$cant_min = 36;
$cant_med = 70;

$cant_general = $cant_imagenes + $cant_datos + $cant_recaudo;
$porcentaje = ($cant_general / $cant_max) * 100;

$color = $porcentaje < $cant_min ? 'danger' : ($porcentaje < $cant_med ? 'warning' : 'success');
?>
<div class="modal-header">
    <h5 class="modal-title">Expediente de <?= $nombre_completo; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <hr>
</div>
<div class="modal-body">
    <?php
    if (!empty($cep)) {
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-5 py-2" role="alert">
                    <i class="fa fa-user-check fa-2x label-icon"></i><strong>Este registro ya tiene CEP</strong> <b><?= "[ $cep - $nombre_completo ]" ?></b>
                    <a class=" fs-5 btn btn-sm rounded-pill btn-soft-success waves-effect waves-light material-shadow-none" role="button" href="<?= url('colegiados/print_documentocol.php?c_persona=' . $num_documento . '&cep=' . $cep); ?>" target="_blank">
                        <i class="mr-2 fa fa-cloud"></i> Imprimir ficha
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card bg-light overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h6 class="mb-0"><b class="text-<?= $color; ?>"><?= decimal($porcentaje, 0) ?>%</b> Progreso del expediente completado</h6>
                        </div>
                    </div>
                </div>
                <div class="progress bg-<?= $color; ?>-subtle rounded-0">
                    <div class="progress-bar bg-<?= $color; ?>" role="progressbar" style="width: <?= decimal($porcentaje, 0) ?>%" aria-valuenow="<?= decimal($porcentaje, 0) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="divListarEstadosTramitado"><?= cargador(); ?></div>
    <hr>
    <div class="row p-1">
        <div class="col-12 p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img loading="lazy" onerror="this.onerror=null; this.src='images/sinfoto.jpg';" src="<?= $foto ?>" class="rounded img-fluid material-shadow" width="120">
                </div>
                <div class="flex-grow-1 ms-3 row fs-5">
                    <div class="row">

                        <div class="col-xl-6">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-25"><b>Nombre:</b> <?= $nombre_completo ?></li>
                                <li class="mb-25"><b><?= $documento ?></b></li>
                                <li class="mb-25"><b>Genero :</b> <?= $genero ?></li>
                                <li class="mb-25"><b>Pais:</b> <?= $pais ?></li>
                            </ul>
                        </div>
                        <div class="col-xl-6">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-25"><b>Fec. Nac.:</b> <?= $fec_nac ?></li>
                                <li class="mb-25"><b>Correo :</b> <?= $correo ?></li>
                                <li class="mb-25"><b>Celular:</b> <?= $celular ?></li>
                            </ul>
                        </div>
                        <div class="col-xl-12">
                            <ul class="list-unstyled">
                                <li class="mb-25"><b>Lugar nacimiento:</b> <?= $lugar_nacimiento ?></li>
                                <li class="mb-25"><b>Dirección:</b> <?= $direccion ?> (<?= $lugar_direccion ?>)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <?php
            if (empty($data_doc)) {
                echo errors("NO SE ENCONTRARON DOCUMENTOS ADJUNTOS.");
            } else {
                $i = 1;
                foreach ($data_doc as $fot) {
                    $tipo_ = lista_tipo_documentos_archivos();
            ?>
                    <div>
                        <?php
                        foreach ($tipo_ as $key => $index) {
                            if ($fot["tipo"] == $key) {
                                echo "<br><h1>" . $i . ".-" . $index . "</h1>";
                            };
                        }
                        ?>
                        <img loading="lazy" src="<?= $dir_foto . trim($fot['archivo']) . '.jpg' ?>" class="img-thumbnail" alt="<?= trim($fot['archivo']) ?>"><br>
                    </div>
            <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <hr>
    <?= bt_cerrar(); ?>
</div>
<script>
    listarEstadosTramitado({
        c_persona: '<?= s_crypt($c_persona) ?>',
        cr: '<?= $cr_texto ?>',
        cep:'<?= $cep ?>'
    });
</script>