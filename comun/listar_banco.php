<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");

s_validar_pagina(); 

 $cc_local     = $_REQUEST["cc_local"];

$bo_libros = new bo_general();

$listarBancos_texto = $bo_libros->ListarcuentasBancarias($cc_local,$cc_banco,$cc_banco_cuenta);

foreach($listarBancos_texto as $row){
    echo "<option value='".$row["c_banco"].$row["c_cta_corriente"]."'>".$row["nombre"].'-'.$row["c_cta_corriente"]."</option>";
}
?>