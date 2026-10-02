<?php
require_once dirname(__DIR__) . '/dao/dao_fin_documentos_de_venta.php';
class bo_fin_documentos_de_venta
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_documentos_de_venta();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function procesarBoleta(?fin_documentos_de_venta $obj = null)
    {
        return $this->dao->procesarBoleta($obj);
    }

    public function listarID(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select v.cc_ventas, 
    p.c_persona,
    v.c_punto_de_venta, 
    dbo.fc_fecha_from(v.fecha) fecha, 
    v.observacion, 
    c_persona_ref,
    v.c_local,
    v.cod_documento,
    v.num_documento,
    CASE WHEN ISNUMERIC(p.c_cmp) = 1 AND CAST(p.c_cmp AS INT) > 0 THEN RTRIM(p.c_cmp) + ' - ' + RTRIM(p.nombre) ELSE RTRIM(p.ruc) + ' - ' + RTRIM(p.nombre) END AS nombre_completo, v.flag
    FROM documentos_de_venta v WITH (NOLOCK) 
    INNER JOIN personas p WITH (NOLOCK) 
    ON RIGHT('000000' + RTRIM(CAST(V.c_persona AS VARCHAR(6))), 6)  = p.c_persona 
    WHERE v.cc_ventas = {$obj->getCc_ventas()}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

   /* public function listar(?fin_documentos_de_venta $obj = null)
    {
        $sql = "SELECT dv.cc_ventas,
        dv.num_documento,
        dv.cod_documento,
        dbo.fc_v1_fecha_texto(dv.fecha) AS fecha,
        pe.c_cmp,
        pe.nombre AS nombrecolegiado,
        dv.usuario_registro,
        dv.host_registro,
        RTRIM(ipc.cod_forma_de_pago) AS cod_forma_de_pago,
        dbo.fc_v1_parametro_valor('items_planilla_de_cobranza', 'cod_forma_de_pago', ipc.cod_forma_de_pago) AS cod_forma_de_pago_text,
        dv.usuario_registro AS c_usuario,
        ISNULL('(CEP=>' + pe.c_cmp + ')', '(RUC=>' + pe.ruc + ')') AS codx,
        u.usuario AS nombreu,
        ipc.num_referencia,
        dbo.fc_fecha_texto(ipc.fecha_referencia) AS fecha_referencia,
        ipc.cta_cte_deposito,
        bbb.nombre AS nombre_banco,
        dv.valor_venta,
        dv.flag,
        dbo.fc_v1_parametro_valor('documentos_de_venta', 'flag', dv.flag) AS flag_text
    FROM documentos_de_venta dv (NOLOCK)
    LEFT JOIN personas pe 
    ON RIGHT(REPLICATE('0', 6) + LTRIM(RTRIM(dv.c_persona)), 6) = RIGHT(REPLICATE('0', 6) + LTRIM(RTRIM(pe.c_persona)), 6)
    LEFT JOIN (
    SELECT 
        cc_ventas, 
        MAX(cod_forma_de_pago) AS cod_forma_de_pago,
        MAX(num_referencia) AS num_referencia,
        MAX(fecha_referencia) AS fecha_referencia,
        MAX(cta_cte_deposito) AS cta_cte_deposito
    FROM items_planilla_de_cobranza (NOLOCK)
    GROUP BY cc_ventas
    ) ipc ON ipc.cc_ventas = dv.cc_ventas
    LEFT JOIN seg_usuarios u (NOLOCK) 
    ON u.usuario = dv.usuario_registro
    LEFT JOIN cuentas_corrientes ccc (NOLOCK) 
    ON ccc.c_cta_corriente = ipc.cta_cte_deposito
    LEFT JOIN gen_bancos bbb (NOLOCK) 
    ON bbb.c_banco = ccc.c_banco
    WHERE pe.nombre like '%" . $obj->getNombre_completo() . "%'";

        if (strlen($obj->getC_local()) > 0) {
            $sql .= " and dv.c_local='{$obj->getC_local()}'";
        }
        if (strlen($obj->getFlag()) > 0) {
            $sql .= " and dv.flag='{$obj->getFlag()}'";
        }

        $sql .= " AND dv.fecha BETWEEN '{$obj->getCod_desde()} 00:00:00' AND '{$obj->getCod_hasta()} 23:59:59'
        ORDER BY dv.num_documento DESC";
      echo $sql;
        return $this->dao->consulta($sql);
    }
    */
         public function listar(?fin_documentos_de_venta $obj = null)
    {
        $sql = "SELECT dv.cc_ventas,dv.cod_documento,dv.num_documento,dbo.fc_fecha_texto(dv.fecha) fecha,pe.c_cmp,pe.ruc,pe.nombre,pe.num_documento,dv.usuario_registro,dv.total_original,dv.flag,
        dbo.fc_v1_parametro_valor('documentos_de_venta', 'flag', dv.flag) AS flag_text
FROM Documentos_de_venta dv left join personas pe on pe.c_persona=dv.c_persona
    WHERE pe.nombre like '%" . $obj->getNombre_completo() . "%'";

        if (strlen($obj->getC_local()) > 0) {
            $sql .= " and dv.c_local='{$obj->getC_local()}'";
        }
        if (strlen($obj->getFlag()) > 0) {
            $sql .= " and dv.flag='{$obj->getFlag()}'";
        }

        $sql .= " AND dv.fecha BETWEEN '{$obj->getCod_desde()} 00:00:00' AND '{$obj->getCod_hasta()} 23:59:59'
        ORDER BY dv.num_documento DESC";
       
        return $this->dao->consulta($sql);
    }
    
 public function reporte_listar(?fin_documentos_de_venta $obj = null)
  {
        $sql = " SELECT dv.cc_ventas,dv.cod_documento ,dv.num_documento,dbo.fc_fecha_texto(dv.fecha) fecha,p.c_cmp,p.ruc,p.nombre,p.num_documento,dv.usuario_registro,dv.total_original,dv.flag,
        dbo.fc_v1_parametro_valor('documentos_de_venta', 'flag', dv.flag) AS flag_text
FROM Documentos_de_venta dv left join personas p on p.c_persona=dv.c_persona
WHERE  dv.c_local='{$obj->getC_local()}'
AND dv.fecha BETWEEN '{$obj->getCod_desde()} 00:00:00' AND '{$obj->getCod_hasta()} 23:59:59'";
        return $this->dao->consulta($sql);
    }

 public function reporte_listar_detalle(?fin_documentos_de_venta $obj = null)
  {
        $sql = " SELECT dv.cc_ventas,dv.cod_documento,dv.num_documento,dbo.fc_fecha_texto(dv.fecha) fecha,p.c_cmp,p.ruc,p.nombre,p.num_documento,dv.usuario_registro,dv.total_original,dv.flag,
        dbo.fc_v1_parametro_valor('documentos_de_venta', 'flag', dv.flag) AS flag_text
FROM Documentos_de_venta dv left join personas p on p.c_persona=dv.c_persona
WHERE  dv.c_local='{$obj->getC_local()}'
AND dv.fecha BETWEEN '{$obj->getCod_desde()} 00:00:00' AND '{$obj->getCod_hasta()} 23:59:59'";
//echo $sql;
        return $this->dao->consulta($sql);
    }

 public function reporte_listar_detalle_pagos(?fin_documentos_de_venta $obj = null)
  {
        $sql = " select i.cod_forma_de_pago,i.monto,dbo.fc_fecha_texto(i.fecha_referencia) fecha_referencia, i.cta_cte_deposito,i.num_referencia ,b.nombre nombre_banco  
from items_planilla_de_cobranza i left join gen_bancos b on b.c_banco=i.c_banco_ref where i.cc_ventas=  '{$obj->getCc_ventas()}'  ";
 //echo $sql;
        return $this->dao->consulta($sql);
    }

 public function reporte_listar_detalle_concepto(?fin_documentos_de_venta $obj = null)
  {
        $sql = " select i.c_articulo,i.nombre_pr,i.cantidad,i.venta,i.ano,i.mes_desde,i.mes_hasta ,(i.cantidad * i.venta) total
 from items_documentos_de_venta i 
 where i.cc_ventas='{$obj->getCc_ventas()}' ";
//echo $sql;
        return $this->dao->consulta($sql);
    }

    public function sumarListar(?fin_documentos_de_venta $obj = null)
    {
        $sql = "SELECT dbo.fc_v1_parametro_valor('items_planilla_de_cobranza', 'cod_forma_de_pago', ipc.cod_forma_de_pago) AS cod_forma_de_pago_text,
    SUM(ipc.monto) AS total_monto
    FROM documentos_de_venta dv
    INNER JOIN items_planilla_de_cobranza ipc ON dv.cc_ventas = ipc.cc_ventas
    WHERE dv.c_local = '{$obj->getC_local()}'
        AND dv.fecha BETWEEN '{$obj->getCod_desde()}' AND '{$obj->getCod_hasta()}'
    GROUP BY ipc.cod_forma_de_pago";
        return $this->dao->consulta($sql);
    }


    public function listarIDcabecera(?fin_documentos_de_venta $obj = null)
    {
        $sql = "SELECT 
    v.cc_ventas, 
    p.c_persona,
    v.c_punto_de_venta, 
    dbo.fc_fecha_texto(v.fecha) AS fecha_text, 
    v.observacion,
    p.tipo_direccion,
    v.c_local,
    v.valor_venta,
    v.cod_documento,
    dbo.fc_v1_parametro_valor('documentos_de_venta', 'cod_documento', v.cod_documento) AS cod_documento_text,
    v.num_documento,
    RTRIM(p.nombre) AS razon_social,
    p.c_cmp,
    CASE 
        WHEN p.ruc IS NOT NULL AND LTRIM(RTRIM(p.ruc)) <> '' THEN RTRIM(p.ruc)
        ELSE RTRIM(p.num_documento)
    END AS ruc,
    CASE 
        WHEN fp.hasE = 1 AND fp.hasV = 1 THEN 'E-V'
        WHEN fp.hasE = 1 THEN 'E'
        WHEN fp.hasV = 1 THEN 'V'
        ELSE NULL
    END AS forma_pago,

    v.flag
FROM documentos_de_venta v WITH (NOLOCK)
INNER JOIN personas p WITH (NOLOCK)
    ON RIGHT('000000' + RTRIM(CAST(v.c_persona AS VARCHAR(6))), 6) = p.c_persona
LEFT JOIN (
    SELECT 
        cc_ventas,
        MAX(CASE WHEN cod_forma_de_pago = 'E' THEN 1 ELSE 0 END) AS hasE,
        MAX(CASE WHEN cod_forma_de_pago = 'V' THEN 1 ELSE 0 END) AS hasV
    FROM items_planilla_de_cobranza WITH (NOLOCK)
    GROUP BY cc_ventas
) fp
    ON fp.cc_ventas = v.cc_ventas
WHERE v.cc_ventas = {$obj->getCc_ventas()}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }



    public function listarPersonasPagos(?fin_documentos_de_venta $obj = null)
    {

        $sql = "select D.fecha fecha1,'CAJA' origen,D.cod_documento,D.num_documento,dbo.fc_v1_fecha_hora(D.fecha) fecha,D.valor_venta,i.cod_forma_de_pago, 
i.num_referencia,dbo.fc_v1_fecha_hora(i.fecha_referencia) fecha_referencia,i.cta_cte_deposito,B.nombre,i.monto,substring(D.observacion,1,50) observacion,d.flag,space(250) obs1
from Documentos_de_venta D LEFT JOIN ITEMS_PLANILLA_DE_COBRANZA i on i.cod_documento=D.cod_documento and D.num_documento=i.num_documento LEFT JOIN bancos B ON B.c_banco=i.c_banco_REF 
where D.c_persona='" . $obj->getC_persona() . "'
UNION ALL 
SELECT 
CONVERT(DATETIME, (LEFT(LTRIM(RTRIM(fecha)),4) + '-' + SUBSTRING(LTRIM(RTRIM(fecha)),5,2) + '-' + SUBSTRING(LTRIM(RTRIM(fecha)),7,2) + ' ' + SUBSTRING(LTRIM(RTRIM(hora)),1,2) 
+ ':' + SUBSTRING(LTRIM(RTRIM(hora)),3,2) + ':' + SUBSTRING(LTRIM(RTRIM(hora)),5,2)+'.001') , 120),
'REC. BCP', 'OP',
CAST(id AS CHAR(10)), 
dbo.fc_v1_fecha_hora( CONVERT(DATETIME, (LEFT(LTRIM(RTRIM(fecha)),4) + '-' + SUBSTRING(LTRIM(RTRIM(fecha)),5,2) + '-' + SUBSTRING(LTRIM(RTRIM(fecha)),7,2) + ' ' + SUBSTRING(LTRIM(RTRIM(hora)),1,2) 
+ ':' + SUBSTRING(LTRIM(RTRIM(hora)),3,2) + ':' + SUBSTRING(LTRIM(RTRIM(hora)),5,2)+'.001') , 120))
, total_distribuir, 'V', numero_operacion, 
dbo.fc_v1_fecha_hora( CONVERT(DATETIME, (LEFT(LTRIM(RTRIM(fecha)),4) + '-' + SUBSTRING(LTRIM(RTRIM(fecha)),5,2) + '-' + 
SUBSTRING(LTRIM(RTRIM(fecha)),7,2) + ' ' + SUBSTRING(LTRIM(RTRIM(hora)),1,2) + ':' + SUBSTRING(LTRIM(RTRIM(hora)),3,2) 
+ ':' + SUBSTRING(LTRIM(RTRIM(hora)),5,2)+'.001') , 120))
, 'REC 666', 'BCP', total_distribuir, substring(DATO_ADICIONAL,1,50),'*' ,obs
FROM bcp_proceso_detalle 
WHERE c_persona='" . $obj->getC_persona() . "'
UNION ALL 
select fecha_pago,'REC. BBVA','OP', CAST(id AS CHAR(10)),
dbo.fc_v1_fecha_hora(fecha_pago),total,'V',num_movimiento,FECHA_PAGO ,'REC '+RECAUDO,
'BBVA',total,substring(REFERENCIA2,1,150),'*',adicional from bbva_proceso_detalle where c_persona='" . $obj->getC_persona() . "' ORDER BY 1 desc
";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPersonasPagos_ec($origen, $cod_documento, $num_documento, $c_persona)
    {
        if ($origen == 'CAJA') {
            $sql = "select  substring(num_documento,5,7) num_documento,monto from estado_de_cuenta where cod_documento_ref='$cod_documento' and num_documento_ref='$num_documento' and c_persona='$c_persona' and monto<0 and cod_documento='99' ORDER BY substring(num_documento,8,4) desc,substring(num_documento,5,2) desc";
        }
        if ($origen == 'REC. BCP') {
            $sql = "select  substring(num_documento,5,7) num_documento,monto from estado_de_cuenta where cod_documento='99' and rtrim(num_documento_ref)='OPE-'+RTRIM('$num_documento') and c_persona='$c_persona' and cod_procedencia='BCP' and monto<0 and cod_documento='99' oRDER BY substring(num_documento,8,4) desc,substring(num_documento,5,2) desc";
        }
        if ($origen == 'REC. BBVA') {
            $sql = "select  substring(num_documento,5,7) num_documento,monto from estado_de_cuenta where cod_documento='99' and rtrim(num_documento_ref)='OPE-'+RTRIM('$num_documento') and c_persona='$c_persona' and cod_procedencia='BBVA'  and monto<0  and cod_documento='99' ORDER BY substring(num_documento,8,4) desc,substring(num_documento,5,2) desc";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPersonasooOtrosPagos_ec($origen, $cod_documento, $num_documento)
    {
        $sql = "";
        if ($origen == 'CAJA') {
            $sql = "SELECT * FROM items_documentos_de_venta (NOLOCK) WHERE NUM_DOCUMENTO IN  ('$num_documento') AND COD_DOCUMENTO='$cod_documento';";
        }

        return $this->dao->consulta($sql);
    }





    /********        ojo no se son         *****/

    public function listarPeriodos(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select c_mes+'/'+c_ano as periodo
        FROM periodos (NOLOCK) 
        WHERE c_mes BETWEEN 1 AND 12
        AND c_ano+c_mes BETWEEN 200809 AND  (CAST(YEAR(GETDATE()) AS CHAR(4))+REPLICATE('0',2-LEN(CAST(MONTH(GETDATE()) AS CHAR(2))))+CAST(MONTH(GETDATE()) AS CHAR(2)))
        ORDER BY c_ano+c_mes desc";
        return $this->dao->consulta($sql);
    }

    public function listarPersonasId(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select 
        d.flag,
        d.cod_documento,
        d.num_documento,
        d.valor_venta,
        b.nombre AS banco_nombre,
        p.cta_cte_deposito,
        p.num_referencia,
        dbo.fc_fecha_texto(d.fecha) AS fecha_documento,
        dbo.fc_fecha_texto(p.fecha_referencia) AS fecha_referencia,
        RTRIM(p.cod_forma_de_pago) AS cod_forma_de_pago,
        CASE 
        WHEN RTRIM(p.cod_forma_de_pago) = 'V' THEN 'VOUCHER'
        WHEN RTRIM(p.cod_forma_de_pago) = 'E' THEN 'EFECTIVO'
        ELSE 'Otro'
        END AS cod_forma_de_pago_text
        FROM 
        documentos_de_venta AS d WITH (NOLOCK)
        LEFT JOIN 
        items_planilla_de_cobranza AS p WITH (NOLOCK)
        ON d.cod_documento = p.cod_documento AND d.num_documento = p.num_documento
        LEFT JOIN 
        bancos AS b WITH (NOLOCK)
        ON b.c_banco = p.c_banco_ref
        INNER JOIN 
        personas AS pp WITH (NOLOCK)
        ON pp.c_persona = d.c_persona
        WHERE 
        pp.c_persona = '" . $obj->getC_persona() . "'
        ORDER BY 
        d.fecha DESC";

        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPersonasDetalle(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select 
        i.cod_documento,
        i.num_documento,
        i.linea,
        i.c_articulo,
        i.nombre_pr,
        i.ano,
        i.mes_desde,
        i.mes_hasta,
        i.cantidad,
        i.venta
        FROM 
        documentos_de_venta AS d WITH (NOLOCK)
        INNER JOIN 
        items_planilla_de_cobranza AS p WITH (NOLOCK) 
        ON d.cod_documento = p.cod_documento AND d.num_documento = p.num_documento
        INNER JOIN 
        personas AS pp WITH (NOLOCK) 
        ON d.c_persona = pp.c_persona
        LEFT JOIN 
        items_documentos_de_venta AS i WITH (NOLOCK) 
        ON d.cod_documento = i.cod_documento AND d.num_documento = i.num_documento
        WHERE 
        pp.c_persona = '" . $obj->getC_persona() . "' 
        AND d.num_documento = '" . $obj->getNum_documento() . "' 
        AND d.cod_documento = '" . $obj->getCod_documento() . "'
        ORDER BY 
        i.linea";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    /*reporte por conceptos**/
    public function Cab_ingresosConceptos(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select 
         rtrim(a.c_cuenta_ventas) as c_cuenta_ventas, pc.nombre nombre_pcge, 
MAX(CASE WHEN d.C_PERSONA = '122406' THEN 'ESSALUD PLA' ELSE '' END) AS pla
FROM items_documentos_de_venta i WITH (NOLOCK) 
INNER JOIN documentos_de_venta d WITH (NOLOCK) 
ON i.cod_documento = d.cod_documento and i.num_documento=d.num_documento
INNER JOIN articulos a WITH (NOLOCK) ON i.c_articulo = a.c_articulo 
INNER JOIN plan_de_cuentas_year pc WITH (NOLOCK) ON pc.c_cuenta = a.c_cuenta_ventas  and pc.version=5
        WHERE d.fecha >= '{$obj->getCod_desde()} 00:00:00' 
        AND d.fecha <= '{$obj->getCod_hasta()} 23:59:59'
        AND d.c_local = '{$obj->getC_local()}'
        AND d.flag = '*'
        GROUP BY a.c_cuenta_ventas, pc.nombre
        ORDER BY a.c_cuenta_ventas, pc.nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function detalle_ingresosConceptos(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select RTRIM(i.c_articulo) AS c_articulo, LTRIM(i.nombre_pr) + CASE WHEN i.ano IS NULL OR i.ano = '' THEN '' ELSE ' - ' + i.ano END AS nombre, 
SUM( CASE WHEN ISNULL(i.C_IGV, '&') = '*' THEN ROUND((i.precio * i.cantidad) / (d.factor_igv + 1), 2) WHEN 
ISNULL(i.C_IGV, '&') = '&' THEN ROUND(i.venta * i.cantidad, 2) ELSE 0 END ) AS abono, SUM(i.precio * i.cantidad) AS total,
MIN(ISNULL(mes_desde, '')) AS mes_desde, MAX(ISNULL(mes_hasta, '')) AS mes_hasta, ISNULL(i.ano, '') AS c_anho, a.c_cuenta_ventas, 
pc.nombre nombre_pcge, CASE WHEN d.c_persona = '122406' THEN 'ESSALUD PLA' ELSE '' END AS pla 
FROM items_documentos_de_venta i WITH (NOLOCK) 
INNER JOIN documentos_de_venta d WITH (NOLOCK) ON i.cod_documento = d.cod_documento and i.num_documento=d.num_documento
INNER JOIN articulos a WITH (NOLOCK) ON i.c_articulo = a.c_articulo 
INNER JOIN plan_de_cuentas pc WITH (NOLOCK) ON pc.c_cuenta = a.c_cuenta_ventas 
        WHERE d.fecha >= '{$obj->getCod_desde()} 00:00:00' 
        AND d.fecha <= '{$obj->getCod_hasta()} 23:59:59'
        AND d.c_local = '{$obj->getC_local()}' 
        AND a.c_cuenta_ventas = '{$obj->getC_cuenta_ventas()}' 
        GROUP BY i.c_articulo, LTRIM(i.nombre_pr) + 
        CASE 
        WHEN i.ano IS NULL OR i.ano = '' THEN '' 
        ELSE ' - ' + i.ano 
        END, 
        ISNULL(i.ano, ''), a.c_cuenta_ventas, pc.nombre, 
        CASE 
        WHEN d.c_persona = '122406' THEN 'ESSALUD PLA' 
        ELSE '' 
        END 
        ORDER BY a.c_cuenta_ventas, i.c_articulo, LTRIM(i.nombre_pr) + 
        CASE 
        WHEN i.ano IS NULL OR i.ano = '' THEN '' 
        ELSE ' - ' + i.ano 
        END";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function detalle_ingresosConceptos_articulo(?fin_documentos_de_venta $obj = null)
    {
        $sql = "select   d.cod_documento, d.num_documento, dbo.fc_fecha_texto(d.fecha) AS fecha_texto, p.c_cmp AS cep,
RTRIM(p.nombre) AS nombre_cliente, RTRIM(c.cta_cte_deposito) + ' OP:' + RTRIM(c.num_referencia) + ' F:' + RTRIM(dbo.fc_fecha_texto(c.fecha_referencia)) AS banco, 
SUM(CASE WHEN c.cod_forma_de_pago = 'V' THEN i.precio * i.cantidad ELSE 0 END) AS total_voucher, 
SUM(CASE WHEN c.cod_forma_de_pago = 'E' THEN i.precio * i.cantidad ELSE 0 END) AS total_efectivo, a.nombre AS nombre_articulo,
a.c_articulo 
FROM items_documentos_de_venta i WITH (NOLOCK)
INNER JOIN documentos_de_venta d WITH (NOLOCK) ON i.cod_documento = d.cod_documento and i.num_documento=d.num_documento
INNER JOIN articulos a WITH (NOLOCK) ON i.c_articulo = a.c_articulo 
INNER JOIN plan_de_cuentas pc WITH (NOLOCK) ON pc.c_cuenta = a.c_cuenta_ventas 
inner join items_planilla_de_cobranza c on c.cod_documento=d.cod_documento and c.num_documento=d.num_documento
inner join Personas p on p.c_persona=d.c_persona
WHERE d.fecha >= '{$obj->getCod_desde()} 00:00:00' 
        AND d.fecha <= '{$obj->getCod_hasta()} 23:59:59'
        AND d.c_local = '{$obj->getC_local()}' 
        AND i.c_articulo = '{$obj->getC_articulo()}' 
group by d.cod_documento, d.num_documento, dbo.fc_fecha_texto(d.fecha) , p.c_cmp,RTRIM(p.nombre) , 
a.nombre, RTRIM(c.cta_cte_deposito), RTRIM(c.num_referencia), RTRIM(dbo.fc_fecha_texto(c.fecha_referencia)) ,a.c_articulo";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    /**
     * Dashboard - "Recibo Interno" = Documentos_de_venta con cod_documento='RC'
     * (confirmado literal en caja/recib_print_plantilla.php). El monto sale de
     * valor_venta, y el filtro de periodo siempre usa la columna 'fecha'.
     */
    public function recibosPorMes($anho, $c_local)
    {
        $sql = "SELECT MONTH(fecha) AS mes, COUNT(*) AS cantidad, SUM(valor_venta) AS monto
        FROM Documentos_de_venta
        WHERE YEAR(fecha) = '{$anho}'
          AND c_local = '{$c_local}'
          AND RTRIM(cod_documento) = 'RC'
        GROUP BY MONTH(fecha)
        ORDER BY mes";
        return $this->dao->consulta($sql);
    }

    public function cantidadRecibos($anho, $mes, $c_local)
    {
        $filtro_mes = !empty($mes) ? " AND MONTH(fecha) = '{$mes}'" : "";

        $sql = "SELECT  COUNT(*) AS cantidad, COALESCE(SUM(valor_venta), 0) AS monto
            FROM documentos_de_venta
            WHERE YEAR(fecha) = '{$anho}'
            {$filtro_mes}
            AND c_local = '{$c_local}'
            AND RTRIM(cod_documento) = 'RC'
            and flag<>'A'";

        return $this->dao->consulta($sql);
    }

    public function listarAnhos()
    {
        $sql = "SELECT DISTINCT YEAR(fecha) AS anho
        FROM documentos_de_venta
        WHERE fecha IS NOT NULL
        ORDER BY anho DESC";
        return $this->dao->consulta($sql);
    }
}
