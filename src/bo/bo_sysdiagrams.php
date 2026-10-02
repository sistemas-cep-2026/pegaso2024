<?php
require_once dirname(__DIR__) . '/dao/dao_sysdiagrams.php';
class bo_sysdiagrams
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_sysdiagrams();
    }

    public function control(sysdiagrams $obj, $opc)
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

    public function listar(sysdiagrams $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(sysdiagrams $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

}