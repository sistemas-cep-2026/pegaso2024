<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos = new bo_tram_seguimiento_documentos_recibid();
$bo_general = new bo_general();

$ent_doc_recibidos = new tram_seguimiento_documentos_recibid();

$cc_local = s_local();
$usuario = s_usuario();
$cc_docrecibidos = s_crypt($_REQUEST['cc_docrecibidos'] ?? '', 'out');

$est_estado = $bo_parametro_detalle->listarParametroDet('seguimiento_documentos_recibid', 'flag');

$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');

$sede = (s_local() == '28') ? 'CN' : 'CR';
$data_area = $bo_general->AreaAdministrativa($sede);
$data_accion = $bo_general->tram_accion();

$flag = $_REQUEST['flag'] ?? '';
$disabled_global = ($flag == 'A') ? 'disabled' : '';

$ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
$data_detalle = $bo_doc_recibidos->listaIDExp($ent_doc_recibidos);

// Cabecera del expediente: se necesita documento_enviado (aquí se guarda el nombre del PDF)
$bo_exp_cab  = new bo_tram_documentos_recibidos();
$ent_exp_cab = new tram_documentos_recibidos();
$ent_exp_cab->setCc_docrecibidos($cc_docrecibidos);
$documento_enviado = '';
foreach ($bo_exp_cab->listarId($ent_exp_cab) as $cab) {
    $documento_enviado = trim((string) ($cab['documento_enviado'] ?? ''));
}

// Bloqueo del PDF: expediente archivado ('A') o alguna derivación ya recibida ('T') / atendida ('A')
$bloqueo_pdf = ($disabled_global !== '');
foreach ($data_detalle as $det_pdf) {
    $flag_det_pdf = trim((string) ($det_pdf['flag'] ?? ''));
    if ($flag_det_pdf === 'T' || $flag_det_pdf === 'A') {
        $bloqueo_pdf = true;
        break;
    }
}
?>
<fieldset <?php echo $disabled_global; ?>>
    <form id="formGrabarDetalle">
        <table class="table table-borderless table-sm">
            <thead class="table-light">
                <tr class="align-middle">
                    <th>#</th>
                    <th class="col-1">Fecha</th>
                    <th class="col-2">(C) Área Adm</th>
                    <th class="col-1">Estado</th>
                    <th class="col-2">Acción</th>
                    <th class="col-4">Observación</th>
                    <th class="col-1 text-center">O/C</th>
                    <th class="col-1 text-center">
                        <!--<button title="Agregar nuevo ítem" class="btn bg-transparent" type="button" onclick="fn_agregarFila();" <?php echo $disabled_global; ?>>
                            <i class="fas fa-plus fa-lg text-info"></i>
                        </button>-->
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($data_detalle as $detalle):

                    $cc_docrecibidos_enc     = s_crypt($detalle['cc_docrecibidos'], 'in');
                    $cc_docrecibidos_seg_enc = s_crypt($detalle['cc_docrecibidos_det'], 'in');
                    $flag_detalle = $detalle['flag'];
                    $row_disabled = ($flag_detalle == 'A' || $flag_detalle == 'T') ? 'disabled' : '';
                ?>
                    <tr id="row<?php echo $cc_docrecibidos_seg_enc; ?>"
                        class="align-top"
                        <?php echo ($flag_detalle == 'A') ? 'style="background:#f5f5f5;"' : ''; ?>>
                        <input type="hidden" name="cc_docrecibidos" value="<?php echo $cc_docrecibidos_enc; ?>">
                        <input type="hidden" name="cc_docrecibidos_det" value="<?php echo $cc_docrecibidos_seg_enc; ?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $detalle['fecha_entrega_text'] ?? ''; ?></td>
                        <td>
                            <select name="c_area_adm" class="form-control" <?php echo $row_disabled; ?>>
                                <option value="">Seleccione...</option>
                                <?php foreach ($data_area as $are): ?>
                                    <option value="<?php echo $are['cc_area_adm']; ?>"
                                        <?php echo ($detalle['c_area_adm'] === $are['cc_area_adm']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($are['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td>
                            <select name="flag" class="form-control" <?php echo $row_disabled; ?>>
                                <option value="">Seleccione...</option>
                                <?php foreach ($est_estado as $row): ?>
                                    <option value="<?php echo $row['cc_codigo']; ?>"
                                        <?php echo ($detalle['flag'] == $row['cc_codigo']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($row['detalle']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td>
                            <select name="c_accion" class="form-control" <?php echo $row_disabled; ?>>
                                <option value="">Seleccione...</option>
                                <?php foreach ($data_accion as $acc): ?>
                                    <option value="<?php echo $acc['c_accion']; ?>"
                                        <?php echo ($detalle['c_accion'] === $acc['c_accion']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($acc['nombre_accion']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                        <td>
                            <input type="text" name="observacion" class="form-control" value="<?php echo htmlspecialchars($detalle['observacion']); ?>" <?php echo $row_disabled; ?>>
                        </td>

                        <td class="text-center"><?php echo htmlspecialchars($detalle['cod_original']); ?></td>

                        <td class="text-center">
                            <!--<button type="button" class="btn btn-icon bg-transparent" onclick="fn_borrarFila('<?php //echo $cc_docrecibidos_seg_enc; 
                                                                                                                    ?>');"
                                <?php //echo $row_disabled; 
                                ?>> <i class="fa fa-lg fa-trash text-danger"></i>
                            </button>-->
                        </td>
                    </tr>
                <?php
                    $i++;
                endforeach;
                ?>
            </tbody>
        </table>
    </form>
</fieldset>
<?php include __DIR__ . '/exp_file.php'; // fuera del fieldset: el bloqueo lo maneja exp_file.php ?>

<script>
    $(function() {
        var $form = $('#formGrabarDetalle');

        $form.on('change', 'select.form-control:not(.typeahead)', function() {
            var fila = $(this).closest('tr').attr('id');
            if (fila) fn_actualizarFila(fila);
        });

        $form.on('focus', 'input.form-control:not(.typeahead)', function() {
            old_value = $(this).val();
            $(this).select();
        });

        $form.on('blur', 'input.form-control:not(.typeahead)', function() {
            var fila = $(this).closest('tr').attr('id');
            if (fila && $(this).val() !== old_value) fn_actualizarFila(fila);
        });
    });

    function fn_actualizarFila(fila) {
        Swal.fire({
            title: 'Procesando...',
            icon: 'info',
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timerProgressBar: true,
            didOpen: () => Swal.showLoading()
        });

        var str = $('#' + fila + ' :input').serialize();

        ajax("tramite/exp_taps_det_update", `${str}&opcd=<?php echo s_crypt('U') ?>`)
            .then(function(res) {
                if (res !== "0") throw res;
                Swal.close();
                Swal.fire({
                    title: 'Datos actualizados',
                    icon: 'success',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000
                });

            }).catch(function(err) {
                Swal.close();
                Swal.fire({
                    title: `Error: ${err}`,
                    icon: 'error',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 4000
                });
            });
    }

    function fn_borrarFila(cc_docrecibidos_det) {
        fn_controlExp(`cc_docrecibidos_det=${cc_docrecibidos_det}&opcd=<?php echo s_crypt('E'); ?>`);
    }

    function fn_agregarFila() {
        fn_controlExp(`cc_docrecibidos=<?php echo s_crypt($cc_docrecibidos); ?>&opcd=<?php echo s_crypt('I'); ?>`);
    }

    function fn_controlExp(str) {
        swalProcesando();
        ajax("tramite/exp_taps_det_update", str)
            .then(function(res) {
                if (res !== "0") throw res;
                fn_listarDetalleFromExp();
                swalCerrar(750);
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>