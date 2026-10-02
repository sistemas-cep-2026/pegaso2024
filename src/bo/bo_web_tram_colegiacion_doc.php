<?php
require_once dirname(__DIR__) . '/dao/dao_web_tram_colegiacion_doc.php';
class bo_web_tram_colegiacion_doc
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_web_tram_colegiacion_doc();
    }

    public function control(web_tram_colegiacion_doc $obj, $opc)
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

    public function listar(web_tram_colegiacion_doc $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(web_tram_colegiacion_doc $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarFotosId(web_tram_colegiacion_doc $obj)
    {
        $sql = "SELECT id, dbo.fc_fecha_hora(fecha) as fecha,
        c_persona, tipo, archivo, detalle
        FROM web_tram_colegiacion_doc
        WHERE c_persona = '{$obj->getC_persona()}'
        and tipo='FOT' order by tipo asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarFotos(web_tram_colegiacion_doc $obj){
        $sql = "SELECT id, dbo.fc_fecha_hora(fecha) as fecha,
                c_persona, RTRIM(tipo) AS tipo, archivo, detalle
                FROM web_tram_colegiacion_doc
                WHERE c_persona = '{$obj->getC_persona()}'
                order by tipo asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
 