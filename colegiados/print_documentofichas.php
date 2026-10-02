<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_web_tram_colegiacion.php");
require_once(u_src() . "bo/bo_general.php");
require_once u_src() . 'bo/bo_web_tram_colegiacion_doc.php';

$c_persona = $_REQUEST["c_persona"];
$num_documento = $_REQUEST["num_documento"];
$cep = $_REQUEST["cep"] ?? $c_persona;
$c_persona = $_REQUEST["num_documento"] ?? $c_persona;

$bo_colegiado = new bo_web_tram_colegiacion();
$bo_general = new bo_general();
$bo_colegiacion_doc = new bo_web_tram_colegiacion_doc();

$ent_colegiado = new web_tram_colegiacion();
$ent_colegiado_doc = new web_tram_colegiacion_doc();

$ent_colegiado->setNum_documento($c_persona);
$dato_personales = $bo_colegiado->reportFicha($ent_colegiado);

foreach ($dato_personales as $row) {
    $region = $row["c_region"];
    $cod_doc = $row["cod_documentocod"];
    $ent_colegiado->setC_persona($row["c_persona"]);
    $ent_colegiado->setCol_fecha($row["col_fecha"]);
    $ent_colegiado->setC_region($row["c_local"]);
    $ent_colegiado->setC_cmp($row["c_cmp"]);
    $ent_colegiado->setNombre1($row["nombre_completo"]);
    $ent_colegiado->setCod_documento($row["cod_documento"]);
    $ent_colegiado->setNum_documento($row["num_documento"]);
    $ent_colegiado->setC_pais($row["pais"]);
    $ent_colegiado->setEmail($row["Email"]);
    $ent_colegiado->setCelular($row["celular"]);
    $ent_colegiado->setTelefono($row["telefono"]);
    $ent_colegiado->setGenero($row["genero"]);
    $ent_colegiado->setFecha_de_nacimiento($row["fecha_de_nacimiento"]);
    $ent_colegiado->setUbigeonac($row["LugarNacimiento"]);
    $ent_colegiado->setEstado_civil($row["estado_civil"]);
    $ent_colegiado->setGrupo_sanguineo($row["sangre"]);
    $ent_colegiado->setUbigeodirec($row["LugarResidencia"]);
    $ent_colegiado->setDireccion($row["direccion"]);
    $ent_colegiado->setProf_titulo($row["prof_titulo"]);
    $ent_colegiado->setProf_fecha($row["prof_fecha"]);
    $ent_colegiado->setProf_c_universidad($row["prof_universidad"]);
    $ent_colegiado->setProf_c_pais($row["prof_pais"]);
    $ent_colegiado->setProf_sunedu($row["prof_sunedu"]);
    $ent_colegiado->setBach_c_universidad($row["bach_universidad"]);
    $ent_colegiado->setBach_fecha($row["bach_fecha"]);
    $ent_colegiado->setBach_c_pais($row["bach_pais"]);
    $ent_colegiado->setBach_forma($row["bach_forma"]);
    $ent_colegiado->setBach_nombre($row["bach_nombre"]);
    $ent_colegiado->setDP_obs($row["DP_obs"]);
    $ent_colegiado->setEstado($row["estado"]);
    $ent_colegiado->setFoto($row["foto"]);
    $ent_colegiado->setProf_modingreso($row["prof_modingreso"]);
    $ent_colegiado->setProf_sede($row["prof_sede"]);
    $ent_colegiado->setProf_duracion($row["prof_duracion"]);
    $ent_colegiado->setProf_exa_suf($row["prof_exa_suf"]);
    $cod_bancario = $row["cod_bancario"];
    $c_local = $row["c_region"];
    $num_documento = $row["num_documento"];
    $fecha_inicio = $row["fecha_inicio"];
}
$distrito = $bo_general->RegionID($region);

foreach ($distrito as $ros) {
    $lugar = $ros["distrito"];
}

$data_region = $bo_general->RegionID($c_local); /* * *direccion */
foreach ($data_region as $re) {
    $cr = $re["nombre"];
    $dir = $re["local_direc"];
    $tel = $re["local_tel"];
    $email = $re["local_mail"];
}
$urlfoto = "http://200.37.231.67/fichas/";

