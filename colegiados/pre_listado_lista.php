<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
s_validar_pagina();
$bo_persona = new bo_gen_personas();
$ent_persona = new gen_personas();

$nombres = $_REQUEST['nombres'];

if(is_numeric($nombres)){
    $ent_persona->setNum_documento($nombres);
}else{
    $ent_persona->setNombre($nombres);
}

$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
$c_local = $_REQUEST['c_local'] === '28' ? '' : $_REQUEST['c_local'];
$recaudo = $_REQUEST['recaudo'] ?? '0';

$ent_persona->setDesde($desde);
$ent_persona->setHasta($hasta);
$ent_persona->setC_local($c_local);
$ent_persona->setRecaudo($recaudo);

$data = $bo_persona->buscarpre_matri($ent_persona);

?>
<table class="table table-sm table-hover" id="table_pre_matricula_recuado">
    <thead>
        <tr>
            <th colspan="9" class="text-center table-active">LISTA DE PRE-MATRICULADOS</th>
        </tr>
        <tr>
            <th colspan="9" class="text-center table-active"><?= date("d/m/Y h:m:s") ?><br /> <?= s_usuario() ?></th>
        </tr>
        <tr class="active">
            <th>#</th>
            <th>(C)PERSONA</th>
            <th>CR</th>
            <th>COD DOC.</th>
            <th>DOCUMENTO</th>
            <th>NOMBRE</th>
            <th>USUARIO</th>
            <th>FECHA DE PROCESO</th>
            <th>RECAUDO</th>
        </tr>
    </thead>
    <?php
    $i = 1;
    foreach ($data as $row) {
        //$data_recaudoxds = $bo_persona->PersonaIDdni_nuevocol_recaudox($row["num_documento"]);
    ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $row["c_persona"]; ?></td>
            <td><?= $row["c_region"]; ?></td>
            <td><?= $row["cod_documento"]; ?></td>
            <td><?= $row["num_documento"] ?></td>
            <td><?= $row["nombre_completo"] ?></td>
            <td><?= $row["c_usuario"]; ?></td>
            <td><?= $row["fecha"]; ?></td>
            <td>
                <?php
                /* if (!empty($row["recaudo"])) {
                            echo $row["recaudo"];
                        } else {
                            echo "NO";
                        }*/
                /* foreach ($data_recaudoxds as $reca) {

                    echo $reca["bcp1"];
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo $reca["bbva1"];
                } */

                ?>
                <?= $row["recaudo"]; ?>
            </td>
        </tr>
    <?php
        $i++;
    }
    ?>
</table>