<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");

header('Content-Type: application/json; charset=utf-8');

$bo_general = new bo_general();
$bo_gen_personas = new bo_gen_personas();
$ent = new gen_personas();

try {
    $opc = s_crypt($_REQUEST['opc'], 'out');
    $c_persona = s_crypt($_REQUEST['c_persona'], 'out');

    // ✅ Validar que opc tenga valor
    if (empty($opc)) {
        throw new Exception("Operación no especificada.");
    }

    // ✅ Obtener valores limpios
    $tipo_proveedor = trim($_REQUEST["tipo_proveedor"] ?? '');
    if ($tipo_proveedor == 'RUC') {
        $ruc = trim($_REQUEST["ruc"] ?? '');
        $dni = '';
    } else {
        $ruc = '';
        $dni = trim($_REQUEST["num_documento"] ?? '');
    }

    $nombre = trim($_REQUEST["nombre"] ?? '');
    $celular1 = trim($_REQUEST["celular1"] ?? '');
    $email1 = trim($_REQUEST["email1"] ?? '');

    // ✅ Validaciones básicas
    if ($opc === 'I') {
        // Validar que al menos RUC o DNI esté lleno
        if (empty($ruc) && empty($dni)) {
            throw new Exception("Debe ingresar RUC o DNI.");
        }

        // Validar nombre
        if (empty($nombre) || strlen($nombre) < 3) {
            throw new Exception("El nombre es obligatorio (mínimo 3 caracteres).");
        }

        // Validar RUC si fue proporcionado
        if (!empty($ruc) && strlen($ruc) !== 11) {
            throw new Exception("El RUC debe tener exactamente 11 dígitos.");
        }

        // Validar DNI si fue proporcionado
        if (!empty($dni) && strlen($dni) !== 9) {
            throw new Exception("El documento de identidad puede tener entre 8 y 9 dígitos.");
        }

        // Validar email si fue proporcionado
        if (!empty($email1) && !filter_var($email1, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El email no es válido.");
        }
    }

    // ✅ Setear valores a la entidad
    $ent->setC_persona($c_persona);
    $ent->setCelular1($celular1 ?: null);
    $ent->setEmail1($email1 ?: null);
    $ent->setNombre($nombre ?: null);
    $ent->setRuc($ruc ?: null);
    $ent->setNum_documento($dni ?: null);
    $ent->setUsuario(s_usuario());
    $ent->setOpc($opc);

    // ✅ Validar duplicados solo en INSERT
    if ($opc === 'I') {
        $data_existe = $bo_gen_personas->ValidarNuevaPersona($ent);
        if (!empty($data_existe)) {
            $documento = !empty($ruc) ? "RUC $ruc" : "DNI $dni";
            throw new Exception("El $documento ya existe en el sistema.");
        } else {

            // ✅ Procesar (INSERT o UPDATE)
            $val = $bo_gen_personas->control_ruc($ent, $opc);

            if (!$val) {
                $error = $bo_gen_personas->errores();
                throw new Exception($error ?: "Error al procesar la operacion.");
            }

            // ✅ Respuesta exitosa
            echo json_encode([
                'error' => false,
                'message' => ($opc === 'I') ? 'Proveedor creado correctamente' : 'Proveedor actualizado correctamente',
                'url' => '?id=' . s_crypt('100005', 'in')
            ]);
        }
    }
} catch (Exception $e) {
    // ✅ Respuesta de error
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
