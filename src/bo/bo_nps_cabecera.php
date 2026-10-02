<?php
require_once dirname(__DIR__) . '/dao/dao_nps_cabecera.php';
class bo_nps_cabecera
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_nps_cabecera();
    }

    public function control(nps_cabecera $obj, $opc)
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
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(nps_cabecera $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(nps_cabecera $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

}