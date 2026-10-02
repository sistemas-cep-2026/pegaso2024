<?php
require_once dirname(__DIR__) . '/dao/dao_tram_actividad_sustento_detalle.php';
class bo_tram_actividad_sustento_detalle
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_actividad_sustento_detalle();
    }

    public function control(tram_actividad_sustento_detalle $obj, $opc)
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
            case "A": /*archivar*/
            return $this->dao->archivar($obj);
            break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(tram_actividad_sustento_detalle $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_actividad_sustento_detalle $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
    public function ListarIdActividad(tram_actividad_sustento_detalle $obj = null)
    {
        $sql="select cc_sustento_det,
        cc_sustento,
        CONVERT(varchar(15),CAST(horaini AS TIME),100) as horaini,
        CONVERT(varchar(15),CAST(horafin AS TIME),100) as horafin,
        obs 
        FROM dbo.tram_actividad_sustento_detalle WHERE cc_sustento='".$obj->getCc_sustento()."'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

}