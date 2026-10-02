<?php
require_once dirname(__DIR__) . '/entidad/fin_items_documentos_de_venta.php';
require_once __DIR__ . '/_conexa_.php';
class dao_fin_items_documentos_de_venta
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

    public function insertar(fin_items_documentos_de_venta $obj)
    {
        $sql = "insert into items_documentos_de_venta(cc_ventas, 
        c_articulo, 
        ano, 
        mes_desde, 
        mes_hasta, 
        precio,
        cantidad,
        venta)values(
        '{$obj->getCc_ventas()}',
        '{$obj->getC_articulo()}',
        '{$obj->getAno()}',
        '{$obj->getMes_desde()}',
        '{$obj->getMes_hasta()}',
        '{$obj->getPrecio()}',
        '{$obj->getCantidad()}',
        '{$obj->getVenta()}'
        )";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(fin_items_documentos_de_venta $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(fin_items_documentos_de_venta $obj)
    {
        $sql = "delete from items_documentos_de_venta where cc_ventadetall={$obj->getCc_ventadetall()}";
        echo  $sql;
        return $this->conecta->sql_query($sql);
    }
}
