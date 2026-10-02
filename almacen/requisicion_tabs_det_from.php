<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_requisicion.php");
require_once(u_src() . "bo/bo_gen_articulos.php");
 
$opc = 'I';
$bo_items_requisicion = new bo_alm_items_requisicion();
$bo_articulo = new bo_gen_articulos();

$ent_items = new alm_items_requisicion();
$ent_articulo = new gen_articulos();

//$opc=s_crypt($_REQUEST["opc"],'out');
$cc_requisicion = s_crypt($_REQUEST["cc_requisicion"], 'out');
$flag = $_REQUEST["flag"];
if ($flag==='&'){
$ent_items->setCc_requisicion($cc_requisicion);
$data_deta = $bo_items_requisicion->ListarIdGuia($ent_items);

$ent_articulo->setC_local($c_local);
$data_art = $bo_articulo->listarSelect($ent_articulo);

?>

<?php
if ($flag !== 'T') {
    if ($cc_requisicion > '0') { ?>
        <form class="needs-validation" id="frmFormRegistroD" action="javascript:fn_guardarRegistroDetalle()" method="post" novalidate>
            <div class="row d-flex align-items-end">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <div class="input-group mb-3">
                            <input type="hidden" class="form-control" id="c_articulo" name="c_articulo">
                            <input type="text" class="form-control articulo articulo_filtro" id="nombre" name="nombre" placeholder="Nombre artículo" required>
                        </div>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="input-group mb-3"> 
                            <span class="input-group-text">Saldo</span>
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
                            <span class="input-group-text">Cantidad </span>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-12 text-center">
                        <input type="hidden" class="form-control" name="cc_requisicion" id="cc_requisicion" value="<?php echo s_crypt($cc_requisicion, 'in') ?>">
                        <input type="hidden" class="form-control" name="opc" id="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                        <?php echo bt_guardar('Agregar items'); ?>

                    </div>


                </div>

            </div>
        </form>
<?php }
} ?>
<script>
    

var dataSetArticulo = newBloodhound({
  url: 'comun/json_articulo'
});

 
newTypeahead('nombre', dataSetArticulo).on("typeahead:selected", function (e, datum) {
  $('input[name="c_articulo"]').val(datum.c_articulo);
  $('input[name="stock_actual"]').val(datum.stock_actual);
  $('input[name="unidad"]').val(datum.unidad);
});
 

/// Validando el mayor
const stockActualInput = document.getElementById('stock_actual');
const cantidadInput = document.getElementById('cantidad');

    // Agregar evento de cambio al campo "cantidad"
cantidadInput.addEventListener('input', () => {
      const stockActual = parseInt(stockActualInput.value) || 0; // Valor del stock actual
      const cantidad = parseInt(cantidadInput.value) || 0;      // Valor de cantidad

      
});



    $("#frmFormRegistroD").validate();
</script>

<?php }?>