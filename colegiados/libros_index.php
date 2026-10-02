<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_det = new bo_gen_parametro_det();
$data_grados = $bo_det->listarParametroDet('personas','tipo_grado');
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h4>Libros</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:fn_buscarLibros()" id="frmListarLibros">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                            <label for="" class="form-label">Tipo</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php
                                foreach ($data_grados as $grados) {
                                    ?>
                                    <option value="<?php echo $grados['cc_codigo']; ?>"><?php echo $grados['detalle']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="form-label">Inicio folio</label>
                            <input type="text" name="desde" id="desde" class="form-control" placeholder="#" required>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="form-label">Fin folio</label>
                            <input type="text" name="hasta" id="hasta" class="form-control" placeholder="#" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                <div id="divListarLibro" class="pt-2 table-responsive"></div>
            </div>
        </div>
    </div>
</div>