<?php
/** Plantilla de la Guía de Entrada (Dompdf). Variables: $guia, $data_detalle, $logo_src. */
function guia_h($texto)
{
    return htmlspecialchars(trim((string) $texto), ENT_QUOTES, 'UTF-8');
}

/** Código del artículo en 6 dígitos: la BD lo guarda con ceros de relleno (000000000000000062 -> 000062). */
function guia_codigo($codigo)
{
    $sin_ceros = ltrim(trim((string) $codigo), '0');
    return digitos($sin_ceros === '' ? '0' : $sin_ceros, 6);
}

function guia_cantidad($valor)
{
    $valor = (float) $valor;
    return decimal($valor, (floor($valor) == $valor) ? 0 : 2);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Guía de Entrada N° <?= guia_h($guia['numero']) ?></title>
    <style>
        @page { margin: 28px 36px 46px 36px; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 9.5pt; color: #222; }
        table { border-collapse: collapse; width: 100%; }
        .cab td { vertical-align: middle; }
        .cab .logo { width: 80px; }
        .cab .inst { text-align: center; }
        .cab .inst .org { font-size: 12pt; font-weight: bold; color: #0b2e59; }
        .cab .inst .ent { font-size: 9pt; color: #555; margin-top: 2px; }
        .cab .inst .tit { font-size: 15pt; font-weight: bold; color: #0b2e59; margin-top: 6px; letter-spacing: 1px; }
        .num { width: 150px; border: 1.5px solid #0b2e59; text-align: center; padding: 6px; }
        .num .lbl { font-size: 8pt; color: #555; }
        .num .val { font-size: 15pt; font-weight: bold; color: #0b2e59; }
        .num .est { font-size: 8pt; margin-top: 3px; padding: 2px 4px; background: #e8eef7; }
        .linea { border-top: 0.75px solid #c9d3e0; margin: 8px 0 10px 0; }
        .datos td { padding: 3px 4px; vertical-align: top; }
        .datos .lbl { width: 80px; font-weight: bold; }
        .det { margin-top: 12px; }
        .det th { background: #0b2e59; color: #fff; font-size: 8.5pt; padding: 6px 5px; border: 1px solid #0b2e59; }
        .det td { padding: 5px; border: 1px solid #d5dbe4; }
        .det tbody tr:nth-child(even) td { background: #f6f8fb; }
        .c { text-align: center; }
        .r { text-align: right; }
        .vacio { text-align: center; color: #888; padding: 14px; }
        .firmas { margin-top: 70px; }
        .firmas td { width: 50%; text-align: center; font-size: 8.5pt; }
        .firmas .raya { border-top: 1px solid #333; width: 70%; margin: 0 auto; padding-top: 4px; font-weight: bold; }
    </style>
</head>

<body>
    <table class="cab">
        <tr>
            <td class="logo">
                <?php if ($logo_src !== '') { ?>
                    <img src="<?= $logo_src ?>" alt="Logo" width="70">
                <?php } ?>
            </td>
            <td class="inst">
                <div class="org">COLEGIO DE ENFERMEROS DEL PERÚ</div>
                <div class="tit">GUÍA DE ENTRADA</div>
            </td>
            <td class="num">
                <div class="lbl">N.°</div>
                <div class="val"><?= guia_h($guia['numero']) ?></div>
                <?php if ($guia['flag_text'] !== '') { ?>
                    <div class="est"><?= guia_h($guia['flag_text']) ?></div>
                <?php } ?>
            </td>
        </tr>
    </table>

    <div class="linea"></div>

    <table class="datos">
        <tr>
            <td class="lbl">Fecha</td>
            <td><?= guia_h($guia['fecha']) ?></td>
            <td class="lbl">Requisición</td>
            <td><?= guia_h($guia['cc_requisicion']) ?></td>
        </tr>
        <tr>
            <td class="lbl">Solicitante</td>
            <td colspan="3"><?= guia_h(trim($guia['c_usuario'] . ' - ' . $guia['nombre_usuario'], ' -')) ?></td>
        </tr>
        <tr>
            <td class="lbl">Proveedor</td>
            <td colspan="3"><?= guia_h(trim($guia['ruc'] . ' - ' . $guia['proveedor'], ' -')) ?></td>
        </tr>
        <tr>
            <td class="lbl">Documento</td>
            <td colspan="3"><?= guia_h(trim($guia['cod_documento'] . ' ' . $guia['num_documento'])) ?></td>
        </tr>
        <tr>
            <td class="lbl">Observación</td>
            <td colspan="3"><?= nl2br(guia_h($guia['observacion'])) ?></td>
        </tr>
    </table>

    <table class="det">
        <thead>
            <tr>
                <th class="c" style="width:28px;">#</th>
                <th class="c" style="width:60px;">CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th class="c" style="width:80px;">UNIDAD</th>
                <th class="r" style="width:70px;">CANTIDAD</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data_detalle)) { ?>
                <tr>
                    <td colspan="5" class="vacio">La guía no tiene artículos registrados.</td>
                </tr>
            <?php } ?>
            <?php $i = 1;
            foreach ($data_detalle as $det) { ?>
                <tr>
                    <td class="c"><?= $i++ ?></td>
                    <td class="c"><?= guia_h(guia_codigo($det['c_articulo'])) ?></td>
                    <td><?= guia_h($det['nombre_articulo']) ?></td>
                    <td class="c"><?= guia_h($det['unidad']) ?></td>
                    <td class="r"><?= guia_cantidad($det['cantidad']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <table class="firmas">
        <tr>
            <td style="width:100%;"><div class="raya" style="width:35%;">AUTORIZADO</div></td>
        </tr>
    </table>
</body>

</html>
