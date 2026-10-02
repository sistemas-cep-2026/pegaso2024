<?php
require_once dirname(__DIR__) . '/dao/dao_fin_detalle_prestamos_socios.php';
class bo_detalle_prestamos_socios
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_detalle_prestamos_socios();
    }

    public function control(fin_detalle_prestamos_socios $obj, $opc)
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

    public function listar(fin_detalle_prestamos_socios $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(fin_detalle_prestamos_socios $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
