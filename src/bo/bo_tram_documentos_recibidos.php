<?php
require_once dirname(__DIR__) . '/dao/dao_tram_documentos_recibidos.php';
class bo_tram_documentos_recibidos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_documentos_recibidos();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function control(?tram_documentos_recibidos $obj, $opc)
    {
        switch ($opc) {
            case "UPLOAD":
                return $this->dao->subir_file($obj);
                break;
            case "EA":
                return $this->dao->eliminar_file($obj);
                break;
        }
    }

    public function ProcesarDocumentosRecibidos(?tram_documentos_recibidos $obj)/*crear documento*/
    {
        return $this->dao->ProcesarDocumentosRecibidos($obj);
    }

    public function listarId(?tram_documentos_recibidos $obj)
    {
        $sql = "select d.cc_docrecibidos,
        d.c_expediente,
        d.c_tipo_de_documento, 
        d.num_documento, 
        dbo.fc_fecha_from(d.fecha_documento) as fecha_documento,
        dbo.fc_fecha_texto(d.fecha_documento) as fecha_documento_text,
        d.c_persona,
        rtrim(p.nombre) as razon_social,
        d.c_persona_pf,
        dbo.fc_v1_parametro_valor('documentos_recibidos','tipo_persona',tipo_persona) as tipo_persona_text,
        rtrim(pf.nombre) as nombre_remitente,
        rtrim(pf.c_cmp) as cmp_remitente,
        d.asunto, 
        d.asunto2, 
        d.c_local, 
        d.c_usuario, 
        d.tipo_persona, 
        d.destrinatario as destinatario, 
        d.c_local_origen,
        l.nombre as c_local_origen_text,
        d.c_cargo,
        d.flag,
        d.tokenumero,
        dbo.fc_v1_fecha_texto_hora(d.fecha_ingreso) as fecha_ingreso
        from documentos_recibidos d (nolock) left join personas p (nolock)
        on d.c_persona=p.c_persona
        left join personas pf (nolock)
        on d.c_persona_pf=pf.c_persona
        left join gen_local l
        on l.c_local=d.c_local_origen
        where d.cc_docrecibidos='{$obj->getCc_docrecibidos()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar(tram_documentos_recibidos $obj)
    {
        $sql = "select top 100 d.cc_docrecibidos,
    d.c_expediente,
    d.c_tipo_de_documento, 
    d.num_documento, 
    dbo.fc_fecha_from(d.fecha_documento) as fecha_documento,
    dbo.fc_fecha_texto(d.fecha_documento) as fecha_documento_text,
    d.c_persona,
    rtrim(p.nombre) as razon_social,
    d.c_persona_pf,
    dbo.fc_v1_parametro_valor('documentos_recibidos','tipo_persona',tipo_persona) as tipo_persona_text,
    rtrim(pf.nombre) as nombre_remitente,
    d.asunto, 
    d.asunto2, 
    d.c_local, 
    d.c_usuario, 
    d.tipo_persona, 
    d.destrinatario, 
    d.c_local_origen,
    l.nombre as c_local_origen_text,
    d.c_cargo,
    d.tokenumero,
    dbo.fc_v1_fecha_texto_hora(d.fecha_ingreso) as fecha_ingreso,
    d.flag,
    dbo.fc_v1_parametro_valor('documentos_recibidos','flag',flag) as flag_text
    from documentos_recibidos d (nolock) left join personas p (nolock)
    on d.c_persona=p.c_persona
    left join personas pf (nolock)
    on d.c_persona_pf=pf.c_persona
    left join gen_local l
    on l.c_local=d.c_local_origen
    where 1=1";

        if (strlen($obj->getGestion()) > 0) {
            $sql .= " and c_expediente='" . $obj->getGestion() . "'";
        }
        if (strlen($obj->getNombre_remitente()) > 0) {
            $sql .= " and pf.nombre like '%" . $obj->getNombre_remitente() . "%'";
        }
        if (strlen($obj->getC_local()) > 0) {
            $sql .= " and d.c_local='" . $obj->getC_local() . "'";
        }
        if ((strlen($obj->getFecha_desde()) > 0) and (strlen($obj->getFecha_hasta()) > 0)) {
            $fecha_desde_sql = u_fechaFormato(str_replace('/', '-', $obj->getFecha_desde()), 'Ymd H:i');
            $fecha_hasta_sql = u_fechaFormato(str_replace('/', '-', $obj->getFecha_hasta()), 'Ymd H:i');
            $sql .= " and d.fecha_ingreso BETWEEN '{$fecha_desde_sql}' and '{$fecha_hasta_sql}'";
        }
        if (strlen($obj->getC_local_origen()) > 0) {
            $sql .= " and d.c_local_origen='" . $obj->getC_local_origen() . "'";
        }
        if (strlen($obj->getNum_desde()) > 0 && strlen($obj->getNum_hasta()) > 0) {
            $sql .= " AND d.c_expediente BETWEEN '" . $obj->getNum_desde() . "' AND '" . $obj->getNum_hasta() . "'";
        } elseif (strlen($obj->getNum_desde()) > 0) {
            $sql .= " AND d.c_expediente >= '" . $obj->getNum_desde() . "'";
        }

        echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listarParaImprimirRango(tram_documentos_recibidos $obj)
    {
        $sql = "SELECT
    d.cc_docrecibidos,
    d.c_expediente,
    d.c_tipo_de_documento,
    RTRIM(COALESCE(pf.nombre, p.nombre, '')) AS nombre_referencia,
    d.asunto,
    dbo.fc_v1_fecha_texto(d.fecha_ingreso) AS fecha_ingreso_text,

    a.nombre AS c_area_adm_text,
    ac.nombre AS c_accion_text,
    dbo.fc_v1_fecha_texto(sd.fecha_entrega) AS fecha_entrega_text

    FROM documentos_recibidos d WITH (NOLOCK)

    LEFT JOIN personas p WITH (NOLOCK)
    ON d.c_persona = p.c_persona

    LEFT JOIN personas pf WITH (NOLOCK)
    ON d.c_persona_pf = pf.c_persona

    LEFT JOIN seguimiento_documentos_recibid sd WITH (NOLOCK)
    ON sd.cc_docrecibidos = d.cc_docrecibidos
    AND sd.cc_docrecibidos_det = (
        SELECT MAX(sd2.cc_docrecibidos_det)
        FROM seguimiento_documentos_recibid sd2 WITH (NOLOCK)
        WHERE sd2.cc_docrecibidos = d.cc_docrecibidos
    )

    LEFT JOIN gen_area_adm a WITH (NOLOCK)
    ON sd.c_area_adm = a.cc_area_adm

    LEFT JOIN tram_acciones ac WITH (NOLOCK)
    ON sd.c_accion = ac.c_accion
        where d.c_expediente >= '" . $obj->getC_expediente() . "'";

        if (strlen($obj->getC_local()) > 0) {
            $sql .= " AND d.c_local='" . $obj->getC_local() . "'";
        }
        $sql .= " order by d.c_expediente";

        //echo $sql;

        return $this->dao->consulta($sql);
    }

    public function listarDerivacion(tram_documentos_recibidos $obj, $c_area_adm)
    {
        $sql = "select top 25 d.cc_docrecibidos,
        d.c_expediente,
        d.c_tipo_de_documento, 
        d.num_documento, 
        dbo.fc_fecha_from(d.fecha_documento) as fecha_documento,
        dbo.fc_fecha_texto(d.fecha_documento) as fecha_documento_text,
        d.c_persona,
        rtrim(p.nombre) as razon_social,
        d.c_persona_pf,
        dbo.fc_v1_parametro_valor('documentos_recibidos','tipo_persona',tipo_persona) as tipo_persona_text,
        rtrim(pf.nombre) as nombre_remitente,
        d.asunto, 
        d.asunto2, 
        d.c_local, 
        d.c_usuario, 
        d.tipo_persona, 
        d.destrinatario as destinatario, 
        d.c_local_origen,
        l.nombre as c_local_origen_text,
        d.c_cargo,
        d.tokenumero,
        dbo.fc_v1_fecha_texto_hora(d.fecha_ingreso) as fecha_ingreso,
        d.flag,
        dbo.fc_v1_parametro_valor('documentos_recibidos','flag',flag) as flag_text
        from documentos_recibidos d (nolock) left join personas p (nolock)
        on d.c_persona=p.c_persona
        left join personas pf (nolock)
        on d.c_persona_pf=pf.c_persona
        left join gen_local l
        on l.c_local=d.c_local_origen
        where d.c_local='{$obj->getC_local()}' and d.c_expediente>='{$obj->getC_expediente()}'
        AND EXISTS (
        SELECT 1
        FROM seguimiento_documentos_recibid s WITH (NOLOCK)
        WHERE s.cc_docrecibidos = d.cc_docrecibidos
          AND s.c_area_adm= '{$c_area_adm}')";
        $sql .= " ORDER BY d.cc_docrecibidos asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listarTramitesColegiacion(tram_documentos_recibidos $obj)
    {
        $sql = "SELECT TOP (200)
                d.c_expediente,
                -- s.c_area_adm,
                d.tipo_persona,
                d.c_tipo_de_documento,
                dbo.fc_fecha_texto(d.fecha_ingreso)   AS fecha_ingreso,
                d.num_documento,
                dbo.fc_fecha_texto(d.fecha_documento) AS fecha_documento,
                d.asunto,
                p.nombre,
                p.c_cmp,
                d.c_usuario,
                (SELECT COUNT(*) FROM tram_documentos_recaudo tr WHERE tr.c_expediente = d.c_expediente) cantidad_pagos
                FROM documentos_recibidos d (NOLOCK)
                LEFT JOIN personas p (NOLOCK) 
                ON p.c_persona = d.c_persona
                WHERE d.c_local='{$obj->getC_local()}' AND p.nombre LIKE '%{$obj->getNombre_remitente()}%'";
        if (!empty($obj->getDesde()) && !empty($obj->getHasta())) {
            $sql .= " AND d.fecha_ingreso BETWEEN '{$obj->getDesde()}' and '{$obj->getHasta()}'";
        }
        if (!empty($obj->getC_local_origen()) && !empty($obj->getHasta())) {
            $sql .= " AND d.c_local_origen = '{$obj->getC_local_origen()}'";
        }
        $sql .= " ORDER BY d.c_expediente";

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /*
    public function listarxExpediente(tram_documentos_recibidos $obj)

    {
        $sql = "SELECT 
                d.cc_docrecibidos, 
                d.c_expediente,
                d.c_tipo_de_documento, 
                d.num_documento, 
                dbo.fc_fecha_from(d.fecha_documento) AS fecha_documento,
                dbo.fc_fecha_texto(d.fecha_documento) AS fecha_documento_text,
                d.c_persona,
                RTRIM(p.nombre) AS razon_social,
                d.c_persona_pf,
                dbo.fc_v1_parametro_valor('documentos_recibidos','tipo_persona',d.tipo_persona) AS tipo_persona_text,
                RTRIM(pf.nombre) AS nombre_remitente,
                d.asunto, 
                d.asunto2, 
                d.c_local, 
                d.c_usuario, 
                d.tipo_persona, 
                d.destrinatario as destinatario, 
                d.c_local_origen,
                d.c_cargo,
                d.flag,
                d.tokenumero,
                dbo.fc_v1_fecha_texto_hora(d.fecha_ingreso) AS fecha_ingreso
                FROM documentos_recibidos d WITH (NOLOCK)
                LEFT JOIN personas p  WITH (NOLOCK) ON d.c_persona = p.c_persona
                LEFT JOIN personas pf WITH (NOLOCK) ON d.c_persona_pf = pf.c_persona
                WHERE pf.nombre LIKE '%{$obj->getNombre_remitente()}%'
                AND EXISTS (
                SELECT 1 
                FROM seguimiento_documentos_recibid de WITH (NOLOCK)
                WHERE de.cc_docrecibidos = d.cc_docrecibidos";
        if (strlen($obj->getC_area_adm()) > 0) {
            $sql .= " AND de.c_area_adm='" . $obj->getC_area_adm() . "'";
        }
        $sql .= " )";

        if (strlen($obj->getC_local()) > 0) {
            $sql .= " AND d.c_local='" . $obj->getC_local() . "'";
        }
        if (strlen($obj->getDesde()) > 0 && strlen($obj->getHasta()) > 0) {
            $sql .= " AND d.fecha_ingreso BETWEEN '{$obj->getDesde()}' AND '{$obj->getHasta()}'";
        }

        if (strlen($obj->getC_expediente()) > 0) {
            $sql .= " AND d.c_expediente='" . $obj->getC_expediente() . "'";
        }
        echo $sql;
        return $this->dao->consulta($sql);
    }
*/




    /*
    |--------------------------------------------------------------------------
    | datos para los reportes dashboad
    |--------------------------------------------------------------------------
    */
    public function cantidadPorLocal($c_local, $anho)
    {
        $filtro_local = !empty($c_local) ? " AND d.c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad
        FROM documentos_recibidos d (nolock)
        WHERE YEAR(d.fecha_ingreso) = '{$anho}'{$filtro_local}";
        return $this->dao->consulta($sql);
    }

    public function porEstado($c_local, $anho)
    {
        $filtro_local = !empty($c_local) ? " AND d.c_local = '{$c_local}'" : "";
        $sql = "SELECT
            dbo.fc_v1_parametro_valor('documentos_recibidos','flag',d.flag) AS estado,
            COUNT(*) AS cantidad
        FROM documentos_recibidos d (nolock)
        WHERE YEAR(d.fecha_ingreso) = '{$anho}'{$filtro_local}
        GROUP BY d.flag
        ORDER BY cantidad DESC";
        return $this->dao->consulta($sql);
    }

    public function porMes($c_local, $anho)
    {
        $filtro_local = !empty($c_local) ? " AND d.c_local = '{$c_local}'" : "";
        $sql = "SELECT MONTH(d.fecha_ingreso) AS mes, COUNT(*) AS cantidad
        FROM documentos_recibidos d (nolock)
        WHERE YEAR(d.fecha_ingreso) = '{$anho}'{$filtro_local}
        GROUP BY MONTH(d.fecha_ingreso)
        ORDER BY mes";
        return $this->dao->consulta($sql);
    }

    public function validarExiste(tram_documentos_recibidos $obj)
    {
        $sql = "select * from documentos_recibidos where c_local='{$obj->getC_local()}' 
        and tokenumero='{$obj->getTokenumero()}'";
        return $this->dao->consulta($sql);
    }
}
