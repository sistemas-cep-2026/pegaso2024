<?php
require_once dirname(__DIR__) . '/entidad/seg_modulo_perfil.php';
require_once __DIR__ . '/_conexa_.php';
class dao_seg_modulo_perfil
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

    public function insertar(seg_modulo_perfil $obj){
        $sql="insert into seg_modulo_perfil
        (cc_modulo,
        cc_perfil
        )values(
        '".$obj->getCc_modulo()."',
        '".$obj->getCc_perfil()."'
    )";
    //echo $sql;
    return $this->conecta->sql_query($sql);
}

public function eliminar($cc_perfil)
{
    $sql = "delete FROM  seg_modulo_perfil
    WHERE cc_perfil='" . $cc_perfil . "'";
    //echo $sql;
    return $this->conecta->sql_query($sql);
}

}