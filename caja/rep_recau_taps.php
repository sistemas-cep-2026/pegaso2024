<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$data_periodo = $bo_general->listarPeridosContables();

?>

<div class="row">
    <div class="col-12">
        <div class="card" id="orderList">

            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">
                            Reportes Cuentas Recaudos BBVA y BCP
                        </h5>
                    </div>
                </div>
            </div>

            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">

                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active"
                            id="home-tab"
                            data-bs-toggle="tab"
                            href="#bbva"
                            role="tab">
                            BANCO BBVA
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                            id="bcp-tab"
                            data-bs-toggle="tab"
                            href="#bcp"
                            role="tab">
                            BANCO BCP
                        </a>
                    </li>

                </ul>

                <div class="tab-content">

                    <!-- BBVA -->
                    <div class="tab-pane active" id="bbva">

                        <div class="container-fluid mt-1">
                            <div class="row">
                                <div class="col-xxl-12">

                                    <form class="needs-validation"
                                        id="frmFormRegistrobbva"
                                        action="javascript:fn_listarBBVA()"
                                        method="post"
                                        novalidate>

                                        <div class="row justify-content-center">

                                            <div class="col-sm-3">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        Tipo :
                                                    </span>

                                                    <select name="c_tipo"
                                                        id="c_tipo_bbva"
                                                        class="form-control"
                                                        onchange="controlarPeriodo('c_tipo_bbva','div_periodo_bbva')"
                                                        required>

                                                        <option value="H">HOY</option>
                                                        <option value="D">DETALLE MES</option>
                                                        <option value="R">RESUMEN</option>
                                                        <option value="S">SOLIDARIO</option>

                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-sm-3" id="div_periodo_bbva">

                                                <div class="input-group mb-3">

                                                    <span class="input-group-text">
                                                        Periodo :
                                                    </span>

                                                    <select name="periodo"
                                                        id="periodo_bbva"
                                                        class="form-control"
                                                        required>

                                                        <?php foreach ($data_periodo as $key) { ?>

                                                            <option value="<?php echo $key['data'] ?>">
                                                                <?php echo $key['data'] ?>
                                                            </option>

                                                        <?php } ?>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-sm-2">
                                                <?php
                                                echo bt_buscar("Buscar");
                                                bt_cancelar("Cancelar");
                                                ?>
                                            </div>

                                        </div>

                                    </form>

                                    <div class="row mb-1">
                                        <div class="col-lg-12 table-responsive">
                                            <div id="divReportebbva"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- BCP -->
                    <div class="tab-pane" id="bcp">

                        <div class="container-fluid mt-1">
                            <div class="row">
                                <div class="col-xxl-12">

                                    <form class="needs-validation"
                                        id="frmFormRegistrobcp"
                                        action="javascript:fn_listarBCP()"
                                        method="post"
                                        novalidate>

                                        <div class="row justify-content-center">

                                            <div class="col-sm-3">

                                                <div class="input-group mb-3">

                                                    <span class="input-group-text">
                                                        Tipo :
                                                    </span>

                                                    <select name="c_tipo"
                                                        id="c_tipo_bcp"
                                                        class="form-control"
                                                        onchange="controlarPeriodo('c_tipo_bcp','div_periodo_bcp')"
                                                        required>

                                                        <option value="H">HOY</option>
                                                        <option value="D">DETALLE MES</option>
                                                        <option value="R">RESUMEN</option>
                                                        <option value="S">SOLIDARIO</option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-sm-3" id="div_periodo_bcp">

                                                <div class="input-group mb-3">

                                                    <span class="input-group-text">
                                                        Periodo :
                                                    </span>

                                                    <select name="periodo"
                                                        id="periodo_bcp"
                                                        class="form-control"
                                                        required>

                                                        <?php foreach ($data_periodo as $key) { ?>

                                                            <option value="<?php echo $key['data'] ?>">
                                                                <?php echo $key['data'] ?>
                                                            </option>

                                                        <?php } ?>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-sm-2">
                                                <?php
                                                echo bt_buscar("Buscar");
                                                bt_cancelar("Cancelar");
                                                ?>
                                            </div>

                                        </div>

                                    </form>

                                    <div class="row mb-1">
                                        <div class="col-lg-12 table-responsive">
                                            <div id="divReportebcp"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<?php
$include_scripts = function () {
    return importDatatable();
};
?>

<script>

function controlarPeriodo(selectId, divId){

    let tipo = document.getElementById(selectId).value;
    let periodo = document.getElementById(divId);

    if(tipo === 'H'){
        periodo.style.display = 'none';
    }else{
        periodo.style.display = 'block';
    }

}

document.addEventListener('DOMContentLoaded', function(){

    controlarPeriodo(
        'c_tipo_bbva',
        'div_periodo_bbva'
    );

    controlarPeriodo(
        'c_tipo_bcp',
        'div_periodo_bcp'
    );

});

</script>