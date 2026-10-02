<?php
require_once("../util/seguridad.php");
require_once("../util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();
$cc_local = $_REQUEST["cc_local_vinculado"]; 

$data_periodo  = $bo_general->listarPeriodos($cc_local);
foreach($data_periodo as $row){
   echo "<option value='".$row["periodo"]."'>".$row["c_mes"].'-'.$row["c_ano"]."</option>";
}
?>