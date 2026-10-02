<?php
require_once dirname(__DIR__) . '/dao/dao_tram_seguimiento_documentos_recibid.php';
class bo_tram_seguimiento_documentos_recibid
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_seguimiento_documentos_recibid();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function procesar_docRecibidos_detalle(?tram_seguimiento_documentos_recibid $obj = null)
    {
        return $this->dao->procesar_docRecibidos_detalle($obj);
    }

    public function listaIDExp(?tram_seguimiento_documentos_recibid $obj = null)
    {
        $sql = "select de.cc_docrecibidos_det,
            de.cc_docrecibidos,
            dbo.fc_v1_fecha_hora(de.fecha_entrega) as fecha_entrega_text,
            de.c_area_adm,
            a.nombre as c_area_adm_text,
            de.observacion,
            de.c_accion,
            ac.nombre as c_accion_text,
            de.c_usuario,
            de.flag,
            de.linea,
            de.accion_a_tomar,
		    dbo.fc_v1_parametro_valor('seguimiento_documentos_recibid','flag',de.flag) as flag_text,
            de.cod_original,
            dbo.fc_v1_parametro_valor('seguimiento_documentos_recibid','cod_original',de.cod_original) as cod_original_text,
            de.feha_respuesta,
            dbo.fc_v1_fecha_hora(de.feha_respuesta) as feha_respuesta_text,
            de.usu_recep
            from seguimiento_documentos_recibid de  (nolock) left join gen_area_adm a
            on de.c_area_adm=a.cc_area_adm
            left join tram_acciones ac
            on de.c_accion=ac.c_accion
            where cc_docrecibidos='{$obj->getCc_docrecibidos()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?tram_seguimiento_documentos_recibid $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
