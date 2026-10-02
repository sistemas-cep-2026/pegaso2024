 <?php
    require_once(dirname(__DIR__) . "/util/seguridad.php");
    require_once(dirname(__DIR__) . "/util/util.php");
    s_validar_pagina();
    require_once(u_src() . "bo/bo_banc_beneficiofam.php");
    require_once(u_src() . "bo/bo_general.php");

    $bo_general = new bo_general();
    $bo_fam = new bo_banc_beneficiofam();

    $ent_fam = new banc_beneficiofam();

    $cc_local = (s_local() == 28) ? '' : (s_local() ?? '');

    $cod_anho = $_REQUEST['cod_anho'] ?? '';
    $cod_mes = $_REQUEST['cod_mes'] ?? '';

    $ent_fam->setCod_anho($cod_anho);
    $ent_fam->setCod_mes($cod_mes);
    $ent_fam->setCc_local($cc_local);
    $data_fam = $bo_fam->listar($ent_fam);
    $estado_fam_text = ['P' => 'Registrado'];
    ?>
 <div class="table-responsive">
     <table class="table align-middle" id="table-fam">
         <thead class='table-light'>
             <tr>
                 <th class="col-1">#</th>
                 <th class="col-1">Fecha</th>
                 <th class="col-2">Beneficiario</th>
                 <th class="col-1">Tipo</th>
                 <th class="col-3">Referencia</th>
                 <th class="col-3">Datos financieros</th>
                 <th class="col-1">Estado</th>
             </tr>
         </thead>
         <tbody>
             <?php
                $i = 1;
                foreach ($data_fam as $row) {
                    $partes_banco = explode('-', trim((string) $row['c_banco']), 2);
                    $cuenta_bancaria = $partes_banco[1] ?? $row['c_banco'];
                    $estado_label = $estado_fam_text[$row['flag']] ?? $row['flag'];
                    $estado_color = $color_flag_listar[$row['flag']] ?? 'secondary';
                ?>
                 <tr>
                     <td><?= $i ?></td>
                     <td><?= htmlspecialchars($row['fecha_crea']) ?></td>
                     <td>[<?= htmlspecialchars($row['cep']) ?>] <?= htmlspecialchars($row['nombre_completo']) ?></td>
                     <td><?= htmlspecialchars($row['cod_tipo_text']) ?></td>
                     <td><?= htmlspecialchars($row['referencia']) ?></td>
                     <td>
                         <div class="fw-semibold text-success"><i class="bx bx-money"></i> S/ <?= decimal($row['monto'], 2) ?></div>
                         <div class="fs-12 text-muted">Cta: <?= htmlspecialchars($cuenta_bancaria) ?></div>
                         <div class="fs-12 text-muted">Ope: <?= htmlspecialchars($row['operacion']) ?> — <?= htmlspecialchars($row['fecha_operacion']) ?></div>
                     </td>
                     <td><span class="badge bg-<?= $estado_color ?>-subtle text-<?= $estado_color ?> fs-6 px-3 py-2">
                             <?= htmlspecialchars($estado_label) ?>
                         </span></td>
                 </tr>
             <?php $i++;
                } ?>
         </tbody>
     </table>
 </div>