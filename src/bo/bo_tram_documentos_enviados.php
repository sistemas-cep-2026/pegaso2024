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
        $sql = "select   c_tipo_de_documento,gestion,num_documento,asunto,
             dbo.fc_fecha_texto_hora1(fecha) as fecha_text,c_area_adm_doc,tipo_persona,c_area_adm_usuario,cc_docenviado ,flag,c_usuario,'' flag_text
        from documentos_enviados where c_local='{$obj->getC_local()}' and fecha between '{$obj->getfecha_desde()}' and '{$obj->getfecha_hasta()}' order by c_tipo_de_documento,num_documento";
       // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_documentos_enviados $obj = null)
    {
        $sql = "select   c_tipo_de_documento,gestion,num_documento,asunto,
        fecha,c_area_adm_doc,tipo_persona,c_area_adm_usuario,cc_docenviado ,flag
        from documentos_enviados where cc_docenviado='{$obj->getCc_docenviado()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
