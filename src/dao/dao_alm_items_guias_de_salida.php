<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/alm_items_guias_de_salida.php");
class dao_alm_items_guias_de_salida
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

    public function insertar(alm_items_guias_de_salida $obj)
    {
        $sql = "insert INTO items_guias_de_salida(
        cc_guia,
        c_articulo, 
        cantidad
        )VALUES(
        '".$obj->getCc_guia()."',
        '".$obj->getC_articulo()."',
        '".$obj->getCantidad()."')";
       // echo $sql;
        return $this->conecta->sql_query($sql);
    }

   
    public function eliminar(alm_items_guias_de_salida $obj)
    {
        $sql = "delete from items_guias_de_salida where cc_guia_det='".$obj->getCc_guia_det()."'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

}