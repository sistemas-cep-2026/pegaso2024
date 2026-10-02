<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_det = new bo_gen_parametro_det();
$bo_persona = new bo_gen_personas();
$ent_persona = new gen_personas();

$tipo = $_REQUEST['tipo'];
$folio_desde = $_REQUEST['desde'];
$folio_hasta = $_REQUEST['hasta'];

switch ($tipo) {
    case 'C':
        $data_persona_libros = $bo_persona->listarLibroFolioLicenciatura($folio_desde, $folio_hasta);
        break;
    case 'H':
        $data_persona_libros = $bo_persona->listarLibroFolioHabExtranjero($folio_desde, $folio_hasta);
        break;
    case 'T':
        $data_persona_libros = $bo_persona->listarLibroFolioHabTemporal($folio_desde, $folio_hasta);
        break;
    default:
        $data_persona_libros = $bo_persona->listarLibroFolioOtrosGrados($tipo, $folio_desde, $folio_hasta);
        break;
}

if (empty($data_persona_libros)) {
    echo errors();
    exit;
}

$data_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_filt = array_values(array_filter($data_grados, function ($item) {
    global $tipo;
    return $item['cc_codigo'] == $tipo;
}));
$val_xx = $arr_filt[0]['detalle_corto'];
$val = $arr_filt[0]['detalle'];

?>
<hr>
<table class="table table-sm">
    <caption class="caption-top">
        <div class="text-end">
            <a href="<?php echo url('colegiados/print_libro_' . $val_xx . '1.php?tipo=' . $tipo . '&folio_desde=' . $folio_desde . '&folio_hasta=' . $folio_hasta . ''); ?>"
                target="_blank"
                class="btn btn-success btn-sm active" role="button">
                <?php echo "IMPRIMIR FOLIOS " . $val . " LADO A !!!" ?>
            </a>
            <?php
            if (!in_array($tipo, ['H'])) {
            ?>
                <a href="<?php echo url('colegiados/print_libro_' . $val_xx . '2.php?tipo=' . $tipo . '&folio_desde=' . $folio_desde . '&folio_hasta=' . $folio_hasta . ''); ?>"
                    target="_blank"
                    class="btn btn-success btn-sm active" role="button">
                    <?php echo "IMPRIMIR FOLIOS " . $val . " LADO B !!!" ?>
                </a>
            <?php
            }
            ?>
        </div>
    </caption>
    <thead>
        <tr>
            <td>#</td>
            <td>LIBRO</td>
            <td>FOLIO</td>
            <td>##</td>
            <td>N° REGISTRO</td>
            <td>NOMBRE</td>
            <td>FECHA</td>
            <td>CR</td>
            <td>OBS</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $folio = 0;
        $i = 1;
        foreach ($data_persona_libros as $row) { ?>
            <tr>

                <td><?php echo $i; ?></td>
                <td><?php echo $row["n_libro_cole"] ?></td>
                <td><?php echo $row["n_folio_cole"] ?></td>
                <td>
                    <?php
                    if ($folio == $row["n_folio_cole"]) {
                        $ii = $ii + 1;
                    } else {
                        $folio = $row["n_folio_cole"];
                        $ii = 1;
                    }
                    echo $ii; ?>
                </td>
                <td><?php echo $row["c_cmp"]; ?></td>
                <td><?php echo $row["nombre"]; ?></td>
                <td><?php echo $row["fecha"]; ?></td>
                <td><?php echo $row["c_local_colegiacion"]; ?></td>
                <td><?php echo $row["obs"]; ?></td>
            </tr>
        <?php
            $i++;
        } ?>
    </tbody>
</table>