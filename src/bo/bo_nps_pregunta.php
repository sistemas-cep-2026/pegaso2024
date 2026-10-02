<?php
require_once dirname(__DIR__) . '/dao/dao_nps_pregunta.php';
class bo_nps_pregunta
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_nps_pregunta();
    }

    public function control(nps_pregunta $obj, $opc)
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

    public function listar(nps_pregunta $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(nps_pregunta $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

}