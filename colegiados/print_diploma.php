<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_personas   = new bo_gen_personas();

$tipo = $_REQUEST["tipo"];
$c_tipo = $_REQUEST["c_tipo"];
$desde = digitos($_REQUEST["desde"], 6);
$hasta = digitos($_REQUEST["hasta"], 6);
$visible = $_REQUEST["v"];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="iso-8859-1">
  <link rel="stylesheet" type="text/css" href="<?= url('css/print_diploma_horizontal.css') ?>">
</head>

<body>
  <?php
  $dato_personales = $bo_personas->diploma_data($tipo, $desde,  $hasta);
  foreach ($dato_personales as $rowdetalle) {
  ?>
    <table class="page">
      <?php
      
        $nombre_completo_detalle = $rowdetalle["nombre"];
        $fecha = $rowdetalle["fecha"];
        $num_documento = $rowdetalle["num_documento"];
        $sexo = $rowdetalle["cod_sexo"];
        $cep = $rowdetalle["c_cmp"];
      
      $foto = "https://cep.org.pe/fotos/" . $num_documento . ".jpg";
      ?>
      <tr>
        <td>
          <table width="87%" border="0" align="center" cellpadding="1" cellspacing="0">
            <tr>
              <td colspan="5" height="120">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="left" valign="bottom"><span class="texto01">El Colegio de Enfermeros del Per&uacute;.</span></td>
              <td align="right" valign="bottom"><a href="javascript:window.print()"><img src="<?= $foto ?>" width="100" height="120" /></a></td>
            </tr>
            <tr>
              <td colspan="5" align="justify"> <span class="texto01">Por cuanto:
                </span></td>
            </tr>
            <tr>
              <td colspan="5" align="center"><span class="texto01"><?php if ($sexo == 'M') {
                                                                      echo "Don";
                                                                    } else {
                                                                      echo "Do&ntilde;a";
                                                                    } ?>:&nbsp;&nbsp;&nbsp;</span> <span class="titulo01"><strong><?= $nombre_completo_detalle; ?></strong></span></td>
            </tr>
            <tr>
              <td colspan="5" align="justify"><span class="texto01">Ha cumplido con los requisitos se&ntilde;alados en el Estatuto y Reglamento del D.L. 22315 y ha sido incorporado como Miembro Activo y Registrado en el Libro de Inscripci&oacute;n de T&iacute;tulos del Colegio con el</span><span class="texto38"> <strong> N&deg; <?= $cep; ?></strong></span>.</td>
            </tr>
            <tr>
              <td colspan="5" align="justify"> <span class="texto01">Por tanto:</span></td>
            </tr>
            <tr>
              <td colspan="5" align="justify"> <span class="texto01">Se expide el presente Diploma para que se le reconozca como tal, facult&aacute;ndole para el ejercicio de la profesi&oacute;n de Enfermer&iacute;a</span>.</td>
            </tr>
            <tr>
              <td colspan="5" class="texto02"></td>
            </tr>
            <tr>
              <td colspan="5" align="right" class="texto01"></td>
            </tr>
            <tr>
              <td colspan="5" align="right" class="texto01">Dado y firmado en la ciudad de Lima, el <?= fechatexto($fecha) ?>.</td>
            </tr>
            <tr>
              <td colspan="5" height="45" align="center"></td>
            </tr>
            <?php if ($visible == '1') { ?>
              <tr align="center">
                <td width="30%" valign="bottom"><span class="firma01">
                    Dra. S.P. PETRONILA ELIZABETH ALVARADO CHÁVEZ</span></br>
                  <span class="firma03">Decana</span></br>
                </td>
                <td width="20%"><img src="<?= url('images/logo_decanato.jpg'); ?>" width="110"></td>
                <td width="15%" valign="bottom"><span class="texto01">&nbsp;&nbsp;&nbsp;Titular&nbsp;&nbsp;&nbsp;</span></td>
                <td width="15%"><img src="<?= url('images/logo_secretaria.jpg'); ?>" width="110"></td>
                <td width="25%" valign="bottom"><span class="firma01">
                    Dra. SUSAN HAYDEE GONZALES SALDAÑA</span></br>
                  <span class="firma03">Secretaria</span>
                </td>
              </tr>
            <?php } else { ?>
              <tr align="center">
                <td valign="bottom"></td>
                <td></td>
                <td valign="bottom"></td>
                <td></td>
                <td valign="bottom"></td>
              </tr>
            <?php } ?>
          </table>
        </td>
      </tr>
    </table>
  <?php } ?>
  <script>
    /* window.addEventListener("contextmenu", function(event) {
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
    }); */
  </script>
</body>

</html>