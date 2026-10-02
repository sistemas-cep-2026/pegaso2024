<?php
require_once dirname(__DIR__) . '/dao/dao_recaud_bbva_proceso_detalle.php';
class bo_recaud_bbva_proceso_detalle
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_recaud_bbva_proceso_detalle();
    }

    public function downloadBBVA_todos()
    /**********Pendiente******/
    {
        $sql = "EXEC SP_SUBIDA_BBVA_202309";

        return $this->dao->consulta($sql);
    }

    public function control(recaud_bbva_proceso_detalle $obj, $opc)
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

    public function tram_honorabilidad(?recaud_bbva_proceso_detalle $obj = null)
    {
        $sql = "select id,
            nombre, 
            referencia2, 
            dbo.fc_fecha_texto(fechax) fecha,
            total, 
            flag_tramite,
            ISNULL(nombre, '') + ' =>' +ISNULL(referencia2, '') + ' =>' +ISNULL(dbo.fc_fecha_texto(fechax), '') + '=> ' +ISNULL(CAST(total AS VARCHAR(20)), '') AS registro
            from bbva_proceso_detalle where c_persona='{$obj->getC_persona()}' 
            and SUBSTRING(referencia2,1,1)='T' 
            and referencia2 like 'T3%'
            and flag_tramite is null
            and YEAR(fechax)>'2025'";
        //echo  $sql;
        return $this->dao->consulta($sql);
    }

    /*********************Estado de cuent********** */
    /* public function RecaudoCabecera($c_persona)
    {
         $sql = "select 
        es.referencia1 AS referencia1,
        'BBVA ' + es.referencia2 AS referencia2,
        es.fecha_proceso_id AS fecha_proceso_id,
        es.c_local AS c_local, 
        es.id AS num_movimiento,
        es.total AS total,
        es.FECHA_PAGO AS fecha_hora
        FROM 
        bbva_proceso_detalle AS es WITH (NOLOCK) 
        WHERE 
        es.c_persona = '" . $c_persona . "'

        UNION ALL

        SELECT 
        es.referencia1 AS referencia1,
        'BBVA ' + es.referencia2 AS referencia2,
        es.fecha_proceso_id AS fecha_proceso_id,
        es.c_local AS c_local, 
        es.num_movimiento AS num_movimiento,
        es.total AS total,
        es.FECHA_PAGO AS fecha_hora
        FROM 
        bbva_proceso_detalle AS es WITH (NOLOCK)
        INNER JOIN personas AS pe WITH (NOLOCK) 
        ON es.REFERENCIA1 = pe.c_CMP 
        WHERE 
        pe.c_persona = '" . $c_persona . "' 
        AND es.c_persona IS NULL

        UNION ALL

        SELECT 
        c_persona AS referencia1,
        'BCP ' + dato_adicional AS referencia2,
        fecha AS fecha_proceso_id,
        c_local AS c_local,
        RTRIM(CAST(id AS CHAR(10))) AS num_movimiento,
        total_distribuir AS total,
        fecha + hora AS fecha_hora
        FROM 
        BCP_proceso_detalle WITH (NOLOCK)
        WHERE 
        c_persona = '" . $c_persona . "'

        ORDER BY 
        fecha_proceso_id DESC;";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    */
    public function Recaudodetalle($c_persona, $operacion)
    {
        $sql = "select es.num_documento, es.monto
        FROM estado_de_cuenta es WITH (NOLOCK)
        WHERE es.cod_documento = '99'
        AND es.c_persona = '" . $c_persona . "'
        AND es.num_documento_ref = 'OPE-" . $operacion . "'
        AND es.cod_documento_ref = 'BB'
        AND es.monto < 0
        ORDER BY 
        CAST(SUBSTRING(es.num_documento, 8, 4) AS INT) + 
        CAST(SUBSTRING(es.num_documento, 5, 2) AS INT) ASC,
        es.monto DESC;";
        return $this->dao->consulta($sql);
    }

    public function listar(?recaud_bbva_proceso_detalle $obj = null)
    {
        $sql = "select bbva.fecha_pago,bbva.id, bbva.c_local, bbva.referencia1 AS nombre1, p.c_cmp AS c_cmp, ISNULL(LEFT(RTRIM(p.nombre), 30), bbva.referencia2) AS nombre2, 
CONVERT(VARCHAR(10), CAST(bbva.fecha_pago AS DATE), 103) AS fecha, bbva.total as total_distribuir, bbva.distribuir, bbva.fijoregion, bbva.region, bbva.nacional, bbva.fecha_pago AS num, 
p.c_persona,'000000' hora, bbva.num_movimiento operacion_canal ,dbo.fc_fecha_hora(bbva.fecha_id) fecha_id,(total-region-nacional) as fijonacional 
FROM bbva_proceso_detalle bbva 
LEFT JOIN personas p ON p.c_persona = bbva.c_persona 
WHERE bbva.referencia1 like '%'  ";
        if ($obj->getTipo() === 'H') {
            $sql .= " and rtrim(bbva.fecha_pago) = CONVERT(VARCHAR(8), GETDATE(), 112)";
        }
        if ($obj->getTipo() === 'D') {
            $sql .= " and LEFT(bbva.fecha_pago,6)='" . $obj->getPeriodo() . "'";
        }
        $sql .= " and ISNULL(bbva.c_local,'%') LIKE '{$obj->getC_local()}%'";
        $sql .= " ORDER BY bbva.fecha_pago desc, bbva.num_movimiento  DESC";
        // echo $sql;
        return $this->dao->consulta($sql);
    }
    public function total_recaudo(?recaud_bbva_proceso_detalle $obj = null)
    {
        $sql = "select count(id) as cantidad, SUM(total) AS total_total_distribuir, SUM(distribuir) AS total_distribuir, 
SUM(fijoregion) AS total_fijoregion, SUM(region) AS total_region, SUM(nacional) AS total_nacional ,sum(total-region-nacional) as total_fijon 
FROM bbva_proceso_detalle WHERE referencia1 LIKE '%'";
        if ($obj->getTipo() === 'H') {
            $sql .= " and fecha_pago = CONVERT(VARCHAR(8), GETDATE(), 112)";
        }
        if (in_array($obj->getTipo(), ['D', 'R'])) {
            $sql .= " and LEFT(fecha_pago,6)='" . $obj->getPeriodo() . "'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function recaudo_resumen(?recaud_bbva_proceso_detalle $obj = null)
    {
        $sql = "  select bbva_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+'( '+substring(rtrim(bbva_proceso_detalle.referencia2),1,18)+' '+ CAST(LOCAL.PORC_COTIZACION AS CHAR(5))+' %)'+' CANT=>'+cast(COUNT(*) as CHAR(10)) AS nombre1, 
sum(bbva_proceso_detalle.total) as total, sum(bbva_proceso_detalle.distribuir) as distribuir, sum(bbva_proceso_detalle.fijoregion) as fijoregion, 
sum(bbva_proceso_detalle.region) as region, sum(bbva_proceso_detalle.nacional) as nacional ,substring(bbva_proceso_detalle.referencia2,1,1) AS dd,COUNT(*) as tt 
, sum(bbva_proceso_detalle.fijocn) as fijocn
FROM bbva_proceso_detalle (nolock) 
inner join local (nolock) on local.c_local=bbva_proceso_detalle.c_local AND SUBSTRING(bbva_proceso_detalle.fecha_PAGO,1,6)= '{$obj->getPeriodo()}' AND bbva_proceso_detalle.c_local LIKE  RTRIM('{$obj->getC_local()}') 
AND SUBSTRING(bbva_proceso_detalle.referencia2,1,1) IN ('M','C')
group by bbva_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+'( '+substring(rtrim(bbva_proceso_detalle.referencia2),1,18)+' '+ CAST(LOCAL.PORC_COTIZACION AS CHAR(5))+' %)' ,substring(bbva_proceso_detalle.referencia2,1,1) 
 
UNION ALL 
select bbva_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+'( '+substring(rtrim(bbva_proceso_detalle.referencia2),1,3)+' '+substring(rtrim(bbva_proceso_detalle.referencia2),11,10)+' '+' 100%)'+' CANT=>'+cast(COUNT(*) as CHAR(10)) AS nombre1, 
sum(bbva_proceso_detalle.total) as total, sum(bbva_proceso_detalle.distribuir) as distribuir, sum(bbva_proceso_detalle.fijoregion) as fijoregion, 
sum(bbva_proceso_detalle.region) as region, sum(bbva_proceso_detalle.nacional) as nacional ,substring(bbva_proceso_detalle.referencia2,1,1) AS dd,COUNT(*) as tt 
, sum(bbva_proceso_detalle.fijocn) as fijocn
FROM bbva_proceso_detalle (nolock) 
inner join local (nolock) on local.c_local=bbva_proceso_detalle.c_local AND SUBSTRING(bbva_proceso_detalle.fecha_PAGO,1,6)= '{$obj->getPeriodo()}'  AND bbva_proceso_detalle.c_local LIKE  RTRIM('{$obj->getC_local()}') 
AND SUBSTRING(bbva_proceso_detalle.referencia2,1,1) IN ('T')
group by bbva_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+'( '+substring(rtrim(bbva_proceso_detalle.referencia2),1,3)+' '+substring(rtrim(bbva_proceso_detalle.referencia2),11,10) 
,substring(bbva_proceso_detalle.referencia2,1,1) 
order by bbva_proceso_detalle.c_local";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function recaudadora_conciliado(?recaud_bbva_proceso_detalle $obj = null)
    {
        $sql = "SELECT recaudo_bbva_571 FROM periodos (nolock) 
    where c_ano=substring('{$obj->getPeriodo()}',1,4) and c_mes=substring('{$obj->getPeriodo()}',5,2) ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