$foto = $urlfoto . rtrim($num_documento) . ".jpg";
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $cep; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= url('css/print.css'); ?>" />
    <style>
        .table-sm>:not(caption)>*>* {
            padding: 0.14rem .21rem !important;
        }
    </style>
</head>

<body class="bg-dark my-2">
    <div class="page bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <td class="col-2 align-middle text-start">
                    <a href="#"><img src="<?= url('images/logo_print.jpg'); ?>" alt="Clic para imprimir"
                            width="100" /></a>
                </td>
                <td class="col-8 text-center align-middle fs-6">
                    <b>COLEGIO DE ENFERMEROS DELPER&Uacute;<br>
                        DECRETO DE LEY N&ordm; 22315<br>
                        FICHA UNICA DE INSCRIPCI&Oacute;N<br>
                        CONSEJO REGIONAL <?= $ent_colegiado->getC_region(); ?></b>
                </td>
                <td class="col-2 align-middle text-end"><img alt="image" src="<?= $foto ?>" width="90" /></td>
            </tr>
        </table>
        <hr size="1">
        <table class="table table-sm table-borderless fs-6">
            <tr>
                <td colspan="3">- DATOS PERSONALES </td>
            </tr>
            <tr>
                <td colspan="2">Nombres : <?= $ent_colegiado->getNombre1() ?></td>
                <td><?= $ent_colegiado->getCod_documento() . " : " . $ent_colegiado->getNum_documento() ?></td>
            </tr>
            <tr>
                <td>Fecha de Nac. : <?= $ent_colegiado->getFecha_de_nacimiento() ?></td>
                <td>Estado Civil :
                    <?= $ent_colegiado->getEstado_civil()
                    ?>
                </td>
                <td>G&eacute;nero :
                    <?= $ent_colegiado->getGenero()
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">Lugar de Nac.:
                    <?php
                    echo trim($ent_colegiado->getC_pais());

                    if (trim($ent_colegiado->getC_pais()) == "PERU") {
                        echo " - " . $ent_colegiado->getUbigeonac();
                    } else {
                        echo " (EXTRANJERO)";
                    };
                    ?>
                </td>
            </tr>
            <tr>
                <td>Tel. : <?= $ent_colegiado->getTelefono() . "/" . $ent_colegiado->getCelular() ?></td>
                <td>E-mail: <?= $ent_colegiado->getEmail() ?></td>
                <td>Sangre : <?= $ent_colegiado->getGrupo_sanguineo() ?></td>
            </tr>
            <tr>
                <td colspan="3">Direcci&oacute;n: <?= $ent_colegiado->getDireccion() ?></td>
            </tr>
            <tr>
                <td colspan="3"><?= $ent_colegiado->getUbigeodirec() ?></td>
            </tr>
            <tr>
                <td colspan="3">- DATOS PROFESIONALES</td>
            </tr>
            <tr>
                <td>T&iacute;tulo Profesional : <?= $ent_colegiado->getProf_titulo() ?></td>
                <td colspan="2">Fecha de Exp. : <?= $ent_colegiado->getProf_fecha() ?></td>
            </tr>
            <tr>
                <td colspan="3">Instituci&oacute;n :
                    <?= $ent_colegiado->getProf_c_universidad() ?>
                </td>
            </tr>
            <tr>
                <td>Registro SUNEDU : <?= $ent_colegiado->getProf_sunedu() ?></td>
                <td colspan="2">Pa&iacute;s : <?= $ent_colegiado->getProf_c_pais() ?></td>
            </tr>

            <?php if ($cod_doc == "DI") { ?>

                <tr>
                    <td colspan="3">Sede del Internado : <?= $ent_colegiado->getProf_sede() ?></td>
                </tr>
                <tr>
                    <td colspan="3">Duraci&oacute;n : <?= $ent_colegiado->getProf_duracion() . " Meses" ?></td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="3">Examen de suficiencia : <?= $ent_colegiado->getProf_exa_suf() ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3">- BACHILLERATO</td>
            </tr>
            <tr>
                <td colspan="2">Instituci&oacute;n : <?= $ent_colegiado->getBach_c_universidad() ?></td>
                <td>Pa&iacute;s : <?= $ent_colegiado->getBach_c_pais() ?></td>
            </tr>
            <tr>
                <td>Fecha de Expedici&oacute;n : <?= $ent_colegiado->getBach_fecha() ?></td>
                <td colspan="2">Forma : <?= $ent_colegiado->getBach_forma() ?></td>
            </tr>
            <tr>
                <td colspan="3">Modalidad : <?= $ent_colegiado->getProf_modingreso() ?></td>

            </tr>
        </table>
        <hr size="1">
        <table class="table table-sm table-borderless fs-6">
            <tr>
                <td colspan="3">- COMPROMISO DE HONOR</td>
            </tr>
            <tr>
                <td colspan="3" align="justify">Yo,&nbsp;<strong><?= $ent_colegiado->getNombre1() ?></strong>
                    enfermera(o) declaro bajo juramento tener pleno conocimiento de la Ley, Estatuto Reglamento y
                    C&oacute;digo de &Eacute;tica y Deontolog&iacute;a del Colegio de Enfermeros del Per&uacute; y me
                    comprometo a cumplir a cabalidad las disposiciones en ellas establecidas y las resoluciones que
                    emanen del Consejo Nacional.<br>
                    As&iacute; mismo, declaro conocer que me har&eacute; acreedor a las sanciones correspondientes en
                    caso de infracci&oacute;n. En f&eacute; de lo expuesto, firmo el presente Compromiso del Colegiado.
                </td>
            </tr>
            <tr>
                <td width="16%">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="39%">&nbsp;</td>
                <td width="45%" align="center"><br /> <?= $ent_colegiado->getNombre1() ?><br>
                    </strong></td>
            </tr>

            <tr>
                <td colspan="3">
                    <hr size="1">
                </td>
            </tr>
            <!-- <tr>
                <td  colspan="3">- DICTAMEN</td>
            </tr>
            <tr>
                <td colspan="3" align="justify">Visto los documentos presentados por la(el) Enfermera(o)
                    &nbsp;<strong><?= ''; //$ent_colegiado->getNombre1() 
                                    ?></strong> en cumplimiento del
                    Art&iacute;culo 8&ordm; Cap. I, T&iacute;tulo II del Reglamento del Colegio y de la Directiva
                    N&ordm; 002 del Consejo Nacional sobre el proceso de Colegiaci&oacute;n y estando conforme con las
                    normas y requisitos establecidos para tal fin, el Consejo Regional&nbsp;<strong><?= ''; //$ent_colegiado->getC_region();
                                                                                                    ?>&nbsp;</strong>Considera procedente el tr&aacute;mite correspondiente ante el Consejo Nacional
                    del
                    Colegio de Enfermeros del Per&uacute;.</td>
            </tr> -->
        </table>
        <table class="table table-sm table-borderless fs-6">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="right"><?= $lugar ?>, <?= fechatexto($fecha_inicio) ?><br>
                    Consejo Regional : <?= $ent_colegiado->getC_region(); ?> </td>
            </tr>
        </table>
    </div>
    <div class="page bg-white">
        <?php
        $ent_colegiado_doc->setC_persona($num_documento);
        $data_doc = $bo_colegiacion_doc->listarFotos($ent_colegiado_doc);
        $tipo_ = lista_tipo_documentos_archivos();
        $i = 1;
        foreach ($data_doc as $fot) {
        ?>
            <div class="container">
                <?php foreach ($tipo_ as $key => $index) {
                    if ($fot["tipo"] == $key) {
                        echo "<h2>" . $i . ".-" . $index . "</h2>";
                    };
                } ?>
                <div class="text-center ">
                    <img src="<?= $urlfoto . rtrim($fot["archivo"]) . ".jpg" ?>" style="max-width: 100%;"
                        alt="<?= $fot["tipo"]; ?>">
                </div>
            </div>
        <?php $i++;
        } ?>
    </div>
    <script>
        window.addEventListener("contextmenu", function(event) {
            event.preventDefault();
        });
        window.addEventListener("keydown", function(event) {
            if (event.ctrlKey && event.key === "p") {
                event.preventDefault();
                alert("La impresión está deshabilitada en esta página.");
            }
            if (event.metaKey && event.key === "p") { // Para Mac (Cmd + P)
                event.preventDefault();
                alert("La impresión está deshabilitada en esta página.");
            }
        });
        window.addEventListener("load", function(event) {
            window.print();
        });
        window.addEventListener("afterprint", (event) => {
            window.close();
        });
    </script>
</body>

</html>