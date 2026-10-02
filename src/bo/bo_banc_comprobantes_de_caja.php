<?php
require_once dirname(__DIR__) . '/dao/dao_banc_comprobantes_de_caja.php';
class bo_banc_comprobantes_de_caja
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_comprobantes_de_caja();
    }
    /******EGRESOS****/
    public function procesarEgresos(?banc_comprobantes_de_caja $obj)
    {
        return $this->dao->procesarEgresos($obj);
    }
    /******INGRESOS****/
    public function procesarIngresos(?banc_comprobantes_de_caja $obj)
    {
        return $this->dao->procesarIngresos($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(?banc_comprobantes_de_caja $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
    public function listarAnhos(?banc_comprobantes_de_caja $obj = null)
    {
        $sql = "select DISTINCT cod_ano as anho
            FROM comprobantes_de_caja
            WHERE cod_ano IS NOT NULL
            ORDER BY cod_ano";
        return $this->dao->consulta($sql);
    }
    public function listarID(?banc_comprobantes_de_caja $obj = null)
    {
        $sql = "SELECT 
        cc.cc_documento,
        cc.c_persona,
        RTRIM(p.nombre) AS nombre_completo,
        cc.numero,
        cc.c_local,
        cc.cod_ano,
        cc.cod_mes,
        cc.comprb_cta_cte,
        cc.c_banco,
        cc.c_cta_corriente,
        cc.c_banco+'-'+cc.c_cta_corriente as banco_text,
        cc.cod_ingreso_egreso,
        cc.cod_comprobante,
        dbo.fc_v1_fecha_from(cc.fecha) AS fecha_documento,
       
        cc.num_boleta_cheque,
        cc.c_liquidacion_caja_chica,
        cc.observacion,
                cc.observacion2,
        cc.flag,
        dbo.fc_v1_parametro_valor('comprobantes_de_caja','flag',cc.flag) as flag_text,
        cc.usuario,
        cc.movimiento,
     rtrim(cc.c_forma_cancelacion) c_forma_cancelacion,p.ruc,
        dbo.fc_v1_fecha_hora(cc.fecha_proc) AS fecha_creacion,cc.monto,cu.c_cuenta_pcge2014,
        cc.comprobante
        FROM comprobantes_de_caja cc
        LEFT JOIN personas p ON p.c_persona = cc.c_persona
        left join cuentas_corrientes cu on cu.c_cta_corriente=cc.c_cta_corriente
        WHERE cc.cc_documento ='{$obj->getCc_documento()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listaTipoDocumento()
    {
        $sql = "select c_tipo_de_documento,   
        c_tipo_de_documento + ' - '+ nombre as nombre
        FROM gen_tipo_de_documentos (nolock)
        WHERE c_tipo_de_documento in ('FP','BP', 'AC', 'RH','BE','RS','BV','CC','TC','FE')
        order by nombre ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listaEgresos(?banc_comprobantes_de_caja $obj = null)
    {
        $sql = "SELECT  
        cc.cc_documento,
        cc.c_persona,
        RTRIM(p.nombre) AS nombre_completo,
        cc.numero,
        cc.c_local,
        cc.cod_ano,
        cc.cod_mes,
        cc.comprb_cta_cte,
        cc.c_banco,
        cc.c_cta_corriente,
        b.nombre+'-'+cc.c_cta_corriente as banco_text,
        cc.cod_ingreso_egreso,
        cc.cod_comprobante,
       
           dbo.fc_v1_fecha_texto(cc.fecha) AS fecha_documento,
        cc.num_boleta_cheque,
        cc.c_liquidacion_caja_chica,
        cc.observacion,
        cc.flag,
        cc.usuario,
        cc.movimiento,
     rtrim(cc.c_forma_cancelacion) c_forma_cancelacion,p.ruc,
        dbo.fc_v1_fecha_hora(cc.fecha_proc) AS fecha_creacion,cc.monto,cc.comprobante,
          dbo.fc_v1_parametro_valor('documentos_de_compras','flag',cc.flag) as flag_text,
               dbo.fc_v1_parametro_valor('documentos_de_compras','flag', isnull(cc.flag_centralizado,'&')) as flag_text_centralizado,
        isnull(cc.flag_centralizado,'&') flag_centralizado
        FROM comprobantes_de_caja cc
        LEFT JOIN personas p ON p.c_persona = cc.c_persona
        left join bancos b on b.c_banco=cc.c_banco
        WHERE cc.c_local='{$obj->getC_local()}' and cc.cod_ano='{$obj->getCod_ano()}' and cc.cod_mes='{$obj->getCod_mes()}' and cc.cod_ingreso_egreso='{$obj->getCod_ingreso_egreso()}' ";
        if (!empty($obj->getC_banco())) {
            $sql .= " and b.c_banco='" . $obj->getC_banco() . "' and cc.c_cta_corriente='" . $obj->getC_cta_corriente() . "' ";
        }
        if (!empty($obj->getNum_boleta_cheque())) {
            $sql .= " and cc.num_boleta_cheque like '%" . $obj->getNum_boleta_cheque() . "' ";
        }
        if (!empty($obj->getMonto())) {
            $sql .= " and cc.monto='" . $obj->getMonto() . "' ";
        }
        if (!empty($obj->getObservacion())) {
            $sql .= " and cc.observacion like'%" . $obj->getObservacion() . "%' ";
        }

        $sql . " order by bo.fc_v1_fecha_texto(cc.fecha) desc,cc.num_boleta_cheque desc";
      //  echo $sql;
        return $this->dao->consulta($sql);
    }
    /*estado de cuenta reportes*/
    public function libro_banco_data($cr, $cc, $cyear, $mes, $tipo)
    {
        $sql = "SELECT c.cc_documento,
	DBO.FC_FECHA_TEXTO(c.fecha) as fecha,C.num_boleta_cheque,C.Observacion,C.flag,
    (case C.cod_ingreso_egreso when 'I' then C.monto else c.monto*-1 end) as monto,
    C.comprobante,C.COMPRB_CTA_CTE,C.cod_ingreso_egreso,C.Observacion2,c.c_forma_cancelacion ,c.numero
FROM Comprobantes_de_caja C (NOLOCK) WHERE C.c_local='" . $cr . "' AND C.C_CTA_CORRIENTE=substring('" . $cc . "',8,30)
AND C.flag<>'&'
AND C.cod_ano='" . $cyear . "' AND C.cod_MES='" . $mes . "' and cod_ingreso_egreso like '" . $tipo . "'
ORDER BY C.FECHA ASC,C.num_boleta_cheque";

        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function libro_banco_saldoinicial($cc, $x)
    {
        $sql = "  SELECT TOP 1 movimiento,ingreso,egreso
   FROM movimiento_cta_cte  (nolock) 
   WHERE c_cta_corriente='" . $cc . "'
   AND ((c_ano*100)+COD_MES)<('" . $x . "')
  ORDER BY ((c_ano*100)+COD_MES) DESC
  ";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function saldo_banco($cod_banco, $cc, $c_year, $desde)
    {
        $sql = "Select top 1 saldo_final,cheques                             
                From Saldos_Bancos_Cuentas (nolock)  Where year(fecha)='" . $c_year . "' and month(fecha)='" . $desde . "'
And c_banco = '" . $cod_banco . "'
 And c_cta_cte ='" . $cc . "'  order by fecha desc
";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function saldos_cuenta_banco($c_banco, $cc)
    {
        $sql = " 
SELECT c.c_ano,c.cod_mes,c.movimiento,c.comprobante,BANCOS.NOMBRE AS BANCO,'" . $cc . "' AS CUENTA ,c.ingreso,c.egreso,bb.saldo_final 
FROM movimiento_cta_cte c (NOLOCK) 
INNER JOIN BANCOS(NOLOCK) ON BANCOS.C_BANCO='" . $c_banco . "'
left join saldos_bancos_cuentas bb on bb.C_CTA_CTE=c.c_cta_corriente and c.c_banco=bb.c_banco
and year(bb.fecha)=c.c_ano and month(bb.fecha)=c.cod_mes
WHERE c.C_BANCO='" . $c_banco . "' AND c.C_CTA_CORRIENTE='" . $cc . "'  order by c.c_ano desc,c.cod_mes desc";

        //  echo $sql;
        return $this->dao->consulta($sql);
    }

    public function estado_cheques($c_local, $cc, $anho, $hasta, $t, $dia)
    {

        $sql = "
select  num_boleta_cheque,DBO.FC_FECHA_TEXTO(fecha) as fecha1,observacion,observacion2,
DBO.FC_FECHA_TEXTO(fecha_concluir) as fecha_concluir,monto ,fecha from comprobantes_de_caja 
 (nolock) where c_local='" . $c_local . "' 
and c_cta_corriente=substring('" . $cc . "',8,30)
and c_forma_cancelacion='CH'
and flag='*'";
        if ($t == "P") {
            $sql = $sql . " and (FECHA_CONCLUIR >=(DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,'" . $dia . "') + 1,0))) OR FECHA_CONCLUIR IS NULL) AND C_FORMA_CANCELACION='CH' 
 AND LEN(RTRIM(NUM_BOLETA_CHEQUE))>0 AND fecha <= (DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,'" . $dia . "') + 1,0)))";
        } else {
            $sql = $sql . " AND YEAR(fecha_concluir)='" . $anho . "' AND MONTH(fecha_concluir)='" . $hasta . "'";
        }
        $sql = $sql . ' order by fecha asc';
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /**
     * Dashboard bancos — totales y series por mes de ingresos/egresos.
     * Solo cuenta comprobantes ya procesados (flag='*'), no pendientes ni anulados.
     */
    public function listarAnhosGeneral()
    {
        $sql = "SELECT DISTINCT cod_ano AS anho
        FROM comprobantes_de_caja
        WHERE cod_ano IS NOT NULL
        ORDER BY anho DESC";
        return $this->dao->consulta($sql);
    }

    public function totalTipo($anho, $mes, $c_local, $tipo)
    {
        $filtro_mes = !empty($mes) ? " AND cod_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad, SUM(monto) AS monto
        FROM comprobantes_de_caja
        WHERE cod_ingreso_egreso = '{$tipo}'
          AND flag = '*'
          AND cod_ano = '{$anho}'{$filtro_mes}{$filtro_local}";
        return $this->dao->consulta($sql);
    }

    public function montoPorMesTipo($anho, $c_local, $tipo)
    {
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT cod_mes AS mes, SUM(monto) AS monto
        FROM comprobantes_de_caja
        WHERE cod_ingreso_egreso = '{$tipo}'
          AND flag = '*'
          AND cod_ano = '{$anho}'{$filtro_local}
        GROUP BY cod_mes
        ORDER BY cod_mes";
        return $this->dao->consulta($sql);
    }
}
