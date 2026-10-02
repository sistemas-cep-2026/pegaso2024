 <?php
    $foto = $_REQUEST["foto"];
    $dni = $_REQUEST["dni"];
    $nombre = $_REQUEST["nombre"];
    ?>
 <div class="modal-header">
        <h5 class="modal-title">FOTO DE COLEGIADO <?= $dni ?> - <?= $nombre ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>
 <div class="modal-body">
     <div class="row">
         <div class="text-center col-sm-12 ">
             <img src="<?= $foto ?>" class="img-thumbnail" class="rounded img-fluid material-shadow" onerror="this.onerror=null; this.src='images/sinfoto.jpg';">
         </div>
     </div>
 </div>