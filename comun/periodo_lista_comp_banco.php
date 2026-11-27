<?php
require_once("../util/seguridad.php");
require_once("../util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();
$cc_local = trim((string) ($_REQUEST["cc_local_vinculado"] ?? ''));
$modulo = substr(trim((string) s_mod_id()), 0, 3);

// Solo consejos permitidos al usuario (misma lista que muestra el modal).
$permitidos = array();
foreach ($bo_general->listarRegionesAdministrativo(s_local(), s_usuario()) as $loc) {
   $permitidos[] = trim($loc['c_local']);
}
if ($cc_local === '' || !in_array($cc_local, $permitidos, true)) {
   echo "<option value=''>Seleccione un consejo...</option>";
   return;
}

$data_periodo = $bo_general->listarPeriodosAbiertos($cc_local, $modulo);
if (empty($data_periodo)) {
   echo "<option value=''>Sin períodos abiertos...</option>";
   return;
}
echo "<option value=''>Seleccione...</option>";
foreach ($data_periodo as $row) {
   echo "<option value='" . htmlspecialchars(trim($row["periodo"]), ENT_QUOTES, 'UTF-8') . "'>"
      . htmlspecialchars(trim($row["c_mes"]) . '-' . trim($row["c_ano"]), ENT_QUOTES, 'UTF-8') . "</option>";
}
