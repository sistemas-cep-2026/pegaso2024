<?php
require_once dirname(__DIR__) . '/dao/dao_fin_puntos_de_venta.php';
class bo_fin_puntos_de_venta
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_puntos_de_venta();
    }

    public function control(fin_puntos_de_venta $obj, $opc)
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

    public function listar(fin_puntos_de_venta $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(fin_puntos_de_venta $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listar_por_local(?fin_puntos_de_venta $obj = null)
    {
        $sql = "select c_punto_de_venta,  
        nombre, 
        c_local 
        FROM puntos_de_venta (nolock) 
        WHERE c_punto_de_venta <> '...' 
        AND flag_activo='*'
        AND flag_sucursal IS NULL 
        and c_local='{$obj->getC_local()}'";
        return $this->dao->consulta($sql);
    }
}
