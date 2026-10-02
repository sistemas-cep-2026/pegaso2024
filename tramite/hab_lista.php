<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
    <div class="col-md-12 pt-2">
        <form action="javascript:fn_listarRegistroHabilitaciones();" id="frmListarRegistroHabilitaciones" novalidate>
            <div class="row d-flex align-items-end">
                <div class="col-md-6">
                    <label for="" class="form-label">CEP o Apellidos y nombres</label>
                    <input type="text" class="form-control" id="nombre_persona" name="nombre_persona" placeholder="CEP o Apellidos y nombres" value="" required>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Tipo de habilitación</label>
                    <select name="c_tipo" id="c_tipo" class="form-control form-select" onchange="this.form.submit();" required>
                        <?php foreach ($arr_tipo_docs as $tipo_doc) { ?>
                            <option value="<?= $tipo_doc["c_tipo_de_documento"] ?>"
                                <?php ''; ?>><?= $tipo_doc["nombre"] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <?= bt_buscar() ?>
                    <?= bt_cancelar() ?>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12 pt-2 table-responsive" id="divListarHabilitaciones"></div>
</div>