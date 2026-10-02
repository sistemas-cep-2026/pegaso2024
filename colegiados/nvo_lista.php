<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_gen_personas.php");
require_once u_src() . 'bo/bo_web_tram_colegiacion.php';
require_once u_src() . 'bo/bo_web_tram_colegiacion_doc.php';
require_once(u_src() . "bo/bo_web_tram_colegiacion_control.php");

$bo_persona = new bo_gen_personas();
$bo_colegiacion = new bo_web_tram_colegiacion();
$bo_colegiacion_doc = new bo_web_tram_colegiacion_doc();
$bo_web_tram_colegiacion_cont = new bo_web_tram_colegiacion_control();

$ent_colegiacion = new web_tram_colegiacion();
$ent_colegiacion_doc = new web_tram_colegiacion_doc();
$ent_web_tram_colegiacion_cont = new web_tram_colegiacion_control();

$c_persona = s_crypt($_REQUEST["c_persona"], 'out');
$cep = $_REQUEST["cep"];
$num_documento = $_REQUEST["num_documento"];
$nombres = $_REQUEST["nombres"] ?? '';
$nombre = $_REQUEST["nombre"];
$cr_texto = $_REQUEST["cr_text"] ?? '';
$c_local = s_local();

if (!empty($cep)) {
?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-5 py-2" role="alert">
                <i class="fa fa-user-check fa-2x label-icon"></i><strong>Este registro ya tiene CEP</strong> <b><?= "[ $cep - $nombre ]" ?></b>
                <a class=" fs-5 btn btn-sm rounded-pill btn-soft-success waves-effect waves-light material-shadow-none" role="button" href="<?= url('colegiados/print_documentocol.php?c_persona=' . $num_documento . '&cep=' . $cep); ?>" target="_blank">
                    <i class="mr-2 fa fa-cloud"></i> Imprimir ficha
                </a>
            </div>
        </div>
    </div>
<?php
    exit;
}
$data_cep = $bo_persona->ultimoCMP();
foreach ($data_cep as $cep) {
    $cepc = $cep["cmp"];
}

$ent_colegiacion->setNum_documento($num_documento);
$data_recaudoxds = $bo_colegiacion->PersonaIDdni_nuevocol_recaudox($ent_colegiacion);

$foto = "https://www.cep.org.pe/colegiacion/imag/fotos/" . $num_documento . ".jpg";

?>
<br />
<div class="row">
    <div class="col-lg-4">
        <?php
        /*******************REGIONAL******************** */
        $ent_web_tram_colegiacion_cont->setC_persona($num_documento);
        $data_control = $bo_web_tram_colegiacion_cont->ListarEstado($ent_web_tram_colegiacion_cont);

        $data_cr = array_filter($data_control, function ($item) {
            return $item['codigo'] === 'CR';
        });

        $data_cn = array_filter($data_control, function ($item) {
            return $item['codigo'] === 'CN';
        });

        foreach ($data_cr as $cr) {
            $detallecr = $cr["detalle"];
            $estado_cr_control = empty($cr["estado"]) ? 'P' : $cr["estado"];
            $fecha_cr = $cr["fecha"];
        }

        foreach ($data_cn as $cn) {
            $fecha_cn = $cn["fecha"];
        }


        /*******************REGIONAL******************** */

        $arr_estado_cr_control = [
            'P' => [
                'icono' => 'fa-clock',
                'color' => 'alert-dark',
                'mensaje' => 'En espera de recepción y/o evaluacion',
            ],
            'R' => [
                'icono' => 'fa-times',
                'color' => 'alert-danger',
                'mensaje' => 'Documento rechazado por el CDN el ' . $fecha_cn
            ],
            'A' => [
                'icono' => 'fa-check',
                'color' => 'alert-success',
                'mensaje' => 'Fecha aprobación: ' . $fecha_cr
            ]
        ];

        $data_historial = $bo_colegiacion->listarHistorialXNumDocumento($ent_colegiacion);
        $nombre_historial = $data_historial[0];
        ?>
        <div class="row p-1">
            <div class="col-xl-12">
                <div class="mx-2 alert <?= $arr_estado_cr_control[$estado_cr_control]['color'] ?> alert-label-icon rounded-label fade show material-shadow" role="alert">
					<i class="mr-2 fa <?= $arr_estado_cr_control[$estado_cr_control]['icono'] ?> label-icon"></i>
					<b class="fs-5"><?= $cr_texto; ?></b><br>
					<span><strong><?= $arr_estado_cr_control[$estado_cr_control]['mensaje']; ?></strong></span>
				</div>
            </div>
            <div class="col-xl-12">
                <?php
                if (empty($data_recaudoxds[0]['bcp1']) && empty($data_recaudoxds[0]['bbva1'])) {
                    echo errors("FALTA PAGO DE RECAUDO (BCP O BBVA).");
                } else {
                ?>
                    <div class="mx-2 alert alert-success alert-border-left fade show material-shadow" role="alert">
                        <div class="alert-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <i class="ri-check-double-line fa-2x align-middle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="alert-heading">Pago Recaudo</h5>
                                    <?php
                                    foreach ($data_recaudoxds as $reca) {
                                    ?>
                                        <p class="mb-0"><?= $reca["bcp1"]; ?></p>
                                        <p class="mb-0"><?= $reca["bbva1"]; ?></p>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="accordion accordion-flush" id="accordionHistorialaPadre">
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button p-1 caret-off bg-white border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-historial" aria-expanded="false" aria-controls="flush-historial">
                        <span class="btn btn-ghost-info"><i class="fa fa-search align-middle"></i> Historial del colegiado <i class="fa fa-caret-down align-middle"></i></span>
                    </button>
                </h2>
                <div id="flush-historial" class="accordion-collapse collapse" data-bs-parent="#accordionHistorialaPadre">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-condensed">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Fase</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Observaci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_historial as $historial) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo $historial['fecha']; ?></td>
                                            <td><?php echo $historial['fase']; ?></td>
                                            <td><?php echo $historial['c_usuario']; ?></td>
                                            <td><?php echo $historial['detalle']; ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<hr>
<div class="row p-1">
    <div class="col-lg-3 p-3">
        <div class="sticky-top pt-3" style="top: 4.5rem; z-index: 0!important;">
            <form id="frmRegistroNuevoCEP" action="javascript:fn_procesarNuevoCEP();" method="post">
                <input name="c_persona" type="hidden" value="<?= s_crypt($c_persona) ?>" />
                <div class="row mb-2">
                    <div class="col-md-12 text-center">
                        <img loading="lazy" src="<?= $foto ?>" class="rounded img-fluid material-shadow" width="150" onerror="this.onerror=null; this.src='images/sinfoto.jpg';">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="num_documento" class="form-label">Documento de identidad:</label>
                        <input type="text" id="num_documento" class="form-control" name="num_documento" value="<?= $num_documento ?>" readonly />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label">Apellidos y nombres:</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" value="<?= $nombre ?>" readonly />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="cep" class="form-label">Nuevo N° CEP:</label>
                        <input type="text" name="cep" id="cep" placeholder="000000" class="form-control" value="<?= $cepc ?>" readonly />
                        <input name="c_cmp" id="c_cmp" type="hidden" value="<?= $cepc ?>" />
                    </div>
                </div>
                <div class="row mb-2">

                    <div class="col-md-12">
                        <label for="fecha_de_inicio" class="form-label">Fecha colegiatura:</label>
                        <input type="text" id="fecha_de_inicio" class="form-control" name="fecha_de_inicio" value="<?= date('d/m/Y') ?>" readonly />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 d-flex align-self-end">
                        <?php echo input_checkbox('Regularización', 'regularizado', 1) ?>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 text-center">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check fa-lg"></i> PROCESAR N° CEP</button>
                            <button type="button" onclick="fn_procesarShow({c_persona:'<?= s_crypt($num_documento) ?>', codigo:'CN', estado:'R'});" class="btn btn-outline-danger">
                                <i class="mr-2 fa fa-times"></i> Rechazar
                            </button>
                            <a href="<?= url('colegiados/print_documentocol?c_persona=' . $num_documento); ?>" target="_blank" class="btn btn-outline-info">
                                <i class="mr-2 fa fa-print"></i> Imprimir
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
    <div class="col-lg-9 p-3">
        <h2 id="documentacion">Documentaci&oacute;n</h2>
        <div id="divListarPersonas" class="row">
            <div class="col-lg-12">
                <?php
                $ent_colegiacion_doc->setC_persona($num_documento);
                $data_doc = $bo_colegiacion_doc->listarFotos($ent_colegiacion_doc);
                $tipo_ = lista_tipo_documentos_archivos();
                $i = 1;
                $dir_foto = 'https://www.cep.org.pe/colegiacion/imag/fotos/';
                foreach ($data_doc as $fot) { ?>
                    <div class="col-sm-12 text-center">
                        <?php foreach ($tipo_ as $key => $index) {
                            if ($fot["tipo"] == $key) {
                                echo "<br><h3>" . $i . ".-" . $index . "</h3>";
                            };
                        } ?>
                        <img loading="lazy" src="<?= $dir_foto . trim($fot['archivo']) . '.jpg' ?>" class="img-thumbnail" alt="Responsive image"><br>
                    </div>
                <?php  } ?>
            </div>
            <div class="col-lg-12 text-center mt-2">
                <button class="btn btn-secondary" id="buttonScrollToForm"><i class="fa fa-arrow-up"></i> Subir al principio</button>
            </div>
        </div>
    </div>
</div>
<script>
    var btnScrollToForm = document.getElementById('buttonScrollToForm');
    btnScrollToForm.onclick = function() {
        document.getElementById('documentacion').scrollIntoView({
            behavior: 'smooth'
        });
    };
</script>