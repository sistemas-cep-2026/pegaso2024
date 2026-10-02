<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_guias_de_entrada.php");
require_once(u_src() . "bo/bo_gen_articulos.php");

$bo_itemguia = new bo_alm_items_guias_de_entrada();
$bo_articulo = new bo_gen_articulos();

$ent_itemguia = new alm_items_guias_de_entrada();
$ent_articulo = new gen_articulos();

//$opc=s_crypt($_REQUEST["opc"],'out');
$cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
$flag = $_REQUEST["flag"];

if ($flag === 'P') {
    $ent_itemguia->setCc_guia($cc_guia);
    $data_deta = $bo_itemguia->ListarIdGuia($ent_itemguia);

    $ent_articulo->setC_local($c_local);
    $data_art = $bo_articulo->listarSelect($ent_articulo);

    if ($flag === 'P') {
        if ($cc_guia > '0') { ?>
            <form class="needs-validation" id="frmFormRegistroD" action="javascript:fn_guardarRegistroDetalle()" method="post" novalidate>
                <div class="row d-flex align-items-end">
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" id="c_articulo" name="c_articulo">
                                <input type="text" class="form-control articulo articulo_filtro" id="nombrearti" name="nombrearti" placeholder="Nombre artículo" required>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="input-group mb-3"> <span class="input-group-text">Saldo</span>
                                <input type="number" class="form-control" id="stock_actual" name="stock_actual" placeholder="0" readonly>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="unidad" name="unidad" readonly>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Cantidad</span>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12 text-center">
                        <input type="hidden" class="form-control" name="cc_guia" id="cc_guia" value="<?php echo s_crypt($cc_guia, 'in') ?>">
                        <input type="hidden" class="form-control" name="opc" id="opc" value="<?php echo s_crypt('I', 'in') ?>">
                        <?php echo bt_guardar('Agregar items'); ?>

                    </div>

                </div>
            </form>
    <?php }
    } ?>
    <script>
        const articulos_art = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: `${hostname}comun/json_articulo`,
                replace: (url, query) => `${url}?query=${encodeURIComponent(query)}`,
                rateLimitWait: 750,
            },
        });

        articulos_art.initialize();

        // Opciones para Typeahead
        const typeaheadOptions_Art = {
            hint: true,
            highlight: true,
            minLength: 5,
        };

        // Opciones para la fuente de datos
        const nameOptions_Art = {
            name: "articulos",
            display: "nombres",
            source: articulos_art.ttAdapter(),
            limit: 15,
            templates: templates,
        };
        // Inicializar Typeahead
        $("#nombrearti")
            .typeahead(typeaheadOptions_Art, nameOptions_Art)
            .bind("typeahead:selected", function(obj, datum) {
                // Actualizar valores en los campos de entrada
                $('input[name="c_articulo"]').val(datum.c_articulo);
                $('input[name="stock_actual"]').val(datum.stock_actual);
                $('input[name="unidad"]').val(datum.unidad);
            });

        $("#frmFormRegistroD").validate();
    </script>
<?php } ?>