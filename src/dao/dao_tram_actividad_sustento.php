<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/tram_actividad_sustento.php");
class dao_tram_actividad_sustento
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

    public function insertar(tram_actividad_sustento $obj)
    {
        $sql = "insert into tram_actividad_sustento(
        usuario,
        fecha_registro,
        cc_area_adm,
        fecha,
        dia,
        obs,
        cc_local,
        flag)values(
        '".$obj->getUsuario()."',
        getdate(),
        '".$obj->getCc_area_adm()."',
        '".$obj->getFecha()."',
        '".$obj->getDia()."',
        '".$obj->getObs()."',
        '".$obj->getCc_local()."',
        '".$obj->getFlag()."')";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(tram_actividad_sustento $obj)
    {
        $sql = "update tram_actividad_sustento set
        cc_area_adm='".$obj->getCc_area_adm()."',
        fecha='".$obj->getFecha()."',
        dia='".$obj->getDia()."',
        obs='".$obj->getObs()."',
        cc_local='".$obj->getCc_local()."',
        flag='".$obj->getFlag()."'
        where cc_sustento='".$obj->getCc_sustento()."'
        ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(tram_actividad_sustento $obj)
    {
        $sql = "delete from tram_actividad_sustento
        where cc_sustento='".$obj->getCc_sustento()."'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

}