<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="card border">
    <div class="card-header bg-light-subtle py-2">
        <span class="fs-13 text-muted text-uppercase fw-semibold"><i class="bx bx-cog align-middle me-1"></i> Acciones</span>
    </div>
    <div class="card-body d-grid gap-2">
        <?php
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
            case 'P':
            ?>
                <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('tramite/exp_print?cod=' . s_crypt($cc_docrecibidos)); ?>',750);">
                    <i class="fa fa-print"></i> Imprimir
                </button>
                <!--<button class="waves-effect btn btn-success" type="button" onclick="fn_ArchivarRegistroFrom({cc_docrecibidos:'<?php //echo s_crypt($cc_docrecibidos) 
                                                                                                                                    ?>',opc:'<?php //echo s_crypt('A') 
                                                                                                                                                                                    ?>'});">
                    <i class="fa fa-cogs"></i> Archivar
                </button>-->
                <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                    <i class="fa fa-plus"></i> Nuevo
                </button>
            <?php
                break;

            case 'A':
            ?>
                <button class="waves-effect btn btn-outline-primary" type="button" onclick="redireccionar_ventana('<?php echo url('tramite/exp_print?cod=' . s_crypt($cc_docrecibidos)); ?>',750);">
                    <i class="fa fa-print"></i> Imprimir
                </button>
                <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                    <i class="fa fa-plus"></i> Nuevo
                </button>
            <?php
                break;
            default:
            ?>
                <div class="text-center text-muted fs-13 py-2">
                    <i class="bx bx-error-circle d-block fs-3 mb-1"></i>
                    Estado no reconocido (<?php echo htmlspecialchars($flag); ?>).
                </div>
                <button class="waves-effect btn btn-outline-secondary" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
                    <i class="fa fa-plus"></i> Nuevo
                </button>
        <?php
                break;
        }
        ?>
    </div>
</div>