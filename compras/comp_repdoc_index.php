<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$data_anho = listarAnhos();
$periodo = u_meses();

$cc_local = s_local();
$usuario = s_usuario();

$data_region = $bo_general->listarRegionesAdministrativo(
    $cc_local,
    $usuario,
    'A'
);
?>

<div class="row">
    <div class="col-lg-12">

        <div class="card" id="orderList">

            <!-- CABECERA -->
            <div class="card-header border-0">

                <div class="row align-items-center gy-3">

                    <div class="col-sm">
                        <h5 class="card-title mb-0">
                            Documentos x Proveedor
                        </h5>
                    </div>

                </div>

            </div>


            <!-- FORMULARIO -->
            <div class="card-body border border-dashed border-end-0 border-start-0">

                <form method="post"
                      action="javascript:fn_buscarRegistro();"
                      id="frmFormRegistro"
                      novalidate>

                    <div class="row g-3 justify-content-center">

                        <!-- CHECKBOX TODOS -->
                        <div class="col-sm-2">

                            <div class="form-check mt-2">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="chk_todos"
                                    name="todos"
                                    value="1"
                                    onchange="fn_mostrarTodos();"
                                >

                                <label
                                    class="form-check-label"
                                    for="chk_todos">
                                    Todos los Consejos
                                </label>

                            </div>

                        </div>


                        <!-- CONSEJO -->
                        <div id="div_consejo" class="col-sm-3">

                            <select
                                name="cc_local"
                                id="cc_local"
                                class="form-control"
                                required
                                onchange="submit()"
                            >

                                <?php foreach ($data_region as $loc) { ?>

                                    <option
                                        value="<?= $loc['c_local']; ?>"
                                        <?= (
                                            $loc['c_local'] ===
                                            s_local_vinculado()
                                        ) ? 'selected' : '' ?>
                                    >

                                        <?= $loc['nombre']; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- AÑO -->
                        <div id="div_anho" class="col-sm-1">

                            <select
                                name="anho"
                                id="anho"
                                class="form-control"
                            >

                                <?php foreach ($data_anho as $row) { ?>

                                    <option
                                        value="<?= $row['anho']; ?>"
                                        <?= (
                                            $row['anho'] == date("Y")
                                        ) ? 'selected' : '' ?>
                                    >

                                        <?= $row['anho']; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- FLAG TODOS -->
                        <input
                            type="hidden"
                            name="flag_todos"
                            id="flag_todos"
                            value="0"
                        >


                        <!-- RUC / RAZÓN SOCIAL -->
                        <div class="col-xxl-3 col-sm-3">

                            <div class="search-box">

                                <input
                                    type="hidden"
                                    class="form-control"
                                    name="cc_persona"
                                    id="cc_persona"
                                    value=""
                                >

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="RUC - Razón Social"
                                    value=""
                                    required
                                >

                                <i class="ri-search-line search-icon"></i>

                            </div>

                        </div>


                        <!-- BOTONES -->
                        <div class="col-xxl-3 col-sm-6">

                            <?php echo bt_filtrar("Buscar"); ?>

                            <button
                                type="button"
                                class="btn btn-outline-warning waves-effect"
                                onclick="location.reload();"
                            >

                                <i class="fas fa-ban"></i>

                                <span>
                                    Cancelar
                                </span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>


            <!-- RESULTADO -->
            <div class="col-xxl-12">

                <div class="card-body">

                    <div id="div_documentos"></div>

                </div>

            </div>

        </div>

    </div>
</div>


<?php

$include_scripts = function () {

    return importDatatable() . importTypeahead();

};

?>


<script>

function fn_mostrarTodos() {

    var checked = $("#chk_todos").is(":checked");

    if (checked) {

        // ==========================================
        // OCULTAR CONSEJO
        // ==========================================
        $("#div_consejo").hide();


        // ==========================================
        // OCULTAR AÑO
        // ==========================================
        $("#div_anho").hide();


        // ==========================================
        // QUITAR REQUIRED
        // ==========================================
        $("#cc_local").prop("required", false);


        // ==========================================
        // INDICAR QUE ES TODOS
        // ==========================================
        $("#flag_todos").val("1");

    } else {

        // ==========================================
        // MOSTRAR CONSEJO
        // ==========================================
        $("#div_consejo").show();


        // ==========================================
        // MOSTRAR AÑO
        // ==========================================
        $("#div_anho").show();


        // ==========================================
        // VOLVER A REQUIRED
        // ==========================================
        $("#cc_local").prop("required", true);


        // ==========================================
        // INDICAR QUE NO ES TODOS
        // ==========================================
        $("#flag_todos").val("0");

    }

}


/*
 * OPCIONAL:
 * Si quieres que al cargar la página se respete
 * el estado inicial del checkbox.
 */
$(document).ready(function () {

    fn_mostrarTodos();

});

</script>