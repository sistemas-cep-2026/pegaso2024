 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();

    $cod_anho = $_REQUEST['cod_anho'];
    $cod_mes = $_REQUEST['cod_mes'];
    $cc_local = s_local();
    ?>
 <div class="modal-header">
     <h4 class="modal-title">INGRESOS DIRECTOS <?php echo $cod_mes.'/'.$cod_anho; ?></h4>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
 </div>
 <div class="modal-body">
     <form action="javascript:fn_GuardarRegistro();" id="frmGuardarRegistro" novalidate>
         <div class="row">
             <div class="col-md-12 col-12">
                 <div class="input-group">
                     <span class="input-group-text">S/. : </span>
                     <input type="text" class="form-control input-decimal" name="monto" id="monto" value="" placeholder="S/. 0.00" required>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="modal-footer text-center">
                 <input type="hidden" name="cod_anho" id="cod_anho" value="<?= $cod_anho ?>">
                 <input type="hidden" name="cod_mes" id="cod_mes" value="<?= $cod_mes ?>">
                 <input type="hidden" name="cc_local" id="cc_local" value="<?= $cc_local ?>">
                 <input type="hidden" name="opc" id="opc" value="I">
                 <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
             </div>
         </div>
     </form>
 </div>
<script>

    $("#frmGuardarRegistro").validate();
    
    $('.input-decimal').inputmask({
        alias: "decimal",
        integerDigits: 10,
        digits: 2,
        allowMinus: false,
        digitsOptional: false,
        placeholder: "0.00",
        groupSeparator: ',',
        prefix: 'S/ ',
        autoGroup: true,
    });

    function fn_GuardarRegistro() {
        swalProcesando();
        var str = $("#frmGuardarRegistro").serialize();
        ajax('caja/concilia_coti_update', str)
        .then(function(res) {
            if (res!= '0') {
                throw res;
            }
            swalOk(750);
            modalRegistroSm.hide();
            fn_buscarRegistro();
        }).catch(function(err) {
            swalError(err);
        });
    }

</script>