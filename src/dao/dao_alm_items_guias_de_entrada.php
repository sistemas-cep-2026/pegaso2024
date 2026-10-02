<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/alm_items_guias_de_entrada.php");
class dao_alm_items_guias_de_entrada
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

    public function insertar(alm_items_guias_de_entrada $obj)
    {
        $sql = "insert INTO Items_Guias_de_Entrada(
        cc_guia,
        c_articulo, 
        cantidad
        )VALUES(
        '".$obj->getCc_guia()."',
        RIGHT(REPLICATE('0', 18) + CAST(RTRIM('".$obj->getC_articulo()."') AS VARCHAR(18)), 18),
        '".$obj->getCantidad()."')";
        echo $sql;
       // return $this->conecta->sql_query($sql);
    }

    public function modificar(alm_items_guias_de_entrada $obj)
    {
        $sql = "";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(alm_items_guias_de_entrada $obj)
    {
        $sql = "delete from Items_Guias_de_Entrada where cc_guia_det='".$obj->getCc_guia_det()."'";
       //echo $sql;
        return $this->conecta->sql_query($sql);
    }

}