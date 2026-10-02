<?php
require_once("../util/seguridad.php");
require_once("../util/util.php");
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_personas = new bo_gen_personas();

$desde = intval($_REQUEST["folio_desde"]);
$hasta = intval($_REQUEST["folio_hasta"]);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>PEGASO | COLEGIO DE ENFERMEROS DEL PERU</title>
    <link rel="icon" href="<?php echo url('images/logo_print.jpg') ?>" type="image/png">
</head>

<body>
    <?php
    for ($ix = $desde; $ix <= $hasta; $ix++) {
        $nro_folio = $ix;
    ?>
        <table border="0" align="center" width="100%" cellpadding="1" cellspacing="1" style="line-height: 2.4em; font-size: 10px">
            <tr>
                <td align="center" width="8%"><strong>N CEP</strong></td>
                <td width="17%"><strong>C. REGIONAL COLEGIACION</strong></td>
                <td width="10%"><strong>F. REGISTRO</strong></td>
                <td width="61%"><strong>CONTACTO</strong></td>
                <td align="right" width="4%"><strong><?php echo $nro_folio; ?> </strong></td>
            </tr>
            <?php
            $dato_personales = $bo_personas->listarDatosLibroFoliosLicenciatura($nro_folio);
            $folio = 0;
            foreach ($dato_personales as $r) {
            ?>
                <tr>
                    <td align="center"> <?php echo $r["c_cmp"]; ?> </td>
                    <td> <?php echo $r["nombre_local"]; ?> </td>
                    <td> <?php echo $r["fecha"]; ?> </td>
                    <td colspan="2">
                        <?php echo $r["direx"] . " " . $r["email"] . " " . $r["email1"] . " " . $r["celular"] . " " . $r["celular1"] . " " . $r["direccion"]; ?>
                        <?php if ($folio == $r["n_folio_cole"]) {
                            $ii = $ii + 1;
                        } else {
                            $folio = $r["n_folio_cole"];
                            $ii = 1;
                        } ?>
                    </td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </table>
    <?php } ?>
</body>

</html>