<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_gen_entidad_pagadora.php");

s_validar_pagina();

$cc_local = $_REQUEST["c_local"] ?? '';

$bo  = new bo_gen_entidad_pagadora();
$ent = new gen_entidad_pagadora();
$ent->setC_local($cc_local);              // << usar setter

$data = $bo->listarIDLocal($ent);

echo "<option value=''>Seleccione...</option>";
foreach ($data as $r) {
    echo "<option value='" . htmlspecialchars($r["c_entidad_pagadora"]) . "'>"
        . htmlspecialchars($r["nombre_entidad"])
        . "</option>";
}
