<!DOCTYPE html>
<html>

<head>
    <title>Vale de de Salida</title>
    <link rel="stylesheet" type="text/css" href="<?php echo url('css/print_pdf.css'); ?>">
</head>
<body class="bg-dark my-2">
    <div class="page bg-white">
        <table class="table table-sm table-borderless">
            <tr>
                <td class="align-middle col-2">
                    <img src="<?php echo logo; ?>" alt="Logo" width="80">
                </td>
                <td class="align-top text-center col-9"> 
                    <h1>VALE DE SALIDA N° : <?php echo $cc_guia; ?></h1>
                   <!-- <h2><?php echo $flag_text; ?></h2> -->
                    Fecha: <?php echo date("d/m/Y H:i:s")." ".s_usuario(); ?>
                </td>
            </tr>
        </table>
        <table class="table table-sm table-borderless mb-0">
            <tr>
                <td class="col-2">Entidad :</td>
                <td class="col-4"><?php echo $entidad; ?></td>
                <td class="col-2">Área :</td>
                <td class="col-4"><?php echo $area_text; ?></td>
            </tr>
            <tr>
                <td class="col-2">Fecha :</td>
                <td class="col-4"><?php echo $fecha; ?></td>
                <td class="col-2">Solicitante :</td>
                <td class="col-4"><?php echo $usuario.' '.$solicitante; ?></td>
            </tr>
            <tr>
                <td class="col-1">Obs :</td>
                <td  colspan="11" class="col-11"><?php echo $justificacion; ?></td>
                
            </tr>
        </table>
        <table class="table table-sm">
            <thead>
                <tr class="table-active">
                    <th class="text-start">#</th>
                    <th class="text-start">CODIGO</th>
                    <th class="col-5 text-start">NOMBRE</th>
                    <th class="text-start">UNIDAD</th>
                    <th class="text-end">CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($data_detalle as $det) {
                    ?>
                    <tr>
                        <td ><?php echo $i; ?></td>
                        <td class="text-start"><?php echo digitos($det['c_articulo'],8); ?></td>
                        <td class="text-start"><?php echo $det['nombre_articulo'] ?></td>
                        <td class="text-start"><?php echo $det['unidad'] ?></td>
                        <td class="text-end"><?php echo decimal($det['cantidad'],0) ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>

    </div>
    <br><br>
    <table class="table table-sm table-borderless mb-0">
     <tr>
        <td class="text-center"><p>________________________________</p>SOLICITADO</td>
        
        <td class="text-center"><p>________________________________</p>ENTREGADO</td>
    </tr>
</table>
</body>

</html>