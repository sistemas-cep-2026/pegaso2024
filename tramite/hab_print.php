<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_internos.php");
$bo_tram_internos = new bo_tram_documentos_internos();
$ent_tram_internos = new tram_documentos_internos();

$id_doc = s_crypt($_REQUEST['id_doc'], 'out');
$firma = $_REQUEST['firma'];
$ent_tram_internos->setId_doc($id_doc);
$doc_emitidos = $bo_tram_internos->listarID($ent_tram_internos);
foreach ($doc_emitidos as $cab) {
    $numero = digitos(abs($cab["numero"]), 6);
    $nombre = $cab["nombre"];
    $cod_sexo = $cab["cod_sexo"];
    $c_cmp = $cab["c_cmp"];
    $fecha = $cab["fecha"];
    $desde = $cab["desde"];
    $hasta = $cab["hasta"];
    $hasta = $cab["hasta"];
    $c_tipo = $cab["c_tipo"];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CEP || Colegio de Enfermeros del Per&uacute;</title>
    <style type="text/css">
        @media print {
            @page {
                margin: 7;
                size: A4 portrait;
            }

            a[href]:after {
                content: none !important;
            }
        }

        .text12 {
            font-size: 12px;
        }

        .text13 {
            font-size: 13px;
        }

        .text16 {
            font-size: 16px;
        }

        .numero-res {
            position: relative;
            right: -65px;
        }
    </style>
</head>

<body>
    <table width="595" height="842" border="0" align="center">
        <tr>
            <td valign="top">
                <?php if ($c_tipo == "04") { ?>
                    <br><br><br><br><br><br><br><br><br>
                    <table width="595" border="0" align="center" cellpadding="2" cellspacing="2">
                        <tr>
                            <td class="text16" align="right" style="padding-right: 3rem;" colspan="2">
                                <span class="numero-res">N&deg; <?php echo $numero ?>/<?php echo date("Y") ?> - CN/CEP</span>
                            </td>
                        </tr>
                        <tr>
                            <td height="60" colspan="2" align="center"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <h2>CERTIFICADO DE HABILITACI&Oacute;N TEMPORAL<br>PARA EL EJERCICIO DE LA PROFESION DE<br>ENFERMER&Iacute;A EN EL TERRITORIO NACIONAL</h2>
                            </td>
                        </tr>
                        <tr>
                            <td height="35" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" class="text16">
                                <p>EL CONSEJO NACIONAL DEL COLEGIO DE ENFERMEROS DEL PER&Uacute;, otorga el presente CERTIFICADO DE HABILITACI&Oacute;N TEMPORAL, para ejercer la profesi&oacute;n de Enfermer&iacute;a en el pa&iacute;s a:</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" class="text16">
                                <h2>
                                    <p><?php echo $nombre ?></p>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" class="text16">
                                <p>Dando constancia que la citada(o) ejercer&aacute; la enfermer&iacute;a durante el periodo,<br> del <?php echo $desde ?> al <?php echo $hasta ?>.</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><?php echo "JES&Uacute;S MAR&Iacute;A"; ?>, <?php echo fechatexto($fecha); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                <?php } else {
                ?>
                    <table width="595" border="0" align="center" cellpadding="2" cellspacing="2">
                        <tr>
                            <td>&nbsp;</td>
                            <td class="text16" align="right">
                                <span class="numero-res">N&deg; <?php echo $numero ?>/<?php echo date("Y") ?> - CN/CEP</span>
                            </td>
                        </tr>
                        <tr>
                            <td height="210" colspan="2" align="center"></td>
                            <td height="210" colspan="2" align="center"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <p style="margin-top:2px;margin-bottom:2px;font-size:1.35em;font-weight:bold;">CERTIFICADO DE HABILITACI&Oacute;N<br>PARA EL EJERCICIO DE LA PROFESI&Oacute;N <br>DE ENFERMER&Iacute;A EN EL EXTRANJERO</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="justify" class="txt_13">
                                <p>EL CONSEJO NACIONAL DEL COLEGIO DE ENFERMEROS DEL PER&Uacute;, otorga el presente CERTIFICADO DE HABILITACI&Oacute;N PROFESIONAL,
                                    para ejercer la profesi&oacute;n de Enfermer&iacute;a en el extranjero a:</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo ($cod_sexo === 'M' ? 'Don' : 'Do&ntilde;a') ?>:
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" class="txt_13">
                                <p style="margin-top:2px;margin-bottom:2px;font-size:1.35em;font-weight:bold;"><?php echo $nombre ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="justify" class="txt_13">
                                <p><?php echo ($cod_sexo === 'M' ? 'Colegiado' : 'Colegiada') ?> con el Registro N&deg; <?php echo $c_cmp ?> del
                                    COLEGIO DE ENFERMEROS DEL PER&Uacute;. Cumple con los requisitos de formaci&oacute;n acad&eacute;mica dentro del
                                    Sistema Universitario en concordancia con la Legislaci&oacute;n vigente del Per&uacute;.</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="justify" class="txt_13">
                                EL CONSEJO NACIONAL DEL COLEGIO DE ENFERMEROS DEL PER&Uacute;, da constancia que <?php echo ($cod_sexo === 'M' ? 'el Enfermero' : 'la Enfermera') ?>
                                en menci&oacute;n no registra antecedentes negativos de car&aacute;cter &eacute;tico profesional, por lo que se otorga el presente CERTIFICADO.
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><?php echo "JES&Uacute;S MAR&Iacute;A"; ?>, <?php echo fechatexto($fecha); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p align="center" style="padding-left: 7rem; font-size: .8em">
                                    <?php
                                    if ($firma == 'Y') {
                                    ?>
                                        __________________________________________<br>
                                        <b>Dra. S.P. Petronila Elizabeth Alvarado Chávez</b><br>
                                        Decana Nacional<br>
                                        Colegio de Enfermeros del Perú<br><br><br>
                                    <?php
                                    }else{
                                        ?>
                                        <br><br><br><br><br><br>
                                        <?php
                                    }
                                    ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" class="text12">V&Aacute;LIDO POR 6 MESES</td>
                        </tr>
                    </table>
                <?php
                } ?>
            </td>
        </tr>
    </table>
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