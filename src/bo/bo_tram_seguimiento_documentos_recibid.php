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
		    dbo.fc_v1_parametro_valor('seguimiento_documentos_recibid1','flag',de.flag) as flag_text,
            de.cod_original,
            dbo.fc_v1_parametro_valor('seguimiento_documentos_recibid1','cod_original',de.cod_original) as cod_original_text,
            de.feha_respuesta,
            dbo.fc_v1_fecha_hora(de.feha_respuesta) as feha_respuesta_text,
            de.usu_recep
            from seguimiento_documentos_recibid1 de  (nolock) left join gen_area_adm a
            on de.c_area_adm=a.cc_area_adm
            left join tram_acciones ac
            on de.c_accion=ac.c_accion
            where cc_docrecibidos='{$obj->getCc_docrecibidos()}'
            order by de.fecha_entrega asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /**
     * Para exp_rep_print.php: derivaciones hechas POR un area (hijos del movimiento
     * de esa area; linea = cc_docrecibidos_det del padre) en un grupo de documentos.
     * Se usa para imprimir un casillero de V°B° por cada area destino.
     */
    public function listarDerivadosPorArea(array $ids_docrecibidos, $c_area_adm)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids_docrecibidos))));
        $c_area_adm = trim((string)$c_area_adm);
        if (count($ids) === 0 || !preg_match('/^[A-Za-z0-9]{1,6}$/', $c_area_adm)) {
            return [];
        }
        $sql = "SELECT h.cc_docrecibidos,
            h.cc_docrecibidos_det,
            h.c_area_adm,
            a.nombre AS c_area_adm_text,
            ac.nombre AS c_accion_text,
            h.observacion,
            dbo.fc_v1_parametro_valor('seguimiento_documentos_recibid1','cod_original',h.cod_original) AS cod_original_text,
            dbo.fc_v1_fecha_texto(h.fecha_entrega) AS fecha_entrega_text
            FROM seguimiento_documentos_recibid1 h (NOLOCK)
            INNER JOIN seguimiento_documentos_recibid1 pa (NOLOCK)
            ON pa.cc_docrecibidos_det = h.linea
            AND pa.cc_docrecibidos = h.cc_docrecibidos
            LEFT JOIN gen_area_adm a (NOLOCK)
            ON h.c_area_adm = a.cc_area_adm
            LEFT JOIN tram_acciones ac (NOLOCK)
            ON h.c_accion = ac.c_accion
            WHERE h.cc_docrecibidos IN (" . implode(',', $ids) . ")
            AND pa.c_area_adm = '{$c_area_adm}'
            ORDER BY h.cc_docrecibidos, h.cc_docrecibidos_det";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?tram_seguimiento_documentos_recibid $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
