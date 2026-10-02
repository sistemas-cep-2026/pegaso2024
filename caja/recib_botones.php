<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_compras = new bo_comp_documentos_de_compras();
$ent_compras = new comp_documentos_de_compras();

$cc_ventas = s_crypt($_REQUEST["cod"] ?? '', 'out');

?>
<div class="card border">
    <div class="card-header bg-light-subtle py-2">
        <span class="fs-13 text-muted text-uppercase fw-semibold"><i class="bx bx-cog align-middle me-1"></i> Acciones</span>
    </div>
    <div class="card-body d-grid gap-2">
    <?php
    $i = isset($_POST['total_detalle']) ? (int)$_POST['total_detalle'] : 0;
    switch ($flag) {
        case '0':
    ?>
            <button type="submit" class="waves-effect btn btn-primary">
                <i class="fa fa-chevron-right"></i> Continuar
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-times"></i> Cancelar
            </button>
        <?php
            break;
        case '&':
        ?>
            <button id="btnProcesar" class="waves-effect btn btn-success"
                type="button" disabled
                onclick="fn_procesarRegistro('<?php echo s_crypt($cc_ventas, 'in'); ?>','<?php echo s_crypt('P', 'in'); ?>');">
                <i class="fa fa-cogs"></i> Procesar
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularRegistroFrom('<?php echo s_crypt($cc_ventas) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
        <?php
            break;
        case '*':
        ?>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('caja/recib_print?cod=' . s_crypt($cc_ventas)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button class="waves-effect btn btn-outline-danger" type="button" onclick="fn_anularRegistroFrom('<?php echo s_crypt($cc_ventas) ?>','<?php echo s_crypt('A') ?>');">
                <i class="fa fa-times"></i> Anular
            </button>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
        <?php
            break;
        case 'A':
        ?>
            <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('caja/recib_print?cod=' . s_crypt($cc_ventas)); ?>',750);">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                <i class="fa fa-plus"></i> Nuevo
            </button>
    <?php
            break;
    }
    ?>
    </div>
</div>