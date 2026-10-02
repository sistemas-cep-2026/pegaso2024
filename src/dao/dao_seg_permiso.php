<?php
require_once(u_src()."dao/_conexa_.php");
require_once(u_src()."entidad/seg_permiso.php");
class dao_seg_permiso
{
    private $conecta;

    function __construct()
    {
        $this->conecta = new Conecta();
    }

    public function actualizarPermisoModulo(seg_permiso $obj)
    {
        $sql = "UPDATE seg_permiso SET flag = {$obj->getFlag()} 
                WHERE cc_usuario = '{$obj->getCc_usuario()}' AND cc_modulo = '{$obj->getCc_modulo()}' AND cc_permiso = {$obj->getCc_permiso()}";
        return $this->conecta->sql_query($sql);
    }

    public function consulta($sql)
    {
        return $this->conecta->ArrayLista($sql);
    }

    function __destruct()
    {
        $this->conecta = FALSE;
    }
}
