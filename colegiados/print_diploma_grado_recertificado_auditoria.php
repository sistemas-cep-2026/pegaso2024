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
    <table class="page" align="center">
      <?php
      $nombre_completo_detalle = $rowdetalle["nombre"];
      $fecha = $rowdetalle["fecha"];
      $num_documento = $rowdetalle["num_documento"];
      $cep1 = $rowdetalle["c_cmp"];
      $c_reg_esp = $rowdetalle["c_reg_esp"];
      $literal = $rowdetalle["literal"];
      $sexo = $rowdetalle["cod_sexo"];

      $foto = "https://cep.org.pe/fotos/" . $num_documento . ".jpg";
      ?>
      <tr>
        <td>
          <table width="87%" border="0" align="center" cellpadding="1" cellspacing="0">
            <tr>
              <td colspan="5" width="20" align="left" valign="bottom">&nbsp;</td>
              <td colspan="5" width="20" align="left" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" height="180" align="left" valign="bottom"> </td>
              <td colspan="5" height="180" align="left" valign="bottom"><a href="javascript:window.print()"><img src="<?php echo $foto ?>" width="100" style="position:relative;right:15px;top:50px;" /></a> </td>
            </tr>
            <tr>
              <td colspan="5"><span class="texto01">El Colegio de Enfermeros del Per&uacute;, por cuanto:</span></td>
              <td align="center"></td>
            </tr>
            <tr>
              <td colspan="5" align="center" class="titulo01"><strong><span class="texto01">
                    <?php if ($sexo == "M") {
                      echo "Don";
                    } else {
                      echo "Do&ntilde;a";
                    } ?>
                  </span> &nbsp;<?php echo $nombre_completo_detalle; ?></strong></td>
            </tr>
            <tr>
              <td colspan="5" align="center"><span class="texto01">
                  <?php if ($sexo == 'M') {
                    echo "Licenciado";
                  } else {
                    echo "Licenciada";
                  } ?>
                  en Enfermer&iacute;a con el número de registro de CEP N&deg; <?php echo $cep1; ?>, y con el número de registro de Auditoría
                  N&deg;&nbsp;<?php echo $c_reg_esp; ?> ha cumplido con presentar los requisitos establecidos para el proceso de recertificación profesional, obteniendo la condición de
                  <?php if ($sexo == 'M') {
                    echo "Enfermero Auditor Recertificado";
                  } else {
                    echo "Enfermera Auditora Recertificada";
                  } ?> en:&nbsp;</span></td>
            </tr>
            <tr>
              <td colspan="5" align="center" class="titulo01"><strong><?php echo $literal; ?></strong></td>
            </tr>
            <tr>
              <td colspan="5" align="center" class="texto01">Con vigencia desde el <strong>17/09/2026</strong> hasta el <strong>17/09/2031</strong>.</td>
            </tr>
            <tr>
              <td colspan="5" align="justify"><span class="texto01">
                  Por tanto, se expide el presente Diploma para que se le reconozca como tal y pueda acreditar la vigencia de sus competencias profesionales.</span></td>
            </tr>
            <tr>
              <td colspan="5" align="right" class="texto01">Dado y firmado en la ciudad de Lima, el <?php echo fechatexto('17/09/2026') ?>.</td>
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