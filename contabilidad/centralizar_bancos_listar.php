
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
$periodo = $_REQUEST['periodo'];

$data = $bo_centralizar->listarBancos($cc_local);
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

        /* BOTÓN PROCESAR BANCOS */
        #btnProcesarBancos {
            background-color: #4054a0 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 12px 28px !important;
            font-size: 18px !important;
            font-weight: bold !important;
            cursor: pointer;
        }

        #btnProcesarBancos:hover {
            background-color: #304080 !important;
        }

        #btnProcesarBancos:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td align="center">AÑO</td>
                <td align="center">MES</td>
                <td align="center">ACUMULADO S/.</td>
                <td align="center">CANTIDAD DE REGISTROS</td>
            </tr>

            <?php
            foreach ($data as $row) {
            ?>
                <tr>
                    <td align="center">
                        <?php echo htmlspecialchars($row['cod_ano']); ?>
                    </td>
                    <td align="center">
                        <?php echo htmlspecialchars($row['cod_mes']); ?>
                    </td>
                    <td align="center">
                        <?php echo htmlspecialchars($row['total']); ?>
                    </td>
                    <td align="center">
                        <?php echo htmlspecialchars($row['cantidad']); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

    <input type="hidden"
           id="centralizar_cc_local"
           value="<?php echo htmlspecialchars($cc_local, ENT_QUOTES, 'UTF-8'); ?>">

    <input type="hidden"
           id="centralizar_anho"
           value="<?php echo htmlspecialchars($anho, ENT_QUOTES, 'UTF-8'); ?>">

    <input type="hidden"
           id="centralizar_periodo"
           value="<?php echo htmlspecialchars($periodo, ENT_QUOTES, 'UTF-8'); ?>">

    <button type="button"
            id="btnProcesarBancos"
            class="btn btn-primary"
            onclick="parent.fn_ProcesarBancos(this)">

        <i class="bi bi-gear"></i>
        PROCESAR <?php echo htmlspecialchars($anho . '-' . $periodo, ENT_QUOTES, 'UTF-8'); ?>

    </button>

    <div id="mensajeProcesarBancos"
         style="margin-top: 12px; font-size: 16px;">
    </div>

</body>
</html>
