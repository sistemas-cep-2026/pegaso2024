<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_recaud_excelbbva.php");

$bo_recaud_excelbbva = new bo_recaud_excelbbva();
$ent_recaud_excelbbva = new recaud_excelbbva();

// Asegura arreglo (evita null en count/empty)
$data_recaudobbva = $bo_recaud_excelbbva->Recaudadora_Excelbbva() ?? [];

$data_ultimaact = $bo_recaud_excelbbva->ultimaActualizacion();
$fecha_act = $data_ultimaact[0]['ultimo'] ?? null;
?>
<div class="row">
    <div class="col-12">
        <?php if (!empty($data_recaudobbva) && is_array($data_recaudobbva) && count($data_recaudobbva) > 0): ?>
          
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código Depositante</th>
                                <th>Concepto</th>
                                <th>Fecha Pago</th>
                                <th>Ope</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($data_recaudobbva as $row): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $row["referencia1"] . '=>' . $row["nombre"] ?></td>
                                    <td><?= $row["referencia2"] ?? ''; ?></td>
                                    <td><?= $row["fecha_pago"] ?? ''; ?></td>
                                    <td><?= $row["num_movimiento"] ?? ''; ?></td>
                                    <td class="text-end"><?= decimal($row["importe1"], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                //ejecutarProcesoBBVA();
            </script>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">
                        Subir el archivo del BBVA
                        <span class="badge bg-info"><?= htmlspecialchars($fecha_act ?? ''); ?></span>
                    </h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card-body">
                        <form id="formImportarBBVA" action="javascript:fn_grabarImportarBBVA();" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-7">
                                    <input type="file" class="form-control" id="archivobbva" name="archivobbva" accept=".txt" required>
                                    <input type="hidden" name="opc" value="I">
                                </div>
                                <div class="col-lg-5 d-flex align-items-end">
                                    <div>
                                        <?= bt_guardar("Enviar"); ?>
                                        <?= bt_cancelar(); ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>