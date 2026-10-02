<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_modulo.php");
$bo_modulo  = new bo_seg_modulo();
$data_tabla = $bo_modulo->lista_tablas();

?>
<div class="container-fluid card">
    <div class="row row-cols-3">
        <div class="text-center col">
            <div class="card-body">
                <h4 class="card-title">BO</h4>
                <form action="javascript:fn_ejecutar('B')">
                    <input type="submit" name="btnEjecutar" value="Ejecutar" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="text-center col">
            <div class="card-body">
                <h4 class="card-title">DAO</h4>
                <form action="javascript:fn_ejecutar('D')">
                    <input type="submit" name="btnEjecutar" value="Ejecutar" class="btn btn-success">
                </form>
            </div>
        </div>
        <div class="text-center col">
            <div class="card-body">
                <h4 class="card-title">Entidades</h4>
                <form action="javascript:fn_ejecutar('E')">
                    <input type="submit" name="btnEjecutar" value="Ejecutar" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <p class="lead">No tocar solo para el programador</p>
        </div>
    </div>
</div>

<div class="container-fluid card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre tabla</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($data_tabla as $tabla) {

                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $tabla['nombre_tabla']; ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="fn_ejecutarXTabla('<?php echo $tabla['nombre_tabla'] ?>','B')">BO</button>
                            <button class="btn btn-success" onclick="fn_ejecutarXTabla('<?php echo $tabla['nombre_tabla'] ?>','D')">DAO</button>
                            <button class="btn btn-info" onclick="fn_ejecutarXTabla('<?php echo $tabla['nombre_tabla'] ?>','E')">Entidad</button>
                        </td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>