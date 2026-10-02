<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_personas = new bo_gen_personas();
$bo_det = new bo_gen_parametro_det();

$tipo = TRIM($_REQUEST["tipo"]);
$desde = intval($_REQUEST["folio_desde"]);
$hasta = intval($_REQUEST["folio_hasta"]);  

$data_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_filt = array_values(array_filter($data_grados, function ($item) {
    global $tipo;
    return $item['cc_codigo'] == $tipo;
}));
$tipo_text = $arr_filt[0]['detalle'];
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
        <table border="0" align="center" width="100%" cellpadding="1" cellspacing="1" style="line-height: 2.3em; font-size: 10px">
            <tr>
                <td align="center" width="3%"><strong>N</strong></td>
                <td align="center" width="3%"><strong>F.TITULO</strong></td>
                <td width="25%"><strong>UNIVERSIDAD</strong></td>
                <td width="5%"><strong>CR</strong></td>
                <td width="5%"> <strong>REGISTRO</strong></td>
                <td width="56%"> <strong>OBS</strong></td>
                <td width="3%"><strong><?php echo $nro_folio; ?></strong></td>
            </tr>
            <?php
            $dato_personales = $bo_personas->listarDatosLibroOtrosGrados($tipo, $nro_folio);
            $folio = 0;
            foreach ($dato_personales as $r) {
            ?>
                <tr>

                    <td align="center"> <?php echo $r["c_reg_esp"]; ?> </td>
                    <td align="center"> <?php echo $r["fecha_diploma"]; ?> </td>
                    <td> <?php echo $r["nombre"]; ?> </td>
                    <td><?php echo $r["nombre_abv"]; ?> </td>
                    <td> <?php echo $r["fecha"]; ?> </td>
                    <td colspan="2">
                        <?php echo $r["obs2"]; ?>
                        <?php
                        if ($folio == $r["n_folio_cole"]) {
                            $ii = $ii + 1;
                        } else {
                            $folio = $r["n_folio_cole"];
                            $ii = 1;
                        }
                        ?>
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