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

    public function listar(?tram_documentos_enviados $obj = null)
    {
        $sql = "select d.c_tipo_de_documento, 
        dbo.fc_v1_fecha_texto_hora(d.fecha) as fecha_text, 
        d.gestion,d.num_documento,d.asunto,
        d.c_area_adm_doc,d.tipo_persona,
        d.c_area_adm_usuario,d.cc_docenviado,
        d.flag,d.c_usuario,
        a.nombre as area
        from documentos_enviados d inner join gen_area_adm a
        on d.c_Area_adm_usuario=a.cc_area_adm
                
        where d.c_local='{$obj->getC_local()}' and d.fecha between '{$obj->getfecha_desde()}' and '{$obj->getfecha_hasta()}'";
        if (!empty($obj->getC_tipo_de_documento())) {
            $sql .= " and d.c_tipo_de_documento='{$obj->getC_tipo_de_documento()}'";
        }
        $sql .= " order by d.c_tipo_de_documento,d.num_documento";
        echo $sql;
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
