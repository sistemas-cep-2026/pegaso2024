<?php
require_once dirname(__DIR__) . '/dao/dao_comp_documentos_de_compras.php';
class bo_comp_documentos_de_compras
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_comp_documentos_de_compras();
    }


    public function errores()
    {
        return $this->dao->errores();
    }

    public function procesar(comp_documentos_de_compras $obj)/*crear documento*/
    {
        return $this->dao->procesar($obj);
    }


    public function listaTipoDocumento()
    {
        $sql = "select c_tipo_de_documento,   
        c_tipo_de_documento + ' - '+ nombre as nombre
        FROM gen_tipo_de_documentos (nolock)
        WHERE  c_tipo_de_documento IN ('FE','RH','RS','BV')        
        order by nombre
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listaTipoDocumento_caja()
    {
        $sql = "select c_tipo_de_documento,   
        c_tipo_de_documento + ' - '+ nombre as nombre
        FROM gen_tipo_de_documentos (nolock)
        WHERE c_tipo_de_documento IN ('FE','RH','RS','BV') 
        OR  c_tipo_de_documento IN ('BE','BP','CC','TC ','DJ')
        order by nombre
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function Validarregistro(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select cc_compra,cod_ano,cod_mes,c_local from 
        documentos_de_compras 
        where c_persona='{$obj->getCc_persona()}' 
        and cod_documento='{$obj->getCod_documento()}' 
        and num_documento='{$obj->getNum_documento()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function ValidarRUC(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select count(*) as ruc from  personas
        where c_persona='{$obj->getCc_persona()}'  and len(rtrim(ruc))=11";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarID(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select c.cc_compra,
        c.cod_documento, 
        c.num_documento, 
        c.c_local,
        c.c_persona,
      isnull(p.ruc,isnull(p.num_documento,''))+' - '+rtrim(p.nombre) as razon_social,
        dbo.fc_fecha_from(c.fecha_documento) as fecha_documento,
        dbo.fc_fecha_texto(c.fecha_documento) as fecha_documento_print,
        dbo.fc_fecha_from(c.fecha_vencimiento) as fecha_vencimiento, 
        dbo.fc_fecha_texto(c.fecha_vencimiento) as fecha_vencimiento_print, 
          dbo.fc_fecha_from(c.fecha_de_registro) as fecha_creacion,
              dbo.fc_fecha_hora(c.fecha_de_registro) as fecha_creacion_print,
        c.cod_ano, 
        c.cod_mes, 
        c.observacion, 
        c.total,
        c.flag,
        c.porcentaje,
        c.c_usuario_crea ,c.c_liquidacion_caja_chica,c.comprobante,
        dbo.fc_v1_parametro_valor('documentos_de_compras','flag',c.flag) as flag_text,
        dbo.fc_v1_parametro_valor('documentos_de_compras','flag', isnull(c.flag_cancelado,'&')) as flag_text_cancelado,rtrim(c.error_text) error_text,
        c.tipo_desc,
        c.reten_numero,
        dbo.fc_fecha_from(c.reten_fecha) reten_fecha,
             dbo.fc_fecha_from(c.reten_fecha) as reten_fecha_print
        from documentos_de_compras c (nolock) inner join personas p (nolock)
        on p.c_persona=c.c_persona
        where c.cc_compra='{$obj->getCc_compra()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarReporte(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select  d.cc_compra,
        d.comprobante,
        d.cod_documento,
        d.num_documento,
        dbo.fc_fecha_texto(d.fecha_documento) as fecha_documento,
          isnull(p.ruc,isnull(p.num_documento,'')) ruc,
          p.nombre,
        d.total,
        d.observacion,
        d.flag,
        dbo.fc_v1_parametro_valor('documentos_de_compras','flag',d.flag) as flag_text,
        d.c_liquidacion_caja_chica,d.adelanto,
        dbo.fc_v1_parametro_valor('documentos_de_compras','flag', isnull(d.flag_cancelado,'&')) as flag_text_cancelado,
        isnull(d.flag_cancelado,'&') flag_cancelado,
        ch.flag as flag_caja
        ,d.cod_ano+'/'+d.cod_mes periodo,
        d.tipo_desc,
        d.reten_numero,
        dbo.fc_fecha_from(d.reten_fecha) reten_fecha,
             dbo.fc_fecha_from(d.reten_fecha) as reten_fecha_print  ,d.porcentaje

        from documentos_de_compras d (nolock) 
        inner join personas p (nolock) on p.c_persona=d.c_persona
        left join liquidaciones_caja_chica ch on ch.c_liquidacion_caja_chica=d.c_liquidacion_caja_chica
        where d.c_local='{$obj->getCc_local()}' 
        and d.cod_ano='{$obj->getCod_ano()}' 
        and d.cod_mes='{$obj->getCod_mes()}'";

        if (strlen($obj->getC_liquidacion_caja_chica()) > 0) {
            if ($obj->getC_liquidacion_caja_chica() === 'NULL') {
                $sql .= " and  (d.c_liquidacion_caja_chica IS NULL or d.c_liquidacion_caja_chica='')";
            } else {
                $sql .= " and isnull(d.c_liquidacion_caja_chica,0)>{$obj->getC_liquidacion_caja_chica()}";
            }
        }
        $sql .= " order by p.ruc , d.total desc";

        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarRepdoc(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select  d.cc_compra,
        d.comprobante,
        d.cod_documento,
        d.num_documento,
        dbo.fc_fecha_texto(d.fecha_documento) as fecha_documento,
        p.ruc,p.nombre,
        d.total,
        d.observacion,
        d.flag,
        dbo.fc_v1_parametro_valor('documentos_de_compras','flag',d.flag) as flag_text,
        dbo.fc_v1_parametro_valor('documentos_de_compras','flag',d.flag_cancelado) as flag_text_cancelado,d.flag_cancelado,
        d.c_liquidacion_caja_chica
        ,d.cod_ano+'/'+d.cod_mes periodo,
        d.tipo_desc,
        d.reten_numero,
        dbo.fc_fecha_from(d.reten_fecha) reten_fecha,
             dbo.fc_fecha_from(d.reten_fecha) as reten_fecha_print  ,d.porcentaje

        from documentos_de_compras d (nolock) inner join personas p (nolock)
        on p.c_persona=d.c_persona
        where d.c_local='{$obj->getCc_local()}' 
        and cod_ano='{$obj->getCod_ano()}' 
        and d.c_persona='{$obj->getCc_persona()}'
        order by p.ruc,d.total desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarRepdoc_total(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select l.nombre c_local, p.ruc,p.nombre, count(*) as cantidad, d.cod_mes, d.cod_ano 
from documentos_de_compras d (nolock) inner join personas p (nolock) 
on p.c_persona=d.c_persona 
inner join gen_local l on l.c_local=d.c_local
where  d.c_persona='{$obj->getCc_persona()}' 
group by l.nombre, p.ruc,p.nombre, d.cod_mes, d.cod_ano 
order by l.nombre,d.cod_ano desc ,d.cod_mes  desc";

        return $this->dao->consulta($sql);
    }


    public function listarID_sequgimiento(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select c.cc_compra,
        c.cod_documento, 
        c.num_documento, 
        c.c_local,
        c.c_persona,
        p.ruc+' - '+rtrim(p.nombre) as razon_social,
        dbo.fc_fecha_from(fecha_documento) as fecha_documento,
        dbo.fc_fecha_texto(fecha_documento) as fecha_documento_print,
        dbo.fc_fecha_from(c.fecha_vencimiento) as fecha_vencimiento, 
        dbo.fc_fecha_texto(c.fecha_vencimiento) as fecha_vencimiento_print, 
        c.cod_ano, 
        c.cod_mes, 
        c.observacion, 
        c.total,
        c.flag,
        c.porcentaje,
        c.c_usuario_crea ,c.c_liquidacion_caja_chica,c.comprobante,rtrim(c.error_text) error_text,
        c.tipo_desc,
        c.reten_numero,
        dbo.fc_fecha_from(c.reten_fecha) reten_fecha,
        dbo.fc_fecha_from(c.reten_fecha) as reten_fecha_print  ,
        c.porcentaje
        from documentos_de_compras c (nolock) inner join personas p (nolock)
        on p.c_persona=c.c_persona
        where  c.c_local='{$obj->getCc_local()}' 
        /*and c.cod_ano='{$obj->getCod_ano()}' */
        and c.c_persona='{$obj->getCc_persona()}'
        and c.cod_documento='{$obj->getCod_documento()}'
        and c.num_documento='{$obj->getNum_documento()}'
        ";
        // echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarID_segui_banco(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select dbo.fc_fecha_texto(cc.fecha) as fecha_documento,b.nombre,cc.c_cta_corriente,
        cc.num_boleta_cheque,cc.c_forma_cancelacion,ic.voucher,b.nombre,cc.comprobante,cc.observacion,ic.monto
        from comprobantes_de_caja cc 
        inner join items_comprobantes_de_caja ic
        on ic.numero=cc.numero
        inner join bancos b on b.c_banco=cc.c_banco
        where  cc.c_local='{$obj->getCc_local()}' 
        and ic.c_persona='{$obj->getCc_persona()}'
        and ic.cod_documento='{$obj->getCod_documento()}'
        and ic.num_documento='{$obj->getNum_documento()}'
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarID_segui_conta(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select v.voucher,v.ano_contable,
        v.cod_mes_contable,
        v.observacion,
        dbo.fc_fecha_texto(v.fecha) as fecha_documento,
        v.cod_documento,v.num_documento,v.c_subdiario
        from voucher v (nolock) 
        where v.numero='{$obj->getCc_compra()}'
        ";
        // echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarID_segui_contadet(?comp_documentos_de_compras $obj = null)
    {
        $sql = "select linea,c_cuenta,debe,haber 
        from items_voucher 
        where numero='{$obj->getCc_compra()}'
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function documentosBancos($c_local, $c_persona, $cod_documento)
    {
        $sql = "SELECT dc.cc_compra, dc.num_documento, dc.cod_documento, dbo.fc_fecha_texto(dc.fecha_documento) AS fecha_documento, dc.cod_ano, dc.cod_mes, dc.total, dc.total - dc.adelanto AS saldo,
            id.c_cuenta,id.haber, dc.observacion ,id.cc_compra_det
FROM documentos_de_compras dc
INNER JOIN Items_documentos_de_compra_cue id ON id.cc_compra=dc.cc_compra AND id.HABER>0 and id.debe=0 and substring(id.c_cuenta,1,1)<>'7'
   
            WHERE (dc.c_local = '{$c_local}'
                       AND dc.c_persona = '{$c_persona}'
            AND dc.cod_documento = '{$cod_documento}' and  dc.flag = '*') and (  dc.adelanto <> dc.total or dc.flag_cancelado = '&')
           
        ORDER BY fecha_documento DESC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /** Dashboard compras — años con documentos registrados (para combo de filtro) */
    public function listarAnhosGeneral()
    {
        $sql = "SELECT DISTINCT cod_ano AS anho
        FROM documentos_de_compras
        WHERE cod_ano IS NOT NULL
        ORDER BY anho DESC";
        return $this->dao->consulta($sql);
    }

    /** Dashboard compras — total del período, excluye anuladas (flag='A') */
    public function totalCompras($anho, $mes, $c_local)
    {
        $filtro_mes = !empty($mes) ? " AND cod_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad, SUM(total) AS monto
        FROM documentos_de_compras
        WHERE flag <> 'A'
          AND cod_ano = '{$anho}'{$filtro_mes}{$filtro_local}";
        return $this->dao->consulta($sql);
    }

    public function estadoCompras($anho, $mes, $c_local)
    {
        $filtro_mes = !empty($mes) ? " AND cod_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT
            CASE WHEN ISNULL(flag_cancelado,'&') = '&' THEN 'P' ELSE 'C' END AS estado,
            COUNT(*) AS cantidad,
            SUM(total) AS monto
        FROM documentos_de_compras
        WHERE flag <> 'A'
          AND cod_ano = '{$anho}'{$filtro_mes}{$filtro_local}
        GROUP BY CASE WHEN ISNULL(flag_cancelado,'&') = '&' THEN 'P' ELSE 'C' END";
        return $this->dao->consulta($sql);
    }

    /** Dashboard compras — cantidad y monto por mes del año, excluye anuladas */
    public function montoPorMes($anho, $c_local)
    {
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT cod_mes AS mes, COUNT(*) AS cantidad, SUM(total) AS monto
        FROM documentos_de_compras
        WHERE flag <> 'A'
          AND cod_ano = '{$anho}'{$filtro_local}
        GROUP BY cod_mes
        ORDER BY cod_mes";
        return $this->dao->consulta($sql);
    }

    /** Dashboard compras — top proveedores por monto del período, excluye anuladas */
    public function topProveedores($anho, $mes, $c_local, $top = 5)
    {
        $top = (int)$top;
        $filtro_mes = !empty($mes) ? " AND d.cod_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND d.c_local = '{$c_local}'" : "";
        $sql = "SELECT TOP {$top} RTRIM(p.nombre) AS nombre, SUM(d.total) AS monto
        FROM documentos_de_compras d
        INNER JOIN personas p ON p.c_persona = d.c_persona
        WHERE d.flag <> 'A'
          AND d.cod_ano = '{$anho}'{$filtro_mes}{$filtro_local}
        GROUP BY p.nombre
        ORDER BY SUM(d.total) DESC";
        return $this->dao->consulta($sql);
    }

    public function totalRendidoCajaChica($anho, $mes, $c_local)
    {
        $filtro_mes = !empty($mes) ? " AND cod_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad, SUM(total) AS monto
        FROM documentos_de_compras
        WHERE flag = '*'
          AND c_liquidacion_caja_chica IS NOT NULL
          AND RTRIM(c_liquidacion_caja_chica) <> ''
          AND cod_ano = '{$anho}'{$filtro_mes}{$filtro_local}";
        return $this->dao->consulta($sql);
    }
}
