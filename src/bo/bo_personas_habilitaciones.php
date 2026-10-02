<?php
require_once dirname(__DIR__) . '/dao/dao_personas_habilitaciones.php';
class bo_personas_habilitaciones
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_personas_habilitaciones();
    }

    public function control(personas_habilitaciones $obj, $opc)
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

    public function listar(personas_habilitaciones $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID($cc_persona)
    {
        $sql = "SELECT cc_habilitacion, cc_local ,cc_persona ,numero,   dbo.fc_v1_fecha_hora( fecha) fecha1,  
         dbo.fc_v1_fecha_hora( caducidad) caducidad,firma_decano,firma_nacional,flag, periodo_text,deuda,fracc 
         FROM  cloud_huawei.beta_app2023.dbo.tram_habilitacion WHERE cc_persona='$cc_persona' ORDER BY fecha DESC ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

}