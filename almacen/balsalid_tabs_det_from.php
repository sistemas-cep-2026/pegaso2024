<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_alm_items_guias_de_salida.php");
require_once(u_src() . "bo/bo_gen_articulos.php");

$opc='I';
$bo_itemguia= new bo_alm_items_guias_de_salida();
$bo_articulo=new bo_gen_articulos();

$ent_itemguia= new alm_items_guias_de_salida();
$ent_articulo=new gen_articulos();

//$opc=s_crypt($_REQUEST["opc"],'out');
$cc_guia=s_crypt($_REQUEST["cc_guia"],'out');
$flag=$_REQUEST["flag"];
if ($flag==='P'){
$ent_itemguia->setCc_guia($cc_guia);
$data_deta=$bo_itemguia->ListarIdGuia($ent_itemguia);

$ent_articulo->setC_local($c_local);
$data_art=$bo_articulo->listarSelect($ent_articulo);

?>

<?php 
if ($flag !== 'T') {
if($cc_guia>'0'){ ?>
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
                        <input type="text" class="form-control" id="unidad" name="unidad"   readonly >
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Cantidad</span>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="input-group mb-3">       <span class="input-group-text">Stock</span>
                        <input type="number" class="form-control" id="stock_actual" name="stock_actual" placeholder="0" readonly >
                    </div>
                </div>
               
            </div>
            <div class="col-md-12 col-12 text-center">
                <input type="hidden" class="form-control" name="cc_guia" id="cc_guia" value="<?php echo s_crypt($cc_guia,'in') ?>">
                <input type="hidden" class="form-control" name="opc" id="opc" value="<?php echo s_crypt($opc,'in') ?>">
                <?php echo bt_guardar('Agregar items'); ?>

            </div>

        </div>
    </form>
<?php } }?>
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

      if (cantidad > stockActual) {
        alert('La cantidad ingresada es mayor que el stock actual.');
        cantidadInput.value = ''; // Opcional: Vaciar el campo cantidad
    }
});

$("#frmFormRegistroD").validate();

</script>
<?php }?>