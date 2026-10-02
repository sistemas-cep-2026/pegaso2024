<?php
require_once dirname(__DIR__) . '/dao/dao_tram_documentos_internos.php';
class bo_tram_documentos_internos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_documentos_internos();
    }

    public function control(tram_documentos_internos $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "A":
                return $this->dao->eliminar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(tram_documentos_internos $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarMax(tram_documentos_internos $obj)
    {
        $sql = "SELECT MAX(id_doc) as id_doc FROM Documentos_Internos WHERE c_local='{$obj->getC_local()}'";
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_documentos_internos $obj)
    {
        $sql = "SELECT d.id_doc,d.c_tipo,d.c_local,d.numero, d.c_persona,DBO.FC_FECHA_TEXTO(d.fecha) as fecha, 
        DBO.FC_FECHA_TEXTO(d.fecha_visado) as desde, DBO.FC_FECHA_TEXTO(d.fecha_entrega) as hasta, 
        d.flag_expediente, d.c_expediente, d.vigencia, d.flag, d.visado,d.fecha_visado, d.cod_codigo,
        p.cod_sexo,
        d.fecha_entrega, d.obs, p.c_cmp, p.nombre, p.num_documento, pii.nombre nombre_institucion FROM Documentos_Internos d (nolock)
        inner join personas p (nolock) on p.c_persona = d.c_persona
        left join personas pii (nolock) on d.c_persona_institucion = pii.c_persona
        WHERE d.id_doc='{$obj->getId_doc()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listaDocumentosHabilitaciones(tram_documentos_internos $obj)
    {
        $sql = "SELECT top(25) d.id_doc,d.c_tipo,d.c_local,d.numero, d.c_persona,DBO.FC_FECHA_TEXTO(d.fecha) as fecha_registro, 
        DBO.FC_FECHA_TEXTO(d.fecha_visado) as desde, DBO.FC_FECHA_TEXTO(d.fecha_entrega) as hasta, 
        d.flag_expediente, d.c_expediente, d.vigencia, d.flag, d.visado,d.fecha_visado,
        d.fecha_entrega, d.obs, p.c_cmp, p.nombre, t.nombre nombre_documento
        FROM Documentos_Internos d (nolock)
        inner join personas p (nolock) on p.c_persona = d.c_persona
        inner join gen_tipo_de_documentos t (nolock) on t.c_tipo_de_documento = d.c_tipo
        WHERE d.c_local='{$obj->getC_local()}' ";
        $sql .= !empty($obj->getC_tipo()) ? " AND d.c_tipo='{$obj->getC_tipo()}'" : "";
        $sql .= " AND (p.nombre LIKE '%{$obj->getNombre_persona()}%' OR p.c_cmp LIKE '%{$obj->getNombre_persona()}%')";
        $sql .= " ORDER BY d.fecha DESC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
