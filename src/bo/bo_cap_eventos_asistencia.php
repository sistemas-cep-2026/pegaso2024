<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos_asistencia.php';
class bo_cap_eventos_asistencia
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos_asistencia();
    }

    public function control(cap_eventos_asistencia $obj, $opc)
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

    public function registrados()
    {
        $sql = "SELECT COUNT(DISTINCT c_persona) AS cantidad
FROM cap_eventos_asistencia
WHERE flag = '*'";
        return $this->dao->consulta($sql);
    }
    public function validar(?cap_eventos_asistencia $obj = null)
    {
        $sql = "SELECT CASE 
    WHEN EXISTS (
        SELECT 1
        FROM cap_eventos_asistencia
        WHERE cc_evento = {$obj->getCc_evento()}
          AND c_persona = '{$obj->getC_persona()}'
          AND fech_crea = '{$obj->getFech_crea()}'
          AND flag = '*'
    )
    THEN 1     ELSE 0 END AS existe";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar(?cap_eventos_asistencia $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(?cap_eventos_asistencia $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
