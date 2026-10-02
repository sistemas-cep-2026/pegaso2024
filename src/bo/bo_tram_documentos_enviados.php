<?php
require_once dirname(__DIR__) . '/dao/dao_tram_documentos_enviados.php';
class bo_tram_documentos_enviados
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_documentos_enviados();
    }



    public function ProcesarDocumentos(tram_documentos_enviados $obj)
    {
        return $this->dao->ProcesarDocumentos($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(tram_documentos_enviados $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_documentos_enviados $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
