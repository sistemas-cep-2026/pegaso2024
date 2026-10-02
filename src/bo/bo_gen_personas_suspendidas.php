<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas_suspendidas.php';
class bo_gen_personas_suspendidas
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas_suspendidas();
    }

    public function control(gen_personas_suspendidas $obj, $opc)
    {
        switch($opc){
        case "I":
        case "A":
        case "R":
        case "P":
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

    public function listar(gen_personas_suspendidas $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(gen_personas_suspendidas $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarXPersona(gen_personas_suspendidas $obj = null)
    {
        $sql = "SELECT cc_psuspendidas, c_persona, flag, obs, dbo.fc_fecha_texto_hora(fecha_crea) fecha_crea,
                user_crea,  dbo.fc_fecha_texto_hora(fecha_mod) fecha_mod, user_mod, flag_activo, sancion, resol1, resol2, desde, hasta, url
                FROM personas_suspendidas WHERE c_persona = '{$obj->getC_persona()}'";
        return $this->dao->consulta($sql);
    }

}