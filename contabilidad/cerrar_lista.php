<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_contabilidad_centralizar.php");

$bo_general = new bo_general();
$bo_centralizar = new bo_contabilidad_centralizar();

$cc_local = $_REQUEST['cc_local'];
$anho = $_REQUEST['anho'];


$data_compras = $bo_centralizar->ListarPeriodosCerrar($cc_local, $anho);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>COLEGIO DE ENFERMEROS DEL PERÚ</title>

    <link rel="stylesheet" href="../css/style_print.css">

    <style>
        body {
            font-family: Arial, sans-serif !important;
            font-size: 16px !important;
            margin: 20px;
            background-color: #ffffff;
        }

        /* TABLA */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 17px !important;
        }

        /* ENCABEZADOS */
        table tr:first-child td {
            background-color: #f2f2f2 !important;
            font-size: 18px !important;
            font-weight: bold !important;
            color: #222 !important;
            padding: 12px !important;
            text-align: center !important;
        }

        /* DATOS */
        table tr:not(:first-child) td {
            font-size: 17px !important;
            font-weight: 500 !important;
            color: #333 !important;
            padding: 12px !important;
            text-align: center !important;
            border-bottom: 1px solid #e5e5e5;
        }

        /* BOTÓN PROCESAR */
        #btnProcesarCompras {
            background-color: #4054a0 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 12px 28px !important;
            font-size: 18px !important;
            font-weight: bold !important;
            cursor: pointer;
        }

        #btnProcesarCompras:hover {
            background-color: #304080 !important;
        }

        #btnProcesarCompras:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-estado {
            border: 1px solid transparent;
            border-radius: 20px;
            padding: 9px 18px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            min-width: 125px;
        }

        .btn-estado.cerrado {
            background-color: #ff1100;
            color: white;
        }

        .btn-estado.abierto {
            background-color: #00fc43;
            color: #495057;
            border-color: #adb5bd;
        }

        .btn-estado:disabled {
            opacity: 0.5;
            cursor: wait;
        }
    </style>
</head>

<body>
    <table>

        <tbody>
            <tr>
                <td align="center">AÑO</td>
                <td align="center">PERIODO</td>
                <td align="center">PLANILLA</td>
                <td align="center">COMPRAS</td>
                <td align="center">BANCOS</td>
                <td align="center">CONTABILIDAD</td>

            </tr>
            <?php
            $modulos = [
                'compras' => 'flag_cierre_compras',
                'bancos' => 'flag_cierre_bancos',
                'contabilidad' => 'flag_cierre_contabilidad'
            ];

            foreach ($data_compras as $row) {
            ?>
                <tr>
                    <td align="center"><?= htmlspecialchars($row['c_ano']) ?></td>
                    <td align="center"><?= htmlspecialchars($row['c_mes']) ?></td>
                    <td align="center">X</td>

                    <?php foreach ($modulos as $modulo => $campo) {
                        // Supuesto: 1 = cerrado, 0 = abierto
                        $cerrado = (string)$row[$campo] === '*';
                    ?>
                        <td align="center">
                            <button type="button"
                                class="btn-estado <?= $cerrado ? 'cerrado' : 'abierto' ?>"
                                data-modulo="<?= $modulo ?>"
                                data-anho="<?= htmlspecialchars($row['c_ano'], ENT_QUOTES, 'UTF-8') ?>"
                                data-periodo="<?= htmlspecialchars($row['c_mes'], ENT_QUOTES, 'UTF-8') ?>"
                                onclick="parent.fn_CambiarCierre(this)">

                                <?= $cerrado ? '🔒 CERRADO' : '🔓 ABIERTO' ?>
                            </button>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>


        </tbody>

    </table>
    <br>
    <input type="hidden" id="centralizar_cc_local" value="<?php echo htmlspecialchars($cc_local, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" id="centralizar_anho" value="<?php echo htmlspecialchars($anho, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" id="centralizar_periodo" value="<?php echo htmlspecialchars($periodo, ENT_QUOTES, 'UTF-8'); ?>">


    </button>

</body>

</html>