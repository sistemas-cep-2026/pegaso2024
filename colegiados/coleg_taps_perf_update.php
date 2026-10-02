<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
try {
    require_once(u_src() . "bo/bo_gen_personas.php");
    $bo_personas = new bo_gen_personas();
    $ent_personas = new gen_personas();

    $cc_persona = s_crypt($_REQUEST['cc_persona'], 'out');
    $opc = s_crypt($_REQUEST['opc'], 'out');

    $factor_sanguineo = str_ends_with($_REQUEST["grupo_sanguineo"], '+') ? 'P' : (str_ends_with($_REQUEST["grupo_sanguineo"], '-') ? 'N' : '');
    $grupo_sanguineo = str_replace(['+', '-'], '', $_REQUEST["grupo_sanguineo"]);

    $ent_personas->setCc_persona($cc_persona);
    $ent_personas->setFecha_de_inicio($_REQUEST["fecha_de_inicio"]);
    $ent_personas->setFlag_activo($_REQUEST["flag_activo"]);
    $ent_personas->setCod_sexo($_REQUEST["cod_sexo"]);
    $ent_personas->setApellido_Materno(strtoupper($_REQUEST["apellido_materno"]));
    $ent_personas->setApellido_Paterno(strtoupper($_REQUEST["apellido_paterno"]));
    $ent_personas->setNombre1(strtoupper($_REQUEST["nombre1"]));
    $ent_personas->setNombre2(strtoupper($_REQUEST["nombre2"]));
    $ent_personas->setNombre(strtoupper($_REQUEST["apellido_paterno"]) . " " . strtoupper($_REQUEST["apellido_materno"]) . " " . strtoupper($_REQUEST["nombre1"]) . " " . strtoupper($_REQUEST["nombre2"]));
    $ent_personas->setFecha_de_nacimiento(u_fecha($_REQUEST["fecha_de_nacimiento"]));
    $ent_personas->setPais_nacimiento($_REQUEST["pais_nacimiento"]);
    $ent_personas->setCod_documento($_REQUEST["cod_documento"]);
    $ent_personas->setNum_documento($_REQUEST["num_documento"]);
    $ent_personas->setCelular1($_REQUEST["celular1"]);
    $ent_personas->setEmail1($_REQUEST["email1"]);
    $ent_personas->setGrupo_sanguineo($grupo_sanguineo);
    $ent_personas->setFactor_sanguineo($factor_sanguineo);
    $ent_personas->setC_local($_REQUEST["c_local"]);
    $ent_personas->setC_local_colegiacion($_REQUEST["c_local_colegiacion"]);
    $ent_personas->setC_entidad_pagadora($_REQUEST["c_entidad_pagadora"]);
    $ent_personas->setUbigeonac($_REQUEST["ubigeonac"]);
    $ent_personas->setUbigeodirec($_REQUEST["ubigeodirec"]);
    $ent_personas->setC_e_civil($_REQUEST["c_e_civil"]);
    $ent_personas->setC_universidad($_REQUEST["c_universidad"]);
    $ent_personas->setFecha_promocion(u_fecha($_REQUEST["fecha_promocion"]));
    $ent_personas->setC_univ_licenciatura($_REQUEST["c_univ_licenciatura"]);
    $ent_personas->setFecha_licenciatura(u_fecha($_REQUEST["fecha_licenciatura"]));
    $ent_personas->setTipo_direccion($_REQUEST["tipo_direccion"]);
    $ent_personas->setC_entidad_pagadora($_REQUEST["c_entidad_pagadora"]);
    $ent_personas->setDDIRECTO(empty($_REQUEST["condicion_laboral"]) ? 'SD' : $_REQUEST["condicion_laboral"]);
    $ent_personas->setUsuario(s_usuario());

    $bo_personas->control($ent_personas, $opc);
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
