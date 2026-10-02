<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_personas = new bo_gen_personas();
$bo_det = new bo_gen_parametro_det();

$tipo = trim($_REQUEST["tipo"]);
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
    <link rel="stylesheet" href="<?php echo url('css/print_pdf.css?ver=' . rand(1, 999999)) ?>">
    <style>
        @media print {

            table,
            figure {
                page-break-inside: avoid;
                /* Prevent the table from breaking across pages */
            }

            @page {
                size: A4 landscape;
            }
        }
    </style>
</head>

<body>
    <?php
    for ($ix = $desde; $ix <= $hasta; $ix++) {
        $nro_folio = $ix;
    ?>
        <table class="table table-borderless table-sm">
            <thead>
                <tr>
                    <th>N</th>
                    <th>FECHA</th>
                    <th class="col-3 text-start">NOMBRE Y APELLIDOS</th>
                    <th>N CEP</th>
                    <th>CR</th>
                    <th class="col-2">PAIS A EMIGRAR</th>
                    <th class="col-4 text-start">DOMICILIO ACTUAL</th>
                    <th class="col-3 text-start">OBSERVACIONES</th>
                    <th class="text-end"><?php echo $nro_folio; ?></th>
                </tr>
            </thead>
            <?php
            $dato_personales = $bo_personas->listarLibroFolioHabExtranjero($nro_folio, $nro_folio);
            foreach ($dato_personales as $r) {
            ?>
                <tr>
                    <td style="font-size:10px !important;" class="lh-lg text-center"> <?php echo $r["c_cmp"]; ?></td>
                    <td style="font-size:10px !important;" class="text-center"> <?php echo $r["fecha"]; ?></td>
                    <td style="font-size:10px !important;"><?php echo $r["nombre"]; ?></td>
                    <td style="font-size:10px !important;" class="text-center"> <?php echo $r["cep"]; ?></td>
                    <td style="font-size:10px !important;" class="text-center"> <?php echo str_replace('CR ', '', $r["c_local_colegiacion"]); ?> </td>
                    <td style="font-size:10px !important;" class="text-center"> <?php echo $r["nombre_pais"]; ?> </td>
                    <td style="font-size:10px !important;"> <?php echo $r["tipo_direccion"]; ?> </td>
                    <td style="font-size:10px !important;" colspan="2">
                        <?php echo $r["obs"]; ?>
                    </td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </table>
    <?php } ?>
    <script>
        window.addEventListener("contextmenu", function(event) {
            event.preventDefault();
        });
        window.addEventListener("keydown", function(event) {
            if (event.ctrlKey && event.key === "p") {
                event.preventDefault();
                alert("La impresión está deshabilitada en esta página.");
            }
            if (event.metaKey && event.key === "p") { // Para Mac (Cmd + P)
                event.preventDefault();
                alert("La impresión está deshabilitada en esta página.");
            }
        });
        window.addEventListener("load", function(event) {
            window.print();
        });
        window.addEventListener("afterprint", (event) => {
            window.close();
        });
    </script>
</body>

</html>