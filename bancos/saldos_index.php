<?php

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$data_anho = listarAnhos();
$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0 me-3">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
                            <i class="ri-bank-line"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0">
                            SALDOS SEGÚN EXTRACTO BANCARIO
                        </h4>
                        <p class="text-muted mb-0 fs-13">
                            Registro y consulta de saldos bancarios
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <form class="needs-validation" id="frmListarRegistros" action="javascript:fn_reporte();" method="post" novalidate>
                    <div class="row g-3 align-items-end justify-content-center">
                        <div class="col-lg-2 col-md-3">
                            <label for="cod_anho" class="form-label text-muted fs-13">
                                Año
                            </label>
                            <select name="cod_anho" id="cod_anho" class="form-control form-select">
                                <?php foreach ($data_anho as $row): ?>
                                    <option value="<?php echo $row['anho']; ?>" <?php echo ((int)$row['anho'] === (int)date('Y')) ? 'selected' : ''; ?>>
                                        <?php echo $row['anho']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-lg-5 col-md-6">
                            <label for="c_banco" class="form-label text-muted fs-13">
                                Banco / Cuenta
                            </label>

                            <select name="c_banco" id="c_banco" class="form-control" onchange="submit()">
                                <?php foreach ($data_bancos as $ban): ?>
                                    <option value="<?php echo $ban['c_banco'] . '-' . $ban['c_cta_corriente']; ?>">
                                        <?php echo htmlspecialchars($ban['nombre'] . ' => ' . $ban['c_cta_corriente']);
                                        ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <?php echo bt_filtrar(); ?>
                            <?php echo bt_cancelar(); ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-3">
                <div id="divRepor"></div>
            </div>
        </div>
    </div>
</div>

<?php

$include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
};

?>