<!DOCTYPE html>
<html>

<head>
    <title>CONCILIACION COTIZACIONES</title>
    <link rel="stylesheet" type="text/css" href="<?php echo url('css/print_pdf.css'); ?>">
</head>

<body class="bg-dark my-2">
    <div class="page bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <td class="align-middle col-2">
                    <img src="<?php echo logo; ?>" alt="Logo" width="80">
                </td>
                <td class="align-top text-center col-7">
                    <h2 style="margin:0; line-height:1;">DECLARACION JURADA</h2>

                    <h2 style="margin:0; line-height:1;">
                        CONCILIACION COTIZACIONES <?= $cod_mes . '/' . $cod_anho ?>
                    </h2>

                    <h2 style="margin:0; line-height:1;">
                        <?= $nombre_local ?>
                    </h2>

                    <h3 style="margin:0; line-height:1;">
                        <?php echo date("d/m/Y H:i:s") . " " . s_usuario(); ?>
                    </h3>
                </td>
            </tr>
        </table>

        <table class="table table-sm">
            <thead>
                <tr class="table-active">
                    <th class="text-start">#</th>
                    <th class="text-start">COTIZACIONES CUSTODIADAS POR EL CDN</th>

                    <th class="text-end">TOTAL</th>
                    <th class="text-end">REGIONAL</th>
                    <th class="text-end">CDN</th>
                    <th class="text-end">%</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $nacional = 0;
                $regional = 0;
                $caja = 0;
                $comprensado = 0;
                $total = 0;
                foreach ($data_concilia as $det) {
                    if ($det['entidad'] <> 'CAJA' and ($det['cod_anho'] . $det['cod_mes'] == $det['periodo'])) {
                        $nacional = $nacional + $det['nacional'];
                        $regional = $regional + $det['regional'];
                        $total = $total + $det['nacional'] + $det['regional'];



                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td class="text-start"><?php echo $det['entidad_text']; ?></td>

                            <td class="text-end"><?php echo decimal($det['nacional'] + $det['regional'], 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['regional'], 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['nacional'], 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['porcentaje'], 0) ?></td>
                        </tr>
                <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
            <tfoot>


                <tr>
                    <td></td>
                    <td class="text-start"></td>

                    <td class="text-end"><strong><?php echo decimal($total, 2) ?></strong></td>
                    <td class="text-end"><strong><?php echo decimal($regional, 2) ?></strong></td>
                    <td class="text-end"><strong><?php echo decimal($nacional, 2) ?></strong></td>
                    <td class="text-end"> </td>
                </tr>


                <tr class="table-active">
                    <th class="text-start">#</th>
                    <th class="text-start">INGRESO DIRECTO CR <?= $nombre_local ?></th>

                    <th class="text-end">TOTAL</th>
                    <th class="text-end">REGIONAL</th>
                    <th class="text-end">CDN</th>
                    <th class="text-end">%</th>
                </tr>
                <?php

                foreach ($data_concilia as $det) {
                    if ($det['entidad'] == 'CAJA') {

                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td class="text-start"><?php echo $det['entidad_text']; ?> - COTIZACIONES</td>

                            <td class="text-end"><?php $caja = $det['nacional'] + $det['regional'];
                                                    echo decimal($caja, 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['regional'], 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['nacional'], 2);
                                                    $resta = $det['nacional'];
                                                    $fecha = $det['fecha'];
                                                    $usuario = $det['usuario'];
                                                    $fecha2 = $det['fecha2'];
                                                    $usuario2 = $det['usuario2'];
                                                    $nombre = $det['nombre'];
                                                    $nombre2 = $det['nombre2'];
                                                    $area1 = $det['area1'];
                                                    $area2 = $det['area2'];  ?></td>
                            <td class="text-end"><?php echo decimal($det['porcentaje'], 0) ?></td>
                        </tr>
                <?php
                        $i++;
                    }
                }
                ?>


                <tr>
                    <td colspan="4" class="text-end">POR TRANSFERIR AL CR DESDE EL CDN</td>
                    <td colspan="2" class="text-end"><strong><?php echo decimal($regional, 2) ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">POR TRANSFERIR AL CDN DESDE EL CR</td>
                    <td colspan="2" class="text-end"><strong><?php echo decimal($resta * -1, 2) ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>SALDO </strong></td>
                    <td colspan="2" class="text-end"><strong><?php echo decimal($regional - $resta, 2);
                                                                $comprensado = $regional - $resta; ?></strong></td>
                </tr>

            </tfoot>


        </table>
    </div>

    <table class="table table-sm table-borderless mb-0">

        <tr>
            <td colspan="2" class="text-center">
                <p>Los firmantes declaramos, bajo juramento, que la información proporcionada sobre los ingresos</br>
                    por cotizaciones recaudados directamente en el <strong><?= $nombre_local ?></strong></br>
                    en el <strong>Módulo de Caja del Sistema Pegaso-Web</strong>, en el periodo <strong><?= $cod_mes . '/' . $cod_anho ?></strong>, asciende a <strong>S/. <?php echo decimal($caja, 2); ?></strong> </br>
                    los cuales han sido debidamente verificados y validados.</p>
                <?php if ($comprensado > 0) { ?>
                    <p>COMPENSADO: Saldo a transferir al <?= $nombre_local ?> <strong>S/. <?php echo decimal($comprensado, 2) ?></strong></p>

                <?php } else { ?>
                    <p>COMPENSADO: Saldo a transferir al Consejo Directivo Nacional <strong>S/. <?php echo decimal($comprensado * -1, 2) ?></strong></p>
                <?php } ?>

            </td>

        </tr>

        <tr>
            <td colspan="2" class="text-center">
                <table class="table table-sm">
                    <thead>
                        <tr class="table-active">
                            <th class="text-start">#</th>
                            <th class="text-start">CDN PENDIENTE LIQUIDAR</th>

                            <th class="text-end">TOTAL</th>
                            <th class="text-end">REGIONAL</th>
                            <th class="text-end">CDN</th>
                            <th class="text-end">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($data_concilia_pend as $detpend) {
                            if ($detpend['entidad'] <> 'CAJA' and ($detpend['cod_anho'] . $detpend['cod_mes'] <> $detpend['periodo'])) {
                                $nacional = $nacional + $detpend['nacional'];
                                $regional = $regional + $detpend['regional'];
                                $total = $total + $detpend['nacional'] + $detpend['regional'];



                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td class="text-start"><?php echo $detpend['entidad_text'] . ' PERIODO=> ' . $detpend['cod_mes'] . '/' . $detpend['cod_anho']; ?></td>

                                    <td class="text-end"><?php echo decimal($detpend['nacional'] + $detpend['regional'], 2) ?></td>
                                    <td class="text-end"><?php echo decimal($detpend['regional'], 2) ?></td>
                                    <td class="text-end"><?php echo decimal($detpend['nacional'], 2) ?></td>
                                    <td class="text-end"><?php echo decimal($detpend['porcentaje'], 0) ?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <p>...</p>
            </td>

        </tr>
        <tr>
            <td class="text-center">
                <p>________________________________</p>
                <?php echo $fecha . ' - ' . $usuario; ?></br>
                <?= $nombre; ?></br>
                <?= $area1; ?></br>

            </td>
            <td class="text-center">
                <p>________________________________</p>
                <?php echo $fecha2 . ' - ' . $usuario2; ?></br>
                <?= $nombre2; ?></br>
                <?= $area2; ?></br>

            </td>
        </tr>
    </table>
</body>

</html>