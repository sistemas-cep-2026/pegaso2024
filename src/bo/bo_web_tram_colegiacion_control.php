<?php
require_once dirname(__DIR__) . '/dao/dao_web_tram_colegiacion_control.php';
class bo_web_tram_colegiacion_control
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_web_tram_colegiacion_control();
    }

    public function control(web_tram_colegiacion_control $obj, $opc)
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

    public function procesarControl_CL(web_tram_colegiacion_control $obj)
    {
        return $this->dao->procesarControl_CL($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(web_tram_colegiacion_control $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(web_tram_colegiacion_control $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function ListarEstado(web_tram_colegiacion_control $obj)
    {
        $sql = "SELECT id,
                c_persona,
                codigo,
                cc_usuario,
                dbo.fc_fecha_hora(fecha) as fecha,
                estado,
                detalle
                from web_tram_colegiacion_control
                where c_persona='{$obj->getC_persona()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
