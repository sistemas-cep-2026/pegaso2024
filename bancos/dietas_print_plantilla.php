<html>

<head>
    <title>RECIBO - DIETA</title>
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
                    <b> <strong class="titulo-texto-14">RECIBO<br>DIETA – REFRIGERIO – MOVILIDAD Y REPRESENTACION</strong></b><br>
                    <b class="titulo-texto-13"><?php echo $local_nombre ?></b><br>
                    <b class="titulo-texto-11"><?php echo $local_direccion ?></b>
                </td>
                <td class="align-top text-center col-4">
                    <div class="border border-dark rounded-1 py-25 fs-75">
                        <b>RUC: 20117925375</b><br>
                        N° <?php echo $cc_dietas; ?><br>

                        PERIODO: <b><?php echo $ano_contable . ' / ', $mes_contable; ?></b>
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
                                <li class="mb-25">Nombre :<b style="font-size: 12px;"> <?php echo $ruc . ' - ' . $nombre_persona . ' (CEP:' . $c_cmp . ')'; ?></b></li>
                                <li class="mb-25">Fecha :<b style="font-size: 12px;"> <?php echo $fecha_text; ?></b></li>
                                <li class="mb-25">Documento: <b><?php echo $cod_documento . ' - ' . $num_documento; ?></b></li>
                                <li class="mb-25">Referencia:<b> <?php echo $obs; ?></b></li>
                            </ul>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        <div class="border border-dark rounded-1 p-1 mb-1">
            <table class="table table-sm">
                <thead>
                    <tr class="table-active">
                        <th class="text-center">N</th>
                        <th class="col-5 text-start">CONCEPTO</th>
                        <th class="text-end">RENTA BRUTA</th>
                        <th class="text-end">RETENCION</th>
                        <th class="text-end">NETO PAGAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $renta_bruta = 0;
                    $neto = 0;
                    $retencion = 0;
                    foreach ($data_detall as $detalle) {
                        $renta_bruta += $detalle['renta_bruta'];
                        $neto += $detalle['neto'];
                        $retencion += ($detalle['renta_bruta'] * $detalle['retencion']);
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $detalle['concepto']; ?></td>
                            <td class="text-start"><?php echo $detalle['concepto_texto']; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['renta_bruta'], '2'); ?></td>
                            <td class="text-end"><?php echo decimal(($detalle['renta_bruta'] * $detalle['retencion']), '2') . ' (' . ($detalle['retencion'] * 100) . '%)'; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['neto'], '2'); ?></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>

                </tbody>
                <tfoot>

                    <tr>
                        <td class="text-end" colspan="2"><b></b></td>
                        <td class="text-end"><b><?php echo decimal($renta_bruta, '2'); ?></b></td>
                        <td class="text-end"><b><?php echo decimal($retencion, '2') . ' (' . ($detalle['retencion'] * 100) . '%)'; ?></b></td>
                        <td class="text-end"></td>
                    </tr>

                    <tr>
                        <td class="text-end" colspan="2"><b></b></td>
                        <td class="text-end"> </td>
                        <td class="text-end"> </td>
                        <td class="text-end"><b style="font-size: 14px;"><?php echo decimal($neto, '2'); ?></b></td>
                    </tr>
            </table>
        </div>
        <table class="table table-sm table-borderless">
            <tr>
                <td class="align-middle col-1">

                    </br>

                </td>
            </tr>
            <tr>
                <td class="align-middle col-1">

                </td>
                <td class="align-middle col-7">
                    <b> <strong class="titulo-texto-13">TESORERIA</strong></b><br>

                </td>
                <td class="align-top text-center col-4">

                    <br>
                    <?php echo $nombre_persona . '</br> ( CEP:' . $c_cmp . ' )'; ?><br>
                    <?php echo $cod_documento . ' - ' . $num_documento; ?></b>

                </td>
            </tr>
        </table>
    </div>
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
                    <b> <strong class="titulo-texto-14">RECIBO<br>DIETA – REFRIGERIO – MOVILIDAD Y REPRESENTACION</strong></b><br>
                    <b class="titulo-texto-13"><?php echo $local_nombre ?></b><br>
                    <b class="titulo-texto-11"><?php echo $local_direccion ?></b>
                </td>
                <td class="align-top text-center col-4">
                    <div class="border border-dark rounded-1 py-25 fs-75">
                        <b>RUC: 20117925375</b><br>
                        N° <?php echo $cc_dietas; ?><br>

                        PERIODO: <b><?php echo $ano_contable . ' / ', $mes_contable; ?></b>
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
                                <li class="mb-25">Nombre :<b style="font-size: 12px;"> <?php echo $ruc . ' - ' . $nombre_persona . ' (CEP:' . $c_cmp . ')'; ?></b></li>
                                <li class="mb-25">Fecha :<b style="font-size: 12px;"> <?php echo $fecha_text; ?></b></li>
                                <li class="mb-25">Documento: <b><?php echo $cod_documento . ' - ' . $num_documento; ?></b></li>
                                <li class="mb-25">Referencia:<b> <?php echo $obs; ?></b></li>
                            </ul>
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        <div class="border border-dark rounded-1 p-1 mb-1">
            <table class="table table-sm">
                <thead>
                    <tr class="table-active">
                        <th class="text-center">N</th>
                        <th class="col-5 text-start">CONCEPTO</th>
                        <th class="text-end">RENTA BRUTA</th>
                        <th class="text-end">RETENCION</th>
                        <th class="text-end">NETO PAGAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $renta_bruta = 0;
                    $neto = 0;
                    $retencion = 0;
                    foreach ($data_detall as $detalle) {
                        $renta_bruta += $detalle['renta_bruta'];
                        $neto += $detalle['neto'];
                        $retencion += ($detalle['renta_bruta'] * $detalle['retencion']);
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $detalle['concepto']; ?></td>
                            <td class="text-start"><?php echo $detalle['concepto_texto']; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['renta_bruta'], '2'); ?></td>
                            <td class="text-end"><?php echo decimal(($detalle['renta_bruta'] * $detalle['retencion']), '2') . ' (' . ($detalle['retencion'] * 100) . '%)'; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['neto'], '2'); ?></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>

                </tbody>
                <tfoot>

                    <tr>
                        <td class="text-end" colspan="2"><b></b></td>
                        <td class="text-end"><b><?php echo decimal($renta_bruta, '2'); ?></b></td>
                        <td class="text-end"><b><?php echo decimal($retencion, '2') . ' (' . ($detalle['retencion'] * 100) . '%)'; ?></b></td>
                        <td class="text-end"></td>
                    </tr>

                    <tr>
                        <td class="text-end" colspan="2"><b></b></td>
                        <td class="text-end"> </td>
                        <td class="text-end"> </td>
                        <td class="text-end"><b style="font-size: 14px;"><?php echo decimal($neto, '2'); ?></b></td>
                    </tr>
            </table>
        </div>
        <table class="table table-sm table-borderless">
            <tr>
                <td class="align-middle col-1">

                    </br>

                </td>
            </tr>
            <tr>
                <td class="align-middle col-1">

                </td>
                <td class="align-middle col-7">
                    <b> <strong class="titulo-texto-13">TESORERIA</strong></b><br>

                </td>
                <td class="align-top text-center col-4">

                    <br>
                    <?php echo $nombre_persona . '</br> ( CEP:' . $c_cmp . ' )'; ?><br>
                    <?php echo $cod_documento . ' - ' . $num_documento; ?></b>

                </td>
            </tr>
        </table>
    </div>

</body>

</html>