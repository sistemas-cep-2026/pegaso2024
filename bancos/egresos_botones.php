<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_compras = new bo_comp_documentos_de_compras();

$ent_compras = new comp_documentos_de_compras();

//$cc_compra=s_crypt($_REQUEST["cod"],'out');
$cc_compra = s_crypt($_REQUEST["cod"] ?? '', 'out');
//echo $cc_compra;
?>
<div class="d-grid gap-1">
    <?php
    //echo $id;
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
        case '&':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button type="submit" class="waves-effect btn btn-outline-primary">
                <i class="fa fa-sync"></i> Actualizar
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('bancos/rep_bancos_print?cod=' . s_crypt($cc_compra)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularRegistroFrom('<?php echo s_crypt($cc_documento) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>
            <button class="waves-effect btn btn-outline-success" type="button" onclick="fn_procesarRegistro({cc_documento:'<?php echo s_crypt($cc_documento) ?>',opc:'<?php echo s_crypt('P') ?>'});">
                <i class="fa fa-cogs"></i> Procesar
            </button>
        <?php
            break;

        case 'U':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button type="submit" class="waves-effect btn btn-outline-primary">
                <i class="fa fa-sync"></i> Actualizar
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('bancos/rep_bancos_print?cod=' . s_crypt($cc_compra)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularRegistroFrom('<?php echo s_crypt($cc_documento) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>

            <button class="waves-effect btn btn-outline-success" type="button" onclick="fn_procesarRegistro({cc_documento:'<?php echo s_crypt($cc_documento) ?>',opc:'<?php echo s_crypt('P') ?>'});">
                <i class="fa fa-cogs"></i> Procesar
            </button>
        <?php
            break;
        case '*':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="fn_AbrirRegistroFrom('<?php echo s_crypt($cc_documento) ?>','<?php echo s_crypt('X') ?>');">
                <i class="fa fa-sync"></i> Abrir
            </button>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('bancos/rep_bancos_print?cod=' . s_crypt($cc_compra)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>

        <?php
            break;
        case 'A':
        ?>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
    <?php
            break;
    }
    ?>
</div>