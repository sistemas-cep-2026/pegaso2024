<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_guias_de_salida.php");

$bo_itemguia= new bo_alm_items_guias_de_salida();

$ent_itemguia= new alm_items_guias_de_salida();

$cc_guia=s_crypt($_REQUEST["cc_guia"],'out');

$ent_itemguia->setCc_guia($cc_guia);
$data_deta=$bo_itemguia->ListarIdGuia($ent_itemguia);

?>
<div class="d-grid gap-1">
    <?php
    $i = isset($_POST['total_detalle']) ? (int)$_POST['total_detalle'] : 0;
    switch ($flag) {
        case '0':
        ?>
        <button type="submit" class="waves-effect btn btn-outline-primary">
            <i class="fa fa-chevron-right"></i> Continuar
        </button>
        <button class="waves-effect btn btn-outline-danger" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
            <i class="fa fa-times"></i> Cancelar
        </button>
        <?php
        break;
        case 'P':
        ?>
        <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
            <i class="fa fa-plus"></i> Nuevo
        </button>
        <button class="waves-effect btn btn-outline-primary" type="button" onclick="fn_imprimir('<?php echo s_crypt($cc_guia) ?>');">
            <i class="fa fa-print"></i> Imprimir
        </button>
        <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularDocumento('<?php echo s_crypt($cc_guia) ?>','<?php echo s_crypt('A') ?>');">
            <i class="fa fa-times"></i> Anular
        </button>
        <?php if((count($data_deta)>0) and (s_nivel()==='A')){?>
            <button class="waves-effect btn btn-outline-success btn-procesar" type="button" onclick="fn_procesarDocumento('<?php echo s_crypt($cc_guia, 'in'); ?>', '<?php echo s_crypt('P', 'in'); ?>')"> 
                <i class="fa fa-cogs"></i> Kardex
            </button>
        <?php } ?>
        <?php
        break;
        case 'A':
        ?>
        <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
            <i class="fa fa-plus"></i> Nuevo
        </button>
        <?php
        break;
        case 'T':
        ?>
        <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
            <i class="fa fa-plus"></i> Nuevo
        </button>
        <button class="waves-effect btn btn-outline-primary" type="button" onclick="fn_imprimir('<?php echo s_crypt($cc_guia) ?>');">
            <i class="fa fa-print"></i> Imprimir
        </button>
        <?php
        break;
    }
    ?>
</div>