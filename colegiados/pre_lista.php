<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_web_tram_colegiacion.php");

$bo_tram_colegiacion  = new bo_web_tram_colegiacion();
$ent_tram_colegiacion  = new web_tram_colegiacion();

//$c_local     = $_REQUEST["c_local"];
$c_local     = s_local();
$varbuscar = $_REQUEST["varbuscar"];

if (is_numeric($varbuscar)) {
    $ent_tram_colegiacion->setNum_documento($varbuscar);
} else {
    $ent_tram_colegiacion->setNombre1($varbuscar);
}

$ent_tram_colegiacion->setC_region($c_local);
$data_nuevo = $bo_tram_colegiacion->listar($ent_tram_colegiacion);
$dir_foto = "https://www.cep.org.pe/colegiacion/imag/fotos/";
if (empty($data_nuevo)) {
    die(errors());
}
?>
<table class="table table-sm table-hover">
    <thead>
        <tr class="table-active">
            <th scope="col">APELLIDOS Y NOMBRES</th>
            <th scope="col">FECHA REG.</th>
            <th scope="col">C. REGIONAL</th>
            <th scope="col">CORREO</th>
            <th scope="col">CELULAR</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data_nuevo as $row) {
        ?>
            <tr class="align-middle">
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img loading="lazy" src="<?= $dir_foto . $row["num_documento"] ?>.jpg" onerror="this.onerror=null; this.src='images/sinfoto.jpg';" class="rounded img-fluid material-shadow" width="45">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <a href="javascript:void(0);" onclick="fn_buscarRegistroDetalle({num_documento:'<?= $row['num_documento'] ?>'})">
                                <h6 class="mb-0 link-secondary link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover"><?= $row["nombres"] ?></h6>
                            </a>
                            <small class="text-muted"><?= $row["cod_documento_text"] ?> : <?= $row["num_documento"] ?></small>
                        </div>
                    </div>
                </td>
                <td><?= $row["col_fecha"]; ?></td>
                <td><?= $row["nombre_region"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?= $row["celular"]; ?></td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>