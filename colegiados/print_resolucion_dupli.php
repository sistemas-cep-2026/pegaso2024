<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_personas   = new bo_gen_personas();
$tipo = $_REQUEST["tipo"];
$c_tipo = $_REQUEST["c_tipo"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$visible = $_REQUEST["v"];
?>
<!DOCTYPE html>
<html>
<meta charset="iso-8859-1">
<link rel="stylesheet" type="text/css" href="<?= url('css/print_diploma_vertical.css') ?>">
</head>

<body>

    <?php
    $dato_personales = $bo_personas->resolucion_data($tipo, $desde,  $hasta);
            foreach ($dato_personales as $rowdetalle) {
    ?>
        <table class="page" align="center">
            <?php
                $cep = $rowdetalle["c_cmp"];
                $nombre_completo_detalle = $rowdetalle["nombre"];
                $fecha = $rowdetalle["fecha"];
                $num_documento = $rowdetalle["num_documento"];
                $sexo = $rowdetalle["cod_sexo"];
                $nombre1 = $rowdetalle["nombre1"];
                $c_year = $rowdetalle["c_year"];
                $res = $rowdetalle["N_RESOLUCION_cole"];
            
            ?>
            <tr>
                <td width="854">
                    <table width="720" height="60" align="center">
                        <tr>
                            <td align="right" valign="bottom"><span class="texto_resolucion2" style="font-size:28px">N&deg;</span><strong><?php echo $res; ?>-<?php echo $c_year; ?>-CN/CEP</strong></td>
                        </tr>
                    </table>
                    <br>
                    <table width="640" align="center">
                        <tr>
                            <td height="180" colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><span class="texto_resolucion2" style="font-size:48px">Resoluci&oacute;n</span> </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">
                                <span class="texto_resolucion1">Lima, <?php echo fechatexto(date('d/m/Y')) ?>.</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">Visto el Expediente N&deg;</span> <?php echo $res - 14; ?>-<?php echo $c_year; ?>-CR <?php echo $nombre1; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">Considerando:</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">&nbsp;&nbsp;&nbsp;Que, la Colegiaci&oacute;n es registro indispensable para el ejercicio de la profesi&oacute;n de Enfermer&iacute;a (D.L. N&deg; 22315).</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">&nbsp;&nbsp;&nbsp;Que, es funci&oacute;n del Colegio de Enfermeros del Per&uacute; incorporar a todas las Enfermeras y Enfermeros del Pa&iacute;s que se encuentran legalmente aptos para ejercer la profesi&oacute;n de Enfermer&iacute;a (D.L. N&deg; 22315).</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">&nbsp;&nbsp;&nbsp;&nbsp;Que, en concordancia con lo dispuesto en el T&iacute;tulo</span> II<span class="texto_resolucion1">, Cap.</span> II<span class="texto_resolucion1">, Art. 11&deg; y 12&deg; del Estatuto del Colegio de Enfermeros del Per&uacute; y en la Directiva N&deg; 371-24-</span>CDN/CEP <span class="texto_resolucion1"> sobre el proceso de Colegiaci&oacute;n, la recurrente re&uacute;ne todos los requisitos establecidos para tal fin.</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">&nbsp;&nbsp;&nbsp;&nbsp;Estando a lo informado por el Consejo Regional </span><?php echo $nombre1; ?><span class="texto_resolucion1"> y con la opini&oacute;n favorable del Consejo Directivo Nacional.</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">Se Resuelve incorporar
                                    <?php if ($sexo == 'M') {
                                        echo "al Licenciado en Enfermer&iacute;a";
                                    } else {
                                        echo " a la Licenciada en Enfermer&iacute;a";
                                    } ?>:</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><span class="texto_resolucion1"><?php if ($sexo == 'M') {
                                                                                                echo "Don";
                                                                                            } else {
                                                                                                echo "Do&ntilde;a";
                                                                                            } ?>:&nbsp;&nbsp;&nbsp;</span><span class="titulo01"><strong><?php echo $nombre_completo_detalle; ?></strong></span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify">
                                <span class="texto_resolucion1">&nbsp;&nbsp;&nbsp;&nbsp;Como miembro Activo de la instituci&oacute;n y registrar su T&iacute;tulo de Licenciatura en Enfermer&iacute;a con el</span>
                                <span class="texto_resolucion38" style="font-size: 28px;"><strong>N&deg; <?php echo $cep; ?></strong></span>
                                <span class="texto_resolucion1"> de Colegiatura, en el Registro Nacional de Enfermeras(os) Colegiadas(os) del Colegio de Enfermeros del Per&uacute;,
                                    emitido el <?php echo fechatexto($fecha) ?>.
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="justify"><span class="texto_resolucion1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reg&iacute;strese y comun&iacute;quese.</span></td>
                        </tr>
                        <?php if ($visible == '1') { ?>
                            <tr>
                                <td colspan="2" align="right">
                                    <img src="../images/decana-2025.png" width="350">
                                </td>
                                <td align="center"></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td width="357" height="100" colspan="2" rowspan="2" align="right"></td>
                                <td align="center"></td>
                            </tr>
                            <tr>
                                <td align="center"></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
    <?php } ?>
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