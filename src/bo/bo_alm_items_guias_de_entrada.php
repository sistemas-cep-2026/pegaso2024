<?php
require_once dirname(__DIR__) . '/dao/dao_alm_items_guias_de_entrada.php';
class bo_alm_items_guias_de_entrada
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_items_guias_de_entrada();
    }

    public function control(alm_items_guias_de_entrada $obj, $opc)
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

    
    public function ListarIdGuia(alm_items_guias_de_entrada $obj)
    {
        $sql = "select i.cc_guia_det, i.cc_guia, i.c_articulo, a.nombre as nombre_articulo, i.cantidad ,a.unidad 
                from items_guias_de_entrada i 
                inner join guias_de_entrada r on i.cc_guia=r.cc_guia 
                inner join gen_articulos a on i.c_articulo=a.c_articulo 
                where i.cc_guia=" .$obj->getCc_guia().";";
        //echo $sql;
        return $this->dao->consulta($sql);
    }  

   public function listar(alm_items_guias_de_entrada $obj = null)
   {
    $sql = "";
        //echo $sql;
    return $this->dao->consulta($sql);
}

public function listarID(alm_items_guias_de_entrada $obj = null)
{
    $sql = "";
        //echo $sql;
    return $this->dao->consulta($sql);
}

}