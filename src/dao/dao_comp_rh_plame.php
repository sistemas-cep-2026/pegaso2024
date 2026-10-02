<?php
require_once dirname(__DIR__) . '/entidad/comp_rh_plame.php';
require_once __DIR__ . '/_conexa_.php';
class dao_comp_rh_plame
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

    public function insertar(comp_rh_plame $obj)
    {
        $sql = " EXEC sp_v1_comp_rh_plame 
        '".$obj->getCc_id()."',          
        '".$obj->getCod_anho()."',       
        '".$obj->getCod_mes()."',
        '".$obj->getC_usuario()."',
        '".$obj->getC_persona()."',
        '".$obj->getCod_documento()."',
        '".$obj->getNum_documento()."',
        '".$obj->getFecha_documento()."',
        '".$obj->getFecha_pago()."',
        '".$obj->getCuarta()."',
        '".$obj->getMonto()."',
        '".$obj->getC_local()."',
        '".$obj->getOpc()."'";

        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(comp_rh_plame $obj)
    {
         $sql = " EXEC sp_v1_comp_rh_plame 
        '".$obj->getCc_id()."',          
        '".$obj->getCod_anho()."',       
        '".$obj->getCod_mes()."',
        '".$obj->getC_usuario()."',
        '".$obj->getC_persona()."',
        '".$obj->getCod_documento()."',
        '".$obj->getNum_documento()."',
        '".$obj->getFecha_documento()."',
        '".$obj->getFecha_pago()."',
        '".$obj->getCuarta()."',
        '".$obj->getMonto()."',
        '".$obj->getC_local()."',
        '".$obj->getOpc()."'";

        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(comp_rh_plame $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}