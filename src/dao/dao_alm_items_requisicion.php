<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/alm_items_requisicion.php");
class dao_alm_items_requisicion
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

    public function insertar(alm_items_requisicion $obj)
    {
        $sql = "insert INTO items_requisicion_de_compras(
        cc_requisicion,
        c_articulo, 
        cantidad
        )VALUES(
        '".$obj->getCc_requisicion()."',
        '".$obj->getC_articulo()."',
        '".$obj->getCantidad()."')";
       // echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(alm_items_requisicion $obj)
    {
        $sql = "";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(alm_items_requisicion $obj)
    {
        $sql = "delete from items_requisicion_de_compras where cc_requisicion_det='".$obj->getCc_requisicion_det()."'";
       //echo $sql;
        return $this->conecta->sql_query($sql);
    }

}