<html>

<head>
    <title>COLEGIO DE ENFERMEROS DEL PERÚ</title>
    <link rel="stylesheet" type="text/css" href="<?php echo url('css/print_pdf.css'); ?>">
</head>

<body class="bg-dark my-0">
    <?php if ($flag === 'A') { ?>
        <div class="anulado">ANULADO</div>
    <?php } ?>
     <?php if ($flag === 'V') { ?>
        <div class="vencido">**VENCIDO**</div>
    <?php } ?>
    <div class="page bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <td class="align-middle col-1">
                    <img src="<?php echo logo ?>" width="80" />
                </td>
                <td class="align-middle col-7">
                    <b> <strong class="titulo-texto-14"><?php echo $nombre_local; ?></strong></b><br>
                    <b class="titulo-texto-13"><?php echo $local_nombre ?></b><br>
                    <b class="titulo-texto-11"><?php echo $local_direccion ?></b>
                </td>
                <td class="align-top text-center col-4">
                    <div class="border border-dark rounded-1 py-25 fs-75">
                        FRACCIONAMIENTO<br>
                        N°: <?php echo $cc_fraccionamiento; ?><br>
                        <?php echo $flag_text; ?>
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
                                <li class="mb-25"><b>Nombre :</b> <?php echo $nombre; ?></li>
                                <li class="mb-25"><b>Fecha de emisión:</b> <?php echo $fecha_texto; ?></li>
                                <li class="mb-25"><b>Monto Fraccionado:</b> <?php echo $capital; ?></li>


                            </ul>
                        </div>
                    </td>
                    <td class="align-top col-6">
                        <ul class="list-unstyled">
                            <li class="mb-25"><b>Documento :</b> <?php echo $cod_documento . ':' . $num_documento; ?></li>
                            <li class="mb-25"><b>CEP:</b> <?php echo $c_cmp; ?></li>
                            <li class="mb-25"><b>Cuotas:</b> <?php echo $num_cuotas; ?></li>

                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div class="border border-dark rounded-1 p-1 mb-1">
            <table class="table table-sm">
                <thead>
                    <tr class="table-active">
                        <th class="text-center">CUOTA</th>
                        <th class="text-start">FECHA LIMITE DE PAGO</th>
                        <th class="text-start">REFERENCIA PAGO</th>
                        <th class="text-end">MONTO</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pendiente = 0;
                    $pagado = 0;

                    foreach ($data_detalle as $detalle) {

                        if (!empty($detalle['num_documento_ref'])) {
                            $pagado += $detalle['cuota_capital'];
                        } else {
                            $pendiente += $detalle['cuota_capital'];
                        }

                        $doc_ref = '';
                        if (!empty($detalle['num_documento_ref'])) {
                            $doc_ref = $detalle['cod_documento_ref'] . ' -- ' .
                                $detalle['num_documento_ref'] . ' -- ' .
                                $detalle['fecha_texto_cancelado'];
                        }
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $detalle['linea']; ?></td>
                            <td class="text-start"><?php echo $detalle['fecha_texto']; ?></td>
                            <td class="text-start"><?php echo $doc_ref; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['cuota_capital'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>

                    <tr>
                        <td class="text-end" colspan="3"><b>Penditente</b></td>
                        <td class="text-end"><b><?php echo decimal($pendiente, '2'); ?></b></td>
                    </tr>


                    <tr>
                        <td class="text-end" colspan="3"><b>Cancelado</b></td>
                        <td class="text-end"><b><?php echo decimal($pagado, '2'); ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="border border-dark">
            <table class="table table-sm">
                <tr>
                    <td class="text-center" style="width: 50%;">
                    </td>
                    <td class="text-center" style="width: 50%;">
                    </td>
                </tr>
                <tr>
                    <td class="text-center" style="width: 50%;">

                        <div class="mt-1"><b> <?php echo $nombre; ?></b> <br><b> <?php echo $cod_documento . ':' . $num_documento; ?></b></div>
                    </td>
                    <td class="text-center" style="width: 50%;">

                        <div class="mt-1"><b><?php echo $nombre_local; ?></b> <br><b>TESORERÍA</b></div>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</body>

</html>