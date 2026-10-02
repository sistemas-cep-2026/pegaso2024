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
                    <h2>CONCILIACION COTIZACIONES <?= $cod_mes . '/' . $cod_anho ?> DETALLE</h2>
                    <h3><?= $nombre_local ?></h3>
                </td>
            </tr>
        </table>
        <small>Fecha: <?php echo date("d/m/Y H:i:s") . " " . s_usuario(); ?></small>
        <table class="table table-sm">
            <thead>
                <tr class="table-active">
                    <th class="text-start">#</th>
                    <th class="text-start">DETALLE (CUSTODIADO POR EL CDN)</th>
                    <th class="text-start">REFERENCIA</th>
                    <th class="text-start">CANTIDAD</th>
                    <th class="text-end">TOTAL</th>
                    <th class="text-end">REGIONAL</th>
                    <th class="text-end">CDN</th>
                    <th class="text-end">%</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($data_concilia as $det) {
                    if ($det['entidad'] <> 'CAJA') {
                        $nacional = $nacional + $det['nacional'];
                        $regional = $regional + $det['regional'];
                        $total = $total + $det['nacional'] + $det['regional']; ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td class="text-start"><?php echo $det['entidad_text']; ?></td>
                            <td class="text-start"><?php echo $det['referencia'] ?></td>
                            <td class="text-start"><?php echo $det['cantidad'] ?></td>
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
                    <td class="text-start"></td>
                    <td class="text-start"></td>
                    <td class="text-end"><strong><?php echo decimal($total, 2) ?></strong></td>
                    <td class="text-end"><strong><?php echo decimal($regional, 2) ?></strong></td>
                    <td class="text-end"><strong><?php echo decimal($nacional, 2) ?></strong></td>
                    <td class="text-end"> </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-start"></td>
                    <td class="text-start"></td>
                    <td class="text-start"></td>
                    <td class="text-end"> </td>
                    <td class="text-end"> </td>
                    <td class="text-end"> </td>
                    <td class="text-end"> </td>
                </tr>
                <tr class="table-active">
                    <th class="text-start">#</th>
                    <th class="text-start">DETALLE (INGRESO DIRECTO CR)</th>
                    <th class="text-start">REFERENCIA</th>
                    <th class="text-start">CANTIDAD</th>
                    <th class="text-end">TOTAL</th>
                    <th class="text-end">REGIONAL</th>
                    <th class="text-end">CDN</th>
                    <th class="text-end">%</th>
                </tr>
                <?php
                foreach ($data_concilia as $det) {
                    if ($det['entidad'] == 'CAJA') { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td class="text-start"><?php echo $det['entidad_text']; ?></td>
                            <td class="text-start"><?php echo $det['referencia'] ?></td>
                            <td class="text-start"><?php echo $det['cantidad'] ?></td>
                            <td class="text-end"><?php echo decimal($det['nacional'] + $det['regional'], 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['regional'], 2) ?></td>
                            <td class="text-end"><?php echo decimal($det['nacional'], 2);
                                                    $resta = $det['nacional'];
                                                    $fecha = $det['fecha']; 
                                                    $c_usuario = $det['c_usuario']; 
                                                    $fecha2=$det['fecha2']; 
                                                    $c_usuario2 = $det['c_usuario2']; ?></td>
                            <td class="text-end"><?php echo decimal($det['porcentaje'], 0) ?></td>
                        </tr>
                <?php
                        $i++;
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td class="text-start"></td>
                    <td class="text-start"></td>
                    <td class="text-start"></td>
                    <td class="text-end"> </td>
                    <td class="text-end"> </td>
                    <td class="text-end"> </td>
                    <td class="text-end"> </td>
                </tr>

                <tr>
                    <td></td>
                    <td class="text-start"></td>
                    <td colspan="4" class="text-end">POR TRANSFERIR AL CR DESDE EL CDN</td>
                    <td colspan="2" class="text-end"><strong><?php echo decimal($regional, 2) ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-start"></td>
                    <td colspan="4" class="text-end">POR TRANSFERIR AL CDN DESDE EL CR</td>
                    <td colspan="2" class="text-end"><strong><?php echo decimal($resta * -1, 2) ?></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-start"> Registro: <?php echo $fecha; ?></td>
                    <td colspan="4" class="text-end"><strong>SALDO A TRANSFERIR AL CR</strong></td>
                    <td colspan="2" class="text-end"><strong><?php echo decimal($regional - $resta, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <br><br>
    <table class="table table-sm table-borderless mb-0">
        <tr>
            <td class="text-center">
                <p>________________________________</p>
                <?php echo $fecha.' '.$c_usuario; ?>
            </td>
            <td class="text-center">
                <p>________________________________</p>
            </td>
        </tr>
    </table>
</body>

</html>