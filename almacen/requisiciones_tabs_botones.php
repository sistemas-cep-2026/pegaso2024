<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_requisicion.php");

$bo_alm_items_requisicion = new bo_alm_items_requisicion();

$ent_requisicion = new alm_items_requisicion();

$cc_requisicion = s_crypt($_REQUEST["cc_requisicion"], 'out');
 
$ent_requisicion->setCc_requisicion($cc_requisicion);
$data_deta = $bo_alm_items_requisicion->ListarIdGuia($ent_requisicion);

?>
<div class="d-grid gap-1">
    <?php

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
        case '&':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="fn_imprimir('<?php echo s_crypt($cc_requisicion) ?>');">
                <i class="fa fa-print"></i> Imprimir 
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularDocumento('<?php echo s_crypt($cc_requisicion) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>
            <?php if((count($data_deta)>0) and (s_nivel()==='A')){?>
            <button class="waves-effect btn btn-outline-success btn-procesar" type="button" onclick="fn_procesarDocumento('<?php echo s_crypt($cc_requisicion, 'in'); ?>', '<?php echo s_crypt('P', 'in'); ?>')"> 
                <i class="fa fa-cogs"></i> Procesar
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
        case '*':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="fn_imprimir('<?php echo s_crypt($cc_requisicion) ?>');">
                <i class="fa fa-print"></i> Imprimir 
            </button>
    <?php
            break;
    }
    ?>
</div>