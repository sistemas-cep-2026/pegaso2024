<?php
require_once dirname(__DIR__) . '/dao/dao_alm_items_guias_de_salida.php';
class bo_alm_items_guias_de_salida
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_items_guias_de_salida();
    }

    public function control(alm_items_guias_de_salida $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;

            case "E":
                return $this->dao->eliminar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function ListarIdGuia(?alm_items_guias_de_salida $obj = null)
    {
        $sql = "select gs.cc_guia_det,
       gs.cc_guia,
       gs.c_articulo,
       a.nombre as nombre_articulo,
       gs.cantidad,al.stock_actual,a.unidad
       FROM dbo.items_guias_de_salida gs
	   inner join dbo.guias_de_salida g on gs.cc_guia=g.cc_guia
	   INNER JOIN dbo.gen_articulos a on gs.c_articulo=a.c_articulo
	   left join gen_articulos_local al on al.c_articulo=gs.c_articulo and al.c_local=g.c_local
       where g.cc_guia='" . $obj->getCc_guia() . "'";
       
        return $this->dao->consulta($sql);
    }


    public function listar(alm_items_guias_de_salida $obj = null)
    {
        $sql = "";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(alm_items_guias_de_salida $obj = null)
    {
        $sql = "";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
