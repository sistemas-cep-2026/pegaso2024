<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/class_upload.php");

try {

    $uploader = new Upload($archivo_cargado);
    if ($uploader->uploaded) {
        $uploader->file_new_name_body = $nombre_archivo;
        $uploader->file_overwrite = TRUE;
        if ($tipo_archivo == 'FOT') {
            $uploader->image_resize = TRUE;
            $uploader->image_convert = 'jpg';
            $uploader->image_ratio_crop  = TRUE;
            $uploader->image_crop  = '0 2';
            $uploader->image_x = 203;
            $uploader->image_y = 270;
        }
        $uploader->Process($ruta_carpeta);
        if (!$uploader->processed) {
            throw new Exception($foo->error);
        }
        $uploader->clean();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
