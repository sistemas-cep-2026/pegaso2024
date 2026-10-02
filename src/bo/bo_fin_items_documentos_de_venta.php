<?php
require_once dirname(__DIR__) . '/dao/dao_fin_items_documentos_de_venta.php';
class bo_fin_items_documentos_de_venta
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_items_documentos_de_venta();
    }

    public function control(fin_items_documentos_de_venta $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
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

    public function ListarIdVentas(?fin_items_documentos_de_venta $obj = null)
    {
        $sql = "select d.cc_ventadetall,
            d.cc_ventas, 
            d.c_articulo,
            rtrim(a.nombre) as nombre_concepto,
            d.ano, 
            d.mes_desde, 
            d.mes_hasta, 
            d.cantidad,
            d.precio,
            d.venta,
            d.monto
            from items_documentos_de_venta d inner join gen_articulos a
            on d.c_articulo=a.c_articulo
            where cc_ventas={$obj->getCc_ventas()}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarIdVentasSuma(?fin_items_documentos_de_venta $obj = null)
    {
        $sql = "select 
            SUM(CASE WHEN c_articulo IN ('70501', '76666') 
             THEN venta ELSE 0 END) AS opera_inafecta,
            SUM(CASE WHEN c_articulo NOT IN ('70501', '76666') 
             THEN venta ELSE 0 END) AS opera_grabada
            FROM items_documentos_de_venta
        WHERE cc_ventas = {$obj->getCc_ventas()}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }



    public function listarID(fin_items_documentos_de_venta $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
