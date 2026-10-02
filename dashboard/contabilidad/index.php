 <?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();
?>
 <div class="row">
    <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">CONTABILIDAD</p>
                        <h2 class="mt-4 ff-secondary fw-semibold">LIBROS CONTABLES</h2>
                        <a href="?id=<?php echo s_crypt('900010','in') ?>" class="btn btn-ghost-success waves-effect waves-light shadow-none">VER LIBROS</a>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                <i class='fas fa-tags text-info'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
     <div class="col-md-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">xxx</p>
                        <h2 class="mt-4 ff-secondary fw-semibold">xx</h2>
                        <a href="#" class="btn btn-ghost-success waves-effect waves-light shadow-none">VER LIBROS</a>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                <i class='fas fa-tags text-info'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->

</div>