<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_tram_permisos.php");
$bo_permisos = new bo_tram_permisos();

$ent_permisos = new tram_permisos();

$tipo      = $_REQUEST['tipo_permisos'] ?? '';
$cod_anho = $_REQUEST['cod_anho'] ?? date('Y');
$perido = $_REQUEST['periodo'] ?? '';

$cc_local = s_local();
$c_local  = ($cc_local === '28') ? '' : $cc_local;

$ent_permisos->setTipo_permisos($tipo);
$ent_permisos->setCod_anho($cod_anho);
$ent_permisos->setPeriodo($perido);
$ent_permisos->setC_local($c_local);

$data_permisos = $bo_permisos->listar($ent_permisos);

$headerReporte = "<h2 class='text-center'>Registros Permisos</h2>";
echo "<script>var headerContent = `" . $headerReporte . "`;</script>";
?>

<div class="table-responsive">
    <table class="table table-hover table-sm" id="table-reporte">
        <thead class="table-light">
            <tr>
                <th>CODIGO</th>
                <th>TIPO PERMISO</th>
                <th>USUARIO SOLICITANTE</th>
                <th>FEC. EMISIÓN</th>
                <th>TIEMPO</th>
                <th>MOTIVO</th>
                <th>ESTADO</th>
                <th class="text-end">OP</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $estados_color = [
                '&' => 'info',
                '*' => 'success',
                'A' => 'danger'
            ];

            foreach ($data_permisos as $row) { ?>
                <tr>
                    <td><?= $row["cc_permisos"] ?></td>
                    <td><?= $row["tipo_permisos_text"] ?></td>
                    <td><?= $row["cc_usuario_e"] . ' | ' . $row["nombre"] ?></td>
                    <td><?= $row["fecha_emi"] ?></td>
                    <td><?= $row["salida"] . " - " . $row["retorno"] ?></td>
                    <td><?= $row["motivo"] ?></td>
                    <td class="text-center">
                        <?php
                        $flag = $row["flag"];
                        $flag_text = $row["flag_text"] ?? $flag;
                        echo u_estado($flag_text, $estados_color[$flag] ?? 'secondary');
                        ?>
                    </td>
                    <td class="text-end">
                        <a href="#" onclick="fn_imprimir('<?php echo s_crypt($row['cc_permisos'], 'in') ?>')" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir"><i class="fa-solid fa-print"></i></a>

                        <?php if ($row["flag"] == '*'): ?>
                            <?php if (s_nivel() === 'A'): ?>
                                <a href="#" onclick="fc_anular('<?= s_crypt($row['cc_permisos']); ?>','<?= s_crypt('A'); ?>')" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"><i class="fa-solid fa-circle-xmark"></i>
                                </a>
                        <?php endif;
                        endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>