<?php
require_once dirname(__DIR__) . '/dao/dao_tram_documentos_enviados_destinos.php';
class bo_tram_documentos_enviados_destinos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_documentos_enviados_destinos();
    }

    public function control(tram_documentos_enviados_destinos $obj, $opc)
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

    public function listar(tram_documentos_enviados_destinos $obj = null)
    {
        $sql = "select d.cc_docenviado_det,d.c_persona,d.cargo,p.nombre from documentos_enviados_destinos d inner join personas p on p.c_persona=d.c_persona where d.cc_docenviado='{$obj->getCc_docenviado()}' ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_documentos_enviados_destinos $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
