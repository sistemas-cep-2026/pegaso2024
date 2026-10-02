<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personas = new bo_gen_personas();

$ent_personas = new gen_personas();

if (s_nivel() == 'A') {
    $usuario = '';
} else {
    $usuario = s_usuario();
}

$cc_persona = s_crypt($_REQUEST['c_persona'], 'out');

if (empty($cc_persona)) {
    exit(errors());
}

if (!is_numeric($cc_persona)) {
    exit(errors('Error'));
}

$data_deudax = $bo_personas->Actualiza_deuda($cc_persona);
$data_persona = $bo_personas->listarShowID($cc_persona);
foreach ($data_persona as $per) {
    $cod_documento = $per["cod_documento"];
    $num_documento = $per["num_documento"];
    $nombre = $per["nombre_completo"];
    $cep = $per["c_cmp"];
    $habil = $per["flag_habil"];
    $habil_text = $per["flag_habil_text"];
    $correo = $per["Email1"];
    $celular = $per["celular1"];
    $fecha_colegiacion = $per["fecha_colegiacion"];
    $fecha_nacimiento = $per["fecha_nacimiento"];
    $ent_pagadora = $per["ent_pagadora"];
    $estado = $per["flag_activo_text"];
    $c_local_texto = $per["c_local_text"];
    $edad = $per["edad"];
    $edad_meses = $per["edad_meses"];
    $abono_favor = $per["abono_favor"];
    $cc_persona = $per["c_persona"];
}
$foto = buscarFoto($num_documento);
?>
<input type="hidden" name="cc_persona" id="cc_persona" value="<?php echo s_crypt($cc_persona, 'in') ?>">
<div id="print-section" class="print-section">
    <div class="row p-0">
        <div class="col-md-1">
            <div class="row g-3 justify-content-end">
                <img src="<?php echo $foto ?>" alt="" class="avatar-lg img-thumbnail shadow">
                <span class="contact-active position-absolute rounded-circle bg-success"><span class="visually-hidden"></span>
                </span>
            </div>
        </div>
        <div class="col-md-11">
            <div class="row p-0 ">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush small-list">
                        <li class="list-group-item py-1 border-0"><i class="ri-file-list-line"></i> CEP : <strong class="fs-5"><?php echo $cep ?></strong></li>
                        <li class="list-group-item py-1 border-0"><i class="ri-file-list-line"></i> DOC : <strong><?php echo $cod_documento . " : " . $num_documento ?></strong></li>
                        <li class="list-group-item py-1 border-0"><i class="ri-user-line"></i> Nombre : <strong class="fs-5"><?php echo $nombre ?></strong> </li>
                        <li class="list-group-item py-1 border-0"><i class="ri-award-line"></i> Correo : <strong><?php echo $correo ?></strong></li>
                        <li class="list-group-item py-1 border-0"><i class="ri-phone-line"></i> Celular : <strong><?php echo $celular ?></strong></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group list-group-flush small-list">
                        <li class="list-group-item py-1 border-0"><strong><?php echo $c_local_texto ?> </strong></li>
                        <li class="list-group-item py-1 border-0">FECHA RESOL : <strong><?php echo $fecha_colegiacion ?></strong> </li>
                        <li class="list-group-item py-1 border-0">ENTIDAD : <strong><?php echo $ent_pagadora ?></strong></li>
                        <li class="list-group-item py-1 border-0">ESTADO : <strong class="fs-6 <?php echo ($habil == 'H') ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $habil_text . " => " . $abono_favor . " [ " . $estado . " ]"  ?></strong></li>
                        <li class="list-group-item py-1 border-0">FECHA NAC. : <strong><?php echo $fecha_nacimiento . " [ " . $edad . "A " . $edad_meses . "M ]" ?></strong> ID: <?php echo $cc_persona; ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="row p-3">
        <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#estcuenta" onclick="fn_EstadodeCuenta()" role="tab" aria-selected="false">
                    <i class="fas fa-balance-scale-left me-1"></i> Est. cuenta
                </a>
            </li>
      
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#pagos" onclick="fn_pagoshistoricos()" role="tab" aria-selected="false">
                    <i class="fas fa-comment-dollar me-1"></i> Pagos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#habilitaciones" role="tab" aria-selected="false" onclick="fn_habilitaciones()">
                    <i class="far fa-file-alt me-1"></i> Habilitaciones
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#fraccionamientos" onclick="fn_ListarFraccionamientos()" role="tab" aria-selected="false">
                    <i class="fas fa-code-branch me-1"></i> Fraccionamientos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#exoneraciones" onclick="fn_ListarExoneraciones()" role="tab" aria-selected="false">
                    <i class="fas fa-code-branch me-1"></i> Exoneraciones
                </a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#beneficiofam" onclick="fn_BeneficoFam()" role="tab" aria-selected="false">
                    <i class="fas fa-book-reader me-1"></i> Benefio FAM
                </a>
            </li>
        </ul>
        <div class="tab-content text-muted">
            <div class="tab-pane active" id="estcuenta" role="tabpanel">
                <div id="div_estadocuenta"></div>
            </div>
        
           
            <div class="tab-pane" id="pagos" role="tabpanel">
                <div id="div_pagoshistorico"></div>
            </div>
            <div class="tab-pane" id="habilitaciones" role="tabpanel">
                <div id="div_listarHabilitaciones"></div>
            </div>
            <div class="tab-pane" id="exoneraciones" role="tabpanel">
                <div id="div_listarExoneraciones"></div>
            </div>
            <div class="tab-pane" id="fraccionamientos" role="tabpanel">
                <div id="div_listarFraccionamientos"></div>
            </div>

            <div class="tab-pane" id="beneficiofam" role="tabpanel">
                <div id="div_beneficiofam"></div>
            </div> 
        </div>
    </div>
</div>
<div class="flex-grow-1 ms-2 text-center">
    <?php echo bt_imprimirDiv(); ?>
</div>