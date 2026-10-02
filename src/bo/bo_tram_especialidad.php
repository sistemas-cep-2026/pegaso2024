<?php
require_once dirname(__DIR__) . '/dao/dao_tram_especialidad.php';
class bo_tram_especialidad
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_especialidad();
    }

    public function control(tram_especialidad $obj, $opc)
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
            case "A":
                return $this->dao->anular($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listarXTipo($tipo)
    {
        $sql = "SELECT tipo,grupo,c_especialidad,nombre,tipo+grupo+c_especialidad as codigo,
                numero,flag_rec,nombreprint,resolucion
                FROM especialidad WHERE tipo = '$tipo' 
                and c_especialidad<>'000000'
                order by tipo,nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarMaxXTipo($tipo)
    {
        $sql = "SELECT tipo_especialidad,
                REPLICATE('0',6-LEN(CAST((numero+1) AS CHAR(6))))+CAST((numero+1) AS CHAR(6)) AS numero 
                FROM especialidad_tipo(NOLOCK)
                WHERE tipo_especialidad='$tipo';";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
