<html>

<head>
    <title>COLEGIO DE ENFERMEROS DEL PERÚ</title>
    <link rel="stylesheet" type="text/css" href="<?php echo url('css/print_pdf.css'); ?>">
</head>

<body class="bg-dark my-0">
    <?php if ($flag === 'A') { ?>
        <div class="anulado">ANULADO</div>
    <?php } ?>
    <div class="page bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <td class="align-middle col-1">
                    <img src="<?php echo logo ?>" width="80" />
                </td>
                <td class="align-middle col-7">
                    <b> <strong class="titulo-texto-14">COLEGIO DE ENFERMEROS DEL PERÚ</strong></b><br>
                    <b class="titulo-texto-13"><?php echo $local_nombre ?></b><br>
                    <b class="titulo-texto-11"><?php echo $local_direccion ?></b>
                </td>
                <td class="align-top text-center col-4">
                    <div class="border border-dark rounded-1 py-25 fs-75">
                        <b>RUC: 20117925375</b><br>
                        <?php echo $cod_documento_text; ?><br>
                        N°: <?php echo $num_documento; ?>
                    </div>
                </td>
            </tr>
        </table>
        <div class="border border-dark rounded-1 py-25 mb-1">
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td class="align-top col-6">
                        <div class="ps-50">
                            <ul class="list-unstyled">
                                <li class="mb-25"><b>Nombre ::</b> <?php echo $razon_social; ?></li>
                                <li class="mb-25"><b>Fecha de emisión:</b> <?php echo $fecha_text; ?></li>
                                <li class="mb-25"><b>Moneda: </b>Sol Peruano</li>
                                <li class="mb-25"><b>Forma de pago:</b> <?php echo $forma_pago; ?></li>
                            </ul>
                        </div>
                    </td>
                    <td class="align-top col-6">
                        <ul class="list-unstyled">
                            <li class="mb-25"><b>Ruc /DNI :</b> <?php echo $ruc; ?></li>
                            <li class="mb-25"><b>CEP:</b> <?php echo $c_cmp; ?></li>
                            <li class="mb-25"><b>Direccion:</b> <?php echo $direc ?></li>
                            <li class="mb-25"><b>Observaciones:</b> <?php echo $obs; ?></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div class="border border-dark rounded-1 p-1 mb-1">
            <table class="table table-sm">
                <thead>
                    <tr class="table-active">
                        <th class="text-center">CANTIDAD</th>
                        <th class="col-5 text-start">DESCRIPCION</th>
                        <th class="text-end">PRECIO</th>
                        <th class="text-end">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $igv = 0;
                    $total = 0;
                    foreach ($data_detall as $detalle) {
                        $igv += $detalle['monto'];
                    ?>
                        <tr>
                            <td class="text-center"><?php echo decimal($detalle['cantidad'], '0'); ?></td>
                            <td class="text-start"><?php echo $detalle['nombre_concepto']; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['precio'], '2'); ?></td>
                            <td class="text-end"><?php echo decimal($detalle['venta'], '2'); ?></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>

                </tbody>
                <tfoot>
                    <?php if ($cod_documento !== 'RC') { ?>
                        <tr>
                            <td class="text-end" colspan="3"><b>Operación gravada</b></td>
                            <td class="text-end"><b><?php echo decimal($opera_grabada, '2'); ?></b></td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3"><b>Operación inafecta</b></td>
                            <td class="text-end"><b><?php echo decimal($opera_inafecta, '2'); ?></b></td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3"><b>Operación exonerada</b></td>
                            <td class="text-end"><b><?php echo decimal('0', '2'); ?></b></td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3"><b>Operación gratuita</b></td>
                            <td class="text-end"><b><?php echo decimal('0', '2'); ?></b></td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="3"><b>I.G.V</b></td>
                            <td class="text-end"><b><?php echo decimal($igv, 2) ?> </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-end" colspan="3"><b>Total</b></td>
                        <td class="text-end"><b><?php echo decimal($valor_venta, '2'); ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="border border-dark rounded-1 p-75">
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td class="col-9 align-middle">

                        <b>SON: <?php echo strtoupper(num2letras($valor_venta) . ' soles'); ?><br></b>
                        <b>Método de pago:</b> <?php echo $forma_pago; ?>
                    </td>
                </tr>
                <?php foreach ($data_pagos as $row) { ?>
                    <tr>
                        <td><?= $row['cod_forma_de_pago_text'] . ' =>' . decimal($row['monto'], 2) ?>
                            <?php if ($row['cod_forma_de_pago'] === 'V'): ?><small class="text-muted">
                                    <?= $row['c_banco_ref_text'] . ' ' . $row['cta_cte_deposito'] . " | " . $row['fecha_referencia_text'] . " | " . $row['num_referencia'] ?>
                                </small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>