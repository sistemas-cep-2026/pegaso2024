<?php
require_once dirname(__DIR__) . '/dao/dao_personas_habilitaciones_web.php';
class bo_personas_habilitaciones_web
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_personas_habilitaciones_web();
    }

    public function control(personas_habilitaciones_web $obj, $opc)
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

    public function listar(personas_habilitaciones_web $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(personas_habilitaciones_web $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

}