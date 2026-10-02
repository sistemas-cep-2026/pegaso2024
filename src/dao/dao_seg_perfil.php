<?php
require_once dirname(__DIR__) . '/entidad/seg_perfil.php';
require_once(u_src() . "dao/_conexa_.php");
class dao_seg_perfil
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

    public function insertar(seg_rol $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(seg_rol $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(seg_rol $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}