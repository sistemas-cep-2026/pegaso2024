<?php
require_once dirname(__DIR__) . '/dao/dao_alm_items_requisicion.php';
class bo_alm_items_requisicion
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_items_requisicion();
    }

    public function control(alm_items_requisicion $obj, $opc)
    {
        switch($opc){
            case "I":
            return $this->dao->insertar($obj);
            break;
            case "U":
            return $this->dao->modificar($obj);
            break;
            case "E":
            return $this->dao->eliminar($obj);
            break;
            case "A":
            return $this->dao->anular($obj);
            break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    
    public function ListarIdGuia(alm_items_requisicion $obj)
    {
        $sql = "select i.cc_requisicion_det, i.cc_requisicion, i.c_articulo, a.nombre as nombre_articulo, i.cantidad ,a.unidad 
                from items_requisicion_de_compras i 
                inner join requisicion_de_compras r on i.cc_requisicion=r.cc_requisicion 
                inner join gen_articulos a on i.c_articulo=a.c_articulo 
                where i.cc_requisicion=" .$obj->getCc_requisicion().";";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
   

   public function listar(alm_items_requisicion $obj = null)
   {
    $sql = "";
        //echo $sql;
    return $this->dao->consulta($sql);
}

public function listarID(alm_items_requisicion $obj = null)
{
    $sql = "";
        //echo $sql;
    return $this->dao->consulta($sql);
}

}