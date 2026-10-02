<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_banc_excel_migrar.php");
$bo_excel_migrar = new bo_banc_excel_migrar();
$registros = $bo_excel_migrar->listar();
?>
<?php if (empty($registros)): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="ri-information-line align-bottom me-2"></i>
        <strong>Sin registros cargados</strong> — No hay datos en la tabla de migración.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php else: ?>
    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-hover table-sm">
            <thead class="table-light sticky-top">
                <tr class="align-middle">
                    <th style="width: 4%;">#</th>
                    <th style="width: 9%;">Fecha</th>
                    <th style="width: 11%;">N° OP</th>
                    <th style="width: 9%;" class="text-end">Monto</th>
                    <th style="width: 14%;">Ref. 1</th>
                    <th style="width: 14%;">Ref. 2</th>
                    <th style="width: 15%;">Banco</th>
                    <th style="width: 12%;">Cta. Contable</th>
                    <th style="width: 12%;">Cta. Bancaria</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($registros as $reg):
                ?>
                    <tr class="align-middle">
                        <td><?php echo $i; ?> </td>
                        <td> <small><?php echo $reg['fecha']; ?></small> </td>
                        <td> <small><?php echo trim($reg['numero_operacion']); ?></small> </td>
                        <td class="text-end"> <small><?php echo decimal($reg['monto'], 2); ?></small> </td>
                        <td> <small title="<?php echo htmlspecialchars($reg['referencia01']); ?>">
                                <?php echo htmlspecialchars(substr(trim($reg['referencia01']), 0, 20)); ?>
                            </small>
                        </td>
                        <td> <small title="<?php echo htmlspecialchars($reg['referencia02']); ?>">
                                <?php echo htmlspecialchars(substr(trim($reg['referencia02']), 0, 20)); ?>
                            </small>
                        </td>
                        <td> <small><?php echo htmlspecialchars(trim($reg['banco'])); ?></small> </td>
                        <td> <small><?php echo htmlspecialchars(trim($reg['cuenta_contable'])); ?></small> </td>
                        <td> <small><?php echo htmlspecialchars(trim($reg['cuenta_bancaria'])); ?></small> </td>
                    </tr>
                <?php
                    $i++;
                endforeach;
                ?>
            </tbody>
            <tfoot class="table-light">
                <tr class="fw-bold">
                    <td colspan="9">
                        <i class="ri-file-list-line align-bottom me-1"></i>
                        Total de registros: <strong><?php echo count($registros); ?></strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php endif; ?>