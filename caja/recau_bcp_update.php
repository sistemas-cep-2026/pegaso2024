<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once u_src() . "bo/bo_recaud_excelbcp.php";

$bo_recaudobcp = new bo_recaud_excelbcp();
$opc = $_REQUEST['opc'];

try {
    if ($opc === 'I') {
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $fname = $_FILES['archivo']['name'];
            $tmpName = $_FILES['archivo']['tmp_name'];
            $fileInfo = pathinfo($fname);
            $ext = strtolower($fileInfo['extension']);

            if ($ext === "txt") {
                $lines = file($tmpName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                foreach ($lines as $line) {
                    if (str_starts_with($line, 'DD')) {
                        $ent_recaudobcp = new recaud_excelbcp();

                        $ent_recaudobcp->setCodigo_depositante(substr($line, 13, 14));
                        $ent_recaudobcp->setDato_adicional(substr($line, 27, 30));
                        $ent_recaudobcp->setFecha(substr($line, 57, 8));
                        $ent_recaudobcp->setFecha_vencimiento(substr($line, 65, 8));
                        $ent_recaudobcp->setMonto(substr($line, 73, 15));
                        $ent_recaudobcp->setMora(substr($line, 88, 15));
                        $ent_recaudobcp->setTotal(substr($line, 103, 15));
                        $ent_recaudobcp->setSucursal(substr($line, 118, 6));
                        $ent_recaudobcp->setNumero_operacion(substr($line, 124, 6));
                        $ent_recaudobcp->setReferencia(substr($line, 130, 22));
                        $ent_recaudobcp->setTerminal(substr($line, 152, 4));
                        $ent_recaudobcp->setMedio(substr($line, 156, 12));
                        $ent_recaudobcp->setHora(substr($line, 168, 6));
                        $ent_recaudobcp->setCheque(substr($line, 174, 10));
                        $ent_recaudobcp->setCodigo_banco(substr($line, 184, 2));
                        $ent_recaudobcp->setCargo(substr($line, 186, 10));
                        $ent_recaudobcp->setExtorno(substr($line, 196, 1));
                        $ent_recaudobcp->setDocumento_pago(substr($line, 197, 20));
                        $ent_recaudobcp->setOperacion_db(substr($line, 217, 8));
                        $ent_recaudobcp->setOperacion_canal(substr($line, 225, 25));

                        $val = $bo_recaudobcp->subirRecaudadorabcp($ent_recaudobcp);

                        if (!$val) {
                            throw new Exception("No se pudo guardar la línea.");
                        }
                    }
                }
                echo json_encode(["estado" => "0", "mensaje" => "Dato OK"]);
            } else {
                throw new Exception("El archivo debe ser un .txt.");
            }
        } else {
            throw new Exception("No hay archivo.");
        }
    } elseif ($opc === 'P') {
        $ent_recaudobcp = new recaud_excelbcp();
        $bo_recaudobcp->procesarRecaudadorabcp($ent_recaudobcp);
        echo json_encode(["estado" => "0", "mensaje" => "Proceso ejecutado correctamente"]);
    } else {
        throw new Exception("Opción no válida.");
    }
} catch (Exception $e) {
    echo json_encode(["estado" => "1", "mensaje" => $e->getMessage()]);
}
