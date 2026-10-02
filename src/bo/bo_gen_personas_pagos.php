<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas_pagos.php';
class bo_gen_personas_pagos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas_pagos();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function deuda_c_persona(gen_personas $obj)
    {
        return $this->dao->deuda_c_persona($obj);
    }

    public function detalle_recaudadora_cab(gen_personas $obj)
    {
        /*$sql="select es.referencia1 as referencia1,'BBVA '+es.referencia2 as referencia2,es.fecha_proceso_id as fecha_proceso_id,
                es.c_local as c_local, 
                es.id
                as num_movimiento,es.total as total,es.FECHA_PAGO as fecha_hora
                from bbva_proceso_detalle es (nolock) 
                inner join personas pe(nolock) on es.REFERENCIA1=pe.c_CMP 
                where pe.c_persona='".$c_persona."' 
                union all
                select c_persona,'BCP '+dato_adicional,fecha,c_local,rtrim(cast(id as char(10))),total_distribuir,fecha+hora from BCP_proceso_detalle where c_persona='".$c_persona."'
                order by es.fecha_proceso_id desc ";*/

        $sql = "SELECT es.referencia1 AS referencia1,'BBVA '+es.referencia2 AS referencia2,es.fecha_proceso_id AS fecha_proceso_id,
                es.c_local AS c_local, 
                es.id
                AS num_movimiento,es.total AS total,es.FECHA_PAGO AS fecha_hora
                FROM bbva_proceso_detalle es (NOLOCK) 
                WHERE es.c_persona='{$obj->getCc_persona()}' 
                UNION ALL
                SELECT es.referencia1 AS referencia1,'BBVA '+es.referencia2 AS referencia2,es.fecha_proceso_id AS fecha_proceso_id,
                es.c_local AS c_local, 
                es.num_movimiento,es.total AS total,es.FECHA_PAGO AS fecha_hora
                FROM bbva_proceso_detalle es (NOLOCK) 
                INNER JOIN personAS pe(NOLOCK) on es.REFERENCIA1=pe.c_CMP 
                WHERE pe.c_persona='{$obj->getCc_persona()}' AND es.c_persona IS NULL
                UNION ALL
                SELECT c_persona,'BCP '+dato_adicional,fecha,c_local,rtrim(CAST(id AS CHAR(10))),total_distribuir,fecha+hora
                FROM BCP_proceso_detalle WHERE c_persona='{$obj->getCc_persona()}' 
                ORDER BY es.fecha_proceso_id DESC ";

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function historial_pagos_cab(gen_personas $obj)
    {
        $sql = "SELECT flag, cod_documento, num_documento, valor_venta, nombre_banco,
                cta_cte_deposito, num_referencia, pfecha, fecha_referencia, cod_forma_de_pago
                FROM vw_historial_documentos_venta
                WHERE c_persona='{$obj->getCc_persona()}'
                ORDER BY fecha DESC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function historial_pagos_detalle(gen_personas $obj, $args)
    {
        $sql = "SELECT i.cod_documento,i.num_documento,i.linea,i.c_articulo,
                i.nombre_pr,i.ano,i.mes_desde,i.mes_hasta,i.cantidad,i.venta
                FROM documentos_de_venta d (NOLOCK)
                INNER JOIN items_planilla_De_cobranza p (NOLOCK) ON (p.cod_documento=d.cod_documento AND d.num_documento=p.num_documento)
                LEFT JOIN  items_documentos_de_venta I (NOLOCK) ON ( D.cod_documento = I.cod_documento AND D.num_documento = I.num_documento)  
                WHERE d.c_persona='{$obj->getCc_persona()}' AND d.num_documento='{$args['num']}' 
                AND d.cod_documento='{$args['td']}'
                ORDER BY i.linea";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function historial_pagos_validacion(gen_personas $obj, $args)
    {
        $sql = "SELECT (CASE WHEN cod_documento = '99' THEN 'COTIZACIONES' ELSE 'OTROS' END) cod_documento,
                sum(monto)*-1 AS total FROM estado_de_cuenta 
                WHERE c_persona='{$obj->getCc_persona()}' AND num_documento_ref='{$args['num']}'
                AND cod_documento_ref='{$args['td']}' AND monto < 0
                GROUP BY cod_documento
                ORDER BY cod_documento";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function detalle_recaudadora(gen_personas $obj, $args)
    {
        $sql = "SELECT es.num_documento,es.monto
                FROM estado_de_cuenta es (NOLOCK) 
                WHERE  (es.cod_documento='99') AND es.c_persona='{$obj->getCc_persona()}'
                AND es.num_documento_ref='{$args['num_documento_ref']}'
                AND cod_documento_ref='BB' AND monto<0
                ORDER BY SUBSTRING(es.num_documento,8,4)+SUBSTRING(es.num_documento,5,2) ASC,monto DESC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
