<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_banc_dietas.php");

$bo_banc_dietas = new bo_banc_dietas();

$ent  = new banc_dietas();


$cc_dietas = s_crypt($_REQUEST["cod"] ?? '', 'out');

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
            <button type="submit" class="waves-effect btn btn-outline-primary">
                <i class="fa fa-sync"></i> Actualizar
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('bancos/dietas_print?cc_dietas=' . s_crypt($cc_dietas)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularRegistroFrom('<?php echo s_crypt($cc_dietas) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>
            <button class="waves-effect btn btn-outline-success" type="button" onclick="fn_procesarRegistro({cc_dietas:'<?php echo s_crypt($cc_dietas) ?>',opc:'<?php echo s_crypt('P') ?>'});">
                <i class="fa fa-cogs"></i> Procesar
            </button>
        <?php
            break;

        case 'I':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button type="submit" class="waves-effect btn btn-outline-primary">
                <i class="fa fa-sync"></i> Actualizar
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('bancos/dietas_print?cc_dietas=' . s_crypt($cc_dietas)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularRegistroFrom('<?php echo s_crypt($cc_dietas) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>

            <button class="waves-effect btn btn-outline-success" type="button" onclick="fn_procesarRegistro({cc_dietas:'<?php echo s_crypt($cc_dietas) ?>',opc:'<?php echo s_crypt('P') ?>'});">
                <i class="fa fa-cogs"></i> Procesar
            </button>
        <?php
            break;
        case '*':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="fn_AbrirRegistroFrom('<?php echo s_crypt($cc_dietas) ?>','<?php echo s_crypt('X') ?>');">
                <i class="fa fa-sync"></i> Abrir
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('bancos/dietas_print?cc_dietas=' . s_crypt($cc_dietas)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>

    <?php
            break;
    }
    ?>
</div>