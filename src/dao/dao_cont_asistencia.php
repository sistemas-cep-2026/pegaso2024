<?php
require_once dirname(__DIR__) . '/entidad/cont_asistencia.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cont_asistencia
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

    public function insertar(cont_asistencia $obj)
    {
        $sql = "insert into cont_asistencia(cc_persona, 
        punch_time, 
        flag,
        status
        )values(
        '".$obj->getCc_persona()."',
        '".$obj->getPunch_time()."',
        '".$obj->getFlag()."',
        '".$obj->getStatus()."'
    )";
    //echo $sql;
    return $this->conecta->sql_query($sql);
}

public function modificar(cont_asistencia $obj)
{
    $sql = "update cont_asistencia set 
    punch_time='".$obj->getPunch_time()."',
    flag= '".$obj->getFlag()."',
    status= '".$obj->getStatus()."'
    where id='".$obj->getId()."'";
        //echo $sql;
    return $this->conecta->sql_query($sql);
}

}
