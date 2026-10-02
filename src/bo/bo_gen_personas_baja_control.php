<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas_baja_control.php';
class bo_gen_personas_baja_control
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas_baja_control();
    }

    public function control(gen_personas_baja_control $obj, $opc)
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

    public function listar(gen_personas_baja_control $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(gen_personas_baja_control $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarXCcBaja(gen_personas_baja_control $obj = null)
    {
        $sql = "SELECT cc_baja_ctrl, cc_baja, flag, obs, dbo.fc_v1_fecha_hora(fecha_crea) fecha_crea,
                user_crea
                FROM personas_baja_control WHERE cc_baja = '{$obj->getCc_baja()}'";
        return $this->dao->consulta($sql);
    }

}