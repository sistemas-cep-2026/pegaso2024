<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once u_src() . "bo/bo_recaud_excelbbva.php";

$bo_recaudobbva = new bo_recaud_excelbbva();
$ent_recaudobbva = new recaud_excelbbva();
$opc = $_REQUEST['opc'];

try {
    if ($opc === 'I') {
        if (!isset($_FILES['archivobbva']) || empty($_FILES['archivobbva']['name'])) {
            throw new Exception("No existe archivo");
        }

        $fname = $_FILES['archivobbva']['name'];
        $chk_ext = pathinfo($fname, PATHINFO_EXTENSION);

        if (strtolower($chk_ext) !== "txt") {
            throw new Exception("No es el formato txt");
        }

        $archivotmp = $_FILES['archivobbva']['tmp_name'];
        $lineas = file($archivotmp, FILE_IGNORE_NEW_LINES);

        $INICIO_DATOS_IDX = 12;
        $REGEX_FIN = '/^\s*"Nro Registros"\s+"Total Importe Original"\s+"Total Importe Pagado"/';

        $insertados = 0;

        foreach ($lineas as $linea_num => $linea) {
            if ($linea_num < $INICIO_DATOS_IDX) continue;

            if (preg_match($REGEX_FIN, $linea)) break;

            if (trim($linea) === '' || preg_match('/^-{3,}$/', trim($linea))) continue;

            $hora_sin_puntos = str_replace(":", "", trim($linea));

            $ent_recaudobbva->setNombre(trim(substr($linea,  0, 40)));
            $ent_recaudobbva->setCodigo(trim(substr($linea, 41, 26))); 
            $ent_recaudobbva->setObs(trim(substr($linea, 67, 41)));
            $ent_recaudobbva->setImp1(trim(substr($linea, 108, 26)));
            $ent_recaudobbva->setImp2(trim(substr($linea, 134, 26)));
            $ent_recaudobbva->setOficina('001');
            $ent_recaudobbva->setMov(trim(substr($linea, 186,  26)));
            $ent_recaudobbva->setFecha_pago(trim(substr($linea, 212,  10)));
            $ent_recaudobbva->setHora(trim(substr($linea, 222,  8)));
            $ent_recaudobbva->setFecha_proceso(trim(substr($hora_sin_puntos, 222,  20)));
            $ent_recaudobbva->setForma_pago('01');
            $ent_recaudobbva->setCanal('01');
            $ok = $bo_recaudobbva->subirRecaudadorabbva($ent_recaudobbva);
            if (!$ok) {
                throw new Exception("No se pudo guardar una de las filas (línea " . ($linea_num + 1) . ").");
            }
            $insertados++;
        }

        echo json_encode(["estado" => "0", "mensaje" => "Importación completada", "insertados" => $insertados]);
    } elseif ($opc === 'P') {
        $ent_recaudobbva = new recaud_excelbbva();
        
        $val = $bo_recaudobbva->procesarRecaudadoraBBVA($ent_recaudobbva);
        // Esperar 20 segundos
        //sleep(20);
        
       echo json_encode(["estado" => "0", "mensaje" => "Proceso ejecutado correctamente"]);
    } else {
        throw new Exception("Opción no válida.");
    }
} catch (Exception $e) {
    echo json_encode(["estado" => "1", "mensaje" => $e->getMessage()]);
}
