<!DOCTYPE html>
<html>

<head>
    <title><?= $cep; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= url('css/print.css'); ?>?ver=<?= rand(1000000, 9999999) ?>" />
    <style>
        .table-sm>:not(caption)>*>* {
            padding: 0.14rem .21rem !important;
        }

        @media print {

        .page {
            margin: 0;
        }

            h4,
            h5,
            h6 {
                page-break-after: avoid;
            }

            @page {
                margin-top: 0.3in;
                margin-bottom: 0.3in;
                margin-left: 0.25in;
                margin-right: 0.25in;

                @top-left {
                    font-size: 0.45rem !important;
                    font-family: Arial, Helvetica, sans-serif;
                    content: '<?= date('d/m/y, H:i') ?>';
                }

                @top-center {
                    font-size: 0.45rem !important;
                    font-family: Arial, Helvetica, sans-serif;
                    content: 'FICHA UNICA DE INSCRIPCIÓN - COLEGIO DE ENFERMEROS DEL PERÚ';
                }

                @bottom-right {
                    font-size: 0.55rem !important;
                    font-family: Arial, Helvetica, sans-serif;
                    content: "Página " counter(page) " de " counter(pages);
                }

                /* @bottom-center {
      content: 'bottom';
      border-top: 3px solid red;
    } */
            }
        }
    </style>
</head>

<body class="my-2 bg-black">
    <div class="page bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <td class="col-2 align-middle text-start">
                    <a href="#"><img src="<?= url('images/logo_print.jpg'); ?>" alt="Clic para imprimir" width="100" onclick="window.print()" /></a>
                </td>
                <td class="col-8 text-center align-middle fs-6">
                    <b>COLEGIO DE ENFERMEROS DELPER&Uacute;<br>
                        DECRETO DE LEY N&ordm; 22315<br>
                        FICHA UNICA DE INSCRIPCI&Oacute;N<br>
                         <?= $region; ?></b>
                </td>
                <td class="col-2 align-middle text-end"><img alt="image" src="<?= $foto ?>" width="90" /></td>
            </tr>
        </table>
        <hr size="1">
        <table class="table table-sm table-borderless fs-6">
            <tr>
                <td colspan="3"><strong>DATOS PERSONALES</strong></td>
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
                <td>Tel. : <?= $ent_colegiado->getCelular() ?></td>
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
                <td colspan="3"><strong>DATOS PROFESIONALES</strong></td>
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
                <td colspan="3"><strong>BACHILLERATO</strong></td>
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
                <td colspan="3"><strong>COMPROMISO DE HONOR</strong></td>
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
                <td colspan="2" align="right"><?= trim($lugar) ?>, <?= fechatexto(date('d/m/Y')) ?><br>
                    Consejo Regional : <?= $region; ?> </td>
            </tr>
        </table>

        <div class="bg-white" id="container_fotos">
            <?php
            $ent_colegiado_doc->setC_persona($num_documento);
            $data_doc = $bo_colegiacion_doc->listarFotos($ent_colegiado_doc);
            $tipo_ = lista_tipo_documentos_archivos();
            $i = 1;
            foreach ($data_doc as $fot) {
            ?>
                <div>
                    <?php foreach ($tipo_ as $key => $index) {
                        if ($fot["tipo"] == $key) {
                            echo "<h4 class='text-uppercase'>" . $i . ".-" . $index . "</h4>";
                        };
                    } ?>
                    <div class="text-center">
                        <img src="<?= $urlfoto . rtrim($fot["archivo"]) . ".jpg" ?>" alt="<?= $fot["tipo"]; ?>" class="img-fluid" style="max-width: 90%; max-height: 100vh; object-fit: contain;">
                    </div>
                </div>
            <?php $i++;
            } ?>
        </div>
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