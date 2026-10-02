<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");

s_validar_pagina();
$bo_usuarios      = new bo_seg_usuarios();

$ent_usuarios = new seg_usuarios();
$ent_usuarios->setUsuario(s_usuario());
$data_sua = $bo_usuarios->listarId($ent_usuarios);
foreach ($data_sua as $row) {
    $cc_usuario = $row['cc_usuario'];
    $nombre_completo = $row['nombre'];
    $ct_perfil = $row['ct_perfil'];
    $cc_local_text = $row['cc_local_text'];
    $usuario = $row['usuario'];
    $fech_mod = $row['fech_mod_text'];
    $foto = $row['foto'];
}
?>
<div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
        <img src="images/perfilv1.jpg" class="profile-wid-img" alt="">
    </div>
</div>
<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5">
            <div class="card-body p-4">
                <div class="text-center">
                    <form action="javascript:;" enctype="multipart/form-data" id="frmSubirArchivo" novalidate>
                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                            <img src="images/user/<?php echo $foto ?>"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow"
                                alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input class="d-none" type="file" name="foto" id="foto" onchange="fn_subirArchivo()" accept="image/*">
                                <label for="foto" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body shadow">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="cc_usuario" value="<?php echo s_crypt($cc_usuario, 'in') ?>">
                        <input type="hidden" name="opc" value="<?php echo s_crypt('UPLOAD') ?>">
                    </form>
                    <h5 class="fs-16 mb-2"><?= $nombre_completo ?></h5>
                    <span class="badge bg-primary-subtle text-primary fs-12">
                        <i class="ri-map-pin-line me-1"></i><?= $cc_local_text ?>
                    </span>
                </div>

                <div class="mt-4 pt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-15">
                                <i class="ri-user-3-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-muted mb-0 fs-11 text-uppercase">Usuario</p>
                            <h6 class="mb-0 fs-13 text-truncate"><?= $usuario ?></h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs flex-shrink-0 me-3">
                            <span class="avatar-title bg-light text-success rounded-circle fs-15">
                                <i class="ri-history-line"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-muted mb-0 fs-11 text-uppercase">Última modificación</p>
                            <h6 class="mb-0 fs-13 text-truncate"><?= $fech_mod ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header align-items-center d-flex">
                <i class="ri-user-line text-primary fs-18 me-2"></i>
                <h5 class="card-title mb-0 flex-grow-1">Información Personal</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <p class="text-muted fs-11 text-uppercase mb-1">Nombres</p>
                        <p class="fw-semibold fs-14 mb-0"><?= $nombre_completo ?></p>
                    </div>
                    <div class="col-lg-6">
                        <p class="text-muted fs-11 text-uppercase mb-1">Usuario</p>
                        <p class="fw-semibold fs-14 mb-0"><?= $usuario ?></p>
                    </div>
                    <div class="col-lg-6">
                        <p class="text-muted fs-11 text-uppercase mb-1">Celular</p>
                        <p class="fw-semibold fs-14 mb-0">+51 000 000 000</p>
                    </div>
                    <div class="col-lg-6">
                        <p class="text-muted fs-11 text-uppercase mb-1">Correo</p>
                        <p class="fw-semibold fs-14 mb-0">correo@hotmail.com</p>
                    </div>
                    <div class="col-lg-12">
                        <p class="text-muted fs-11 text-uppercase mb-1">Dirección</p>
                        <p class="fw-semibold fs-14 mb-0 fst-italic text-muted">Sin registrar</p>
                    </div>
                </div>
                <div class="row g-4 mt-2">
                    <div class="col-lg-4">
                        <p class="text-muted fs-11 text-uppercase mb-1"><i class="ri-time-line me-1"></i>Modificación</p>
                        <p class="fw-semibold fs-14 mb-0"><?= $fech_mod ?></p>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted fs-11 text-uppercase mb-1"><i class="ri-shield-user-line me-1"></i>Perfil</p>
                        <p class="fw-semibold fs-14 mb-0 fst-italic text-muted"><?= $ct_perfil ?></p>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-muted fs-11 text-uppercase mb-1"><i class="ri-building-line me-1"></i>Consejo Regional</p>
                        <p class="fw-semibold fs-14 mb-0"><?= $cc_local_text ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <i class="ri-shield-keyhole-line text-primary fs-18 me-2"></i>
                <h5 class="card-title mb-0 flex-grow-1">Seguridad</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="javascript:fn_guardarClave();" id="frmRegistroClave" novalidate>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label for="clave" class="form-label"><i class="ri-lock-password-line me-1"></i> Nueva Clave</label>
                            <input type="password" class="form-control" name="clave" id="clave" placeholder="Ingrese nueva clave" required>
                            <div class="mt-1">
                                <small id="msgClave" class="form-text"></small>
                                <div class="progress mt-1" style="height:6px;">
                                    <div id="barClave" class="progress-bar bg-danger" role="progressbar" style="width:0%;"></div>
                                </div>
                                <small id="reqClave" class="text-muted d-block mt-1"></small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="clave1" class="form-label"><i class="ri-lock-2-line me-1"></i> Repite Clave</label>
                            <input type="password" class="form-control" name="clave1" id="clave1" placeholder="Repita la nueva clave" required>
                            <small id="msgClave1" class="form-text"></small>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-4">
                        <input type="hidden" name="cc_usuario" value="<?= s_crypt($cc_usuario, 'in') ?>">
                        <input type="hidden" name="usuario" value="<?= s_crypt($usuario, 'in') ?>">
                        <input type="hidden" name="opc" value="<?= s_crypt('CN', 'in') ?>">
                        <?php bt_guardar() ?><?php bt_cancelar() ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>