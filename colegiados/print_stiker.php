<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_personas   = new bo_gen_personas();

$tipo = $_REQUEST["tipo"];
$c_tipo = $_REQUEST["c_tipo"];
$desde = intval($_REQUEST["desde"]);
$hasta = intval($_REQUEST["hasta"]);
$visible = $_REQUEST["v"];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="iso-8859-1">
  <link rel="stylesheet" type="text/css" href="<?= url('css/print_diploma_vertical_stiker.css') ?>">
  <title>Stiker</title>
</head>

<body>
  <?php for ($i = $desde; $i <= $hasta; $i++) { ?>
    <table class="page" align="center">
      <tr>
        <td height="1">&nbsp; </td>
        <td width="30" wh>&nbsp; </td>
      </tr>
      <tr>
        <td> <?php $cep = $i;
              include 'stiker_cuerpo.php' ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="150">&nbsp; </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td> <?php $i++;
              $cep = $i;
              include 'stiker_cuerpo.php'; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="140">&nbsp; </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td> <?php $i++;
              $cep = $i;
              include 'stiker_cuerpo.php'; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="145">&nbsp; </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td> <?php $i++;
              $cep = $i;
              include 'stiker_cuerpo.php';
              ?></td>
        <td>&nbsp;</td>
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