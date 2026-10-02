<?php
require_once dirname(__DIR__) . '/dao/dao_comp_liquidaciones_caja_chica.php';
class bo_comp_liquidaciones_caja_chica
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_comp_liquidaciones_caja_chica();
    }

    public function procesar(comp_liquidaciones_caja_chica $obj)/*crear documento*/
    {
        return $this->dao->procesar($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(?comp_liquidaciones_caja_chica $obj = null)
    {
        $sql = "select TOP 50 
        l.c_liquidacion_caja_chica,   
        dbo.fc_fecha_texto(l.fecha) as fecha_text,   
        l.nro_cheque,   
        rtrim(b.c_banco)+'-'+rtrim(l.c_cta_corriente) as banco_cta,   
        l.monto,   
        dbo.fc_fecha_texto(l.fecha_operacion) as fecha_operacion,   
        l.c_local ,
        l.monto_apertura,
        l.c_persona,
        p.nombre  ,
        l.flag,
        dbo.fc_v1_parametro_valor('liquidaciones_caja_chica','flag',l.flag) as flag_text,
        l.flag_bancos,
        dbo.fc_v1_parametro_valor('liquidaciones_caja_chica','flag_bancos',l.flag_bancos) as flag_text_bancos,
        b.nombre as banco_nombre,l.c_cta_corriente
        FROM liquidaciones_caja_chica l  (nolock)
        Left Join Personas p (nolock)
        on l.c_persona = p.c_persona
        left join gen_bancos b
        on b.c_banco=l.c_banco
        where l.c_local='{$obj->getC_local()}' ";
        if (strlen($obj->getFlag()) > 0) {
            $sql .= " and l.flag LIKE '{$obj->getFlag()}'";
        }
        $sql .= " order by l.fecha desc";
        echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?comp_liquidaciones_caja_chica $obj = null)
    {
        $sql = "select  
        c.nro_cheque,
        c.c_banco,
        c.c_cta_corriente,
        rtrim(c.c_banco)+'-'+rtrim(c.c_cta_corriente) as banco_cta,
        dbo.fc_fecha_from(c.fecha_operacion) as fecha_operacion,
        dbo.fc_fecha_texto(c.fecha_operacion) as fecha_operacion_print,
        c.flag,
        c.c_local,
        c.c_persona, 
        c.monto, 
        c.monto_apertura ,p.num_documento,
        p.nombre,
        c.c_liquidacion_caja_chica  ,
        rtrim(b.nombre )+'-'+rtrim(c.c_cta_corriente) as nombre_banco
        FROM liquidaciones_caja_chica c
        left join personas p on p.c_persona=c.c_persona
        left join bancos b on c.c_banco=b.c_banco
        where c.c_liquidacion_caja_chica='{$obj->getCc_caja_chica()}' ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar_doc(?comp_liquidaciones_caja_chica $obj = null)
    {
        $sql = "select c.cc_compra,
        c.cod_documento, 
        c.num_documento, 
        c.c_local,
        c.c_persona,
            isnull(p.ruc,isnull(p.num_documento,''))+' - '+rtrim(p.nombre) as razon_social,
        dbo.fc_fecha_from(fecha_documento) as fecha_documento,
        dbo.fc_fecha_texto(fecha_documento) as fecha_documento_print,
        dbo.fc_fecha_from(c.fecha_vencimiento) as fecha_vencimiento, 
        dbo.fc_fecha_texto(c.fecha_vencimiento) as fecha_vencimiento_print, 
        c.cod_ano, 
        c.cod_mes, 
        rtrim(CAST(c.observacion  as char(120))) as observacion, 
        c.total,
        c.flag,
        c.c_liquidacion_caja_chica,c.comprobante
        ,(SELECT TOP 1 id.c_cuenta FROM items_documentos_de_compra_cue id 
        where id.cc_compra=c.cc_compra and substring(id.c_cuenta,1,1) not in  ('4','7','9')) as c_cuenta
        from documentos_de_compras c (nolock) left join personas p (nolock)
        on p.c_persona=c.c_persona
        where c.flag='*' and c.c_liquidacion_caja_chica='{$obj->getC_liquidacion_caja_chica()}'
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listar_rendido(?comp_liquidaciones_caja_chica $obj = null)
    {
        $sql = "select sum(total) rendido
        from documentos_de_compras 
        where c_liquidacion_caja_chica='{$obj->getC_liquidacion_caja_chica()}' and flag='*'
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /*************Documentos caja chica*/ ////////////////////
    public function CajaChicaPendiente(?comp_liquidaciones_caja_chica $obj = null)
    {
        $sql = "select c.c_liquidacion_caja_chica,  rtrim(p.nombre)+ ' => ' +
        c.c_liquidacion_caja_chica + ' => ' +
        dbo.fc_fecha_texto(c.fecha_operacion) + ' => ' +
        CAST(c.monto AS VARCHAR) + ' => ' +
        CAST(c.monto_apertura AS VARCHAR) AS caja_chica
        FROM liquidaciones_caja_chica c inner join personas p 
        on c.c_persona=p.c_persona
        WHERE c.c_local = '{$obj->getC_local()}' 
        AND  c.flag in ('&','I') order by c.fecha desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /**
     * Dashboard compras — fondo total actualmente pendiente de rendir (cajas chicas abiertas).
     * Usa el mismo criterio de "pendiente" ya establecido en CajaChicaPendiente(): flag in ('&','I').
     * No se filtra por año/mes: es un saldo del estado actual, no un histórico del período.
     */
    public function totalPendientes($c_local)
    {
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad,
        SUM(ISNULL(monto,0) + ISNULL(monto_apertura,0)) AS monto
        FROM liquidaciones_caja_chica
        WHERE flag IN ('&','I'){$filtro_local}";
        return $this->dao->consulta($sql);
    }

    /**
     * Dashboard compras — cajas chicas aperturadas por mes, según fecha de apertura.
     * La tabla liquidaciones_caja_chica no tiene cod_ano/cod_mes, por eso se filtra
     * con YEAR()/MONTH() sobre la columna fecha (igual que en bo_banc_beneficiofam).
     */
    public function montoPorMesApertura($anho, $c_local)
    {
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT MONTH(fecha) AS mes, COUNT(*) AS cantidad,
        SUM(ISNULL(monto_apertura,0)) AS monto
        FROM liquidaciones_caja_chica
        WHERE YEAR(fecha) = {$anho}{$filtro_local}
        GROUP BY MONTH(fecha)
        ORDER BY MONTH(fecha)";
        return $this->dao->consulta($sql);
    }
}
