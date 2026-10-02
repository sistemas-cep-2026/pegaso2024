<?php
require_once dirname(__DIR__) . '/entidad/tram_permisos.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_permisos
{
    private $conecta;

    function __construct()
    {
        $this->conecta = new Conecta();
    }

    public function consulta($sql)
    {
        return $this->conecta->ArrayLista($sql);
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    public function insertar(tram_permisos $obj)
    {
        $sql = "INSERT INTO tram_permisos (
            tipo_permisos,
            fecha,
            fecha_ida,
            fecha_retorno,
            cc_usuario_e,
            cc_area_adm,
            motivo,
            obs,
            flag,
            destinos,
            c_local,
            user_crea,
            fech_crea )
        VALUES (
            '{$obj->getTipo_permisos()}',
            '{$obj->getFecha()}',
            '{$obj->getFecha_ida()}',
            '{$obj->getFecha_retorno()}',
            '{$obj->getCc_usuario_e()}',
            '{$obj->getCc_area_adm()}',
            '{$obj->getMotivo()}',
            '{$obj->getObs()}',
            '{$obj->getFlag()}',
            '{$obj->getDestinos()}',
            '{$obj->getC_local()}',
            '{$obj->getUser_crea()}',
            GETDATE())";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(tram_permisos $obj)
    {

        $sql = "UPDATE tram_permisos SET
            flag = 'A',
            user_anula='{$obj->getUser_crea()}',
            fech_anula=GETDATE()
        WHERE cc_permisos = {$obj->getCc_permisos()}";
        return $this->conecta->sql_query($sql);
    }
}
