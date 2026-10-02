<html>

<head>
    <title>CONTABILIDAD - ASIENTO</title>
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
                    <b> <strong class="titulo-texto-14">CONTABILIDAD - ASIENTO</strong></b><br>
                    <b class="titulo-texto-13"><?php echo $local_nombre ?></b><br>
                    <b class="titulo-texto-11"><?php echo $local_direccion ?></b>
                </td>
                <td class="align-top text-center col-4">
                    <div class="border border-dark rounded-1 py-25 fs-75">
                        <b>RUC: 20117925375</b><br>
                        N° <?php echo $voucher; ?><br>
                          <b>  <?php echo $nombre_subdiario ; ?></b><br>
                        PERIODO: <b><?php echo $ano_contable.' / ',$cod_mes_contable; ?></b>
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
                                <li class="mb-25"><b>RAZON :</b> <?php echo $ruc. ' - '.$razon_social; ?></li>
                                <li class="mb-25"><b>Fecha :</b> <?php echo $fecha; ?></li>
                                <li class="mb-25"><b>Documento: </b><?php echo $cod_documento.' - '.$num_documento; ?></li>
                                <li class="mb-25"><b>:</b> <?php echo $forma_pago; ?></li>
                            </ul>
                        </div>
                    </td>
                    <td class="align-top col-6">
                        <ul class="list-unstyled">
                            <li class="mb-25"><b> :</b> <?php echo $ruc; ?></li>
                            <li class="mb-25"><b>:</b> <?php echo $c_cmp; ?></li>
                            <li class="mb-25"><b>:</b> <?php echo $direc ?></li>
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
                        <th class="text-center">CUENTA</th>
                        <th class="col-5 text-start">DESCRIPCION</th>
                        <th class="text-end">DEBE</th>
                        <th class="text-end">HABER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $igv = 0;
                    $total = 0;
                    foreach ($data_detall as $detalle) {
                       $debe+= $detalle['debe'];
                       $haber+= $detalle['haber'];
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $detalle['c_cuenta'] ; ?></td>
                            <td class="text-start"><?php echo $detalle['nombre_cuenta']; ?></td>
                            <td class="text-end"><?php echo decimal($detalle['debe'], '2'); ?></td>
                            <td class="text-end"><?php echo decimal($detalle['haber'], '2'); ?></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>

                </tbody>
                <tfoot>
                     
                    <tr>
                        <td class="text-end" colspan="2"><b></b></td>
                        <td class="text-end"><b><?php echo decimal($debe, '2'); ?></b></td>
                        <td class="text-end"><b><?php echo decimal($haber, '2'); ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    
    </div>
</body>

</html>