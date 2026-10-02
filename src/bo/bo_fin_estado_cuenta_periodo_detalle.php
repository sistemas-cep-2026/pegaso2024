<?php
require_once dirname(__DIR__) . '/dao/dao_fin_estado_cuenta_periodo_detalle.php';
class bo_fin_estado_cuenta_periodo_detalle
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_estado_cuenta_periodo_detalle();
    }

    public function control(fin_estado_cuenta_periodo_detalle $obj, $opc)
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

    public function listarPlanilla(?fin_estado_cuenta_periodo_detalle $obj = null)
    {
        $sql = "select 
        ecd.cc_identidad,
        dbo.fc_v1_fecha_texto(ecd.fecha) AS fecha,
        p.c_cmp,
        p.nombre AS nombre_colegiado,
        ecd.cod_documento,
        ecd.boleta,
        ecd.importe,
        ecd.observacion,
        dbo.fc_v1_vinculo_laboral(ecd.ddirecto) AS ddirecto,
        ecd.flag_grabado
        FROM dbo.estado_cuenta_periodo_detalle AS ecd 
        INNER JOIN dbo.personas AS p 
        ON p.c_persona = ecd.c_persona
        WHERE ecd.c_entidad_pagadora = '{$obj->getC_entidad_pagadora()}'
        AND ecd.c_periodo = '{$obj->getC_periodo()}'
        ORDER BY ecd.ddirecto, p.nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPlanillaTotales(?fin_estado_cuenta_periodo_detalle $obj = null)
    {
        $sql = "select dbo.fc_v1_vinculo_laboral(ecd.ddirecto) as ddirecto,
            ecd.cod_documento,ecd.boleta,SUM(ecd.importe) AS total,
            COUNT(*) AS cantidad from estado_cuenta_periodo_detalle ecd 
            inner join personas p 
            on p.c_persona=ecd.c_persona
            where ecd.c_entidad_pagadora='{$obj->getC_entidad_pagadora()}'
            and ecd.c_periodo='{$obj->getC_periodo()}'
            AND ecd.flag_grabado='*'
            GROUP BY  dbo.fc_v1_vinculo_laboral(ecd.ddirecto) ,
            ecd.cod_documento,ecd.boleta
            order by dbo.fc_v1_vinculo_laboral(ecd.ddirecto) ,
            ecd.cod_documento,
            ecd.boleta ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function PlanillaEssalud(?fin_estado_cuenta_periodo_detalle $obj = null)
    {
        $sql = "select COUNT(*) AS cantidad,
        SUM(ed.importe) AS importe,
        (SUM(ed.importe) * lo.porc_cotizacion / 100.0) AS importe_porcentaje,
        RTRIM(lo.nombre) + ' ' + RTRIM(cep.nombre) AS nombre_entidad,
        lo.cc_local,
        lo.porc_cotizacion,
        per.pla_essalud AS estado
        FROM estado_cuenta_periodo_detalle ed WITH (NOLOCK)
        JOIN entidad_pagadora cep WITH (NOLOCK)
        ON cep.c_entidad_pagadora = ed.c_entidad_pagadora
        JOIN gen_local lo WITH (NOLOCK)
        ON lo.cc_local = SUBSTRING(cep.c_entidad_pagadora, 3, 2)
        LEFT JOIN periodos per WITH (NOLOCK)
        ON per.c_ano = RIGHT({$obj->getPeriodo()}, 4)
        AND per.c_mes = LEFT({$obj->getPeriodo()}, 2)
        WHERE ed.c_periodo = '{$obj->getPeriodo()}'
        AND ed.c_entidad_pagadora LIKE '81%'
        AND ed.importe > 0";
        if (strlen($obj->getCc_local()) > 0) {
            $sql .= " and cep.cc_local='{$obj->getCc_local()}'";
        }
        $sql .= " GROUP BY lo.nombre, cep.nombre, lo.cc_local, lo.porc_cotizacion, per.pla_essalud
        ORDER BY lo.cc_local";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function PlanillaEssalud_detalle_cabecera(?fin_estado_cuenta_periodo_detalle $obj = null)
    {
        $sql = "select DISTINCT
        epa.cod_presupuestal,
        x.epa
        FROM estado_cuenta_periodo_detalle AS ed WITH (NOLOCK)
        LEFT JOIN entidad_planilla AS epa WITH (NOLOCK)
        ON epa.cod_presupuestal = ed.ccceips_codigo
        CROSS APPLY (SELECT
        COALESCE(RTRIM(epa.prog), '')      + ' * ' +
        COALESCE(RTRIM(epa.sub_pro), '')   + ' * ' +
        COALESCE(RTRIM(epa.actividad), '') + ' * ' +
        COALESCE(RTRIM(epa.sa1), '')       + ' * ' +
        COALESCE(RTRIM(epa.sa2), '')       + ' * ' +
        COALESCE(RTRIM(epa.sa3), '') ) AS x(epa)
        WHERE ed.c_periodo = '{$obj->getPeriodo()}'
        AND ed.importe > 0
        AND ed.c_entidad_pagadora LIKE '81' + '{$obj->getCc_local()}' + '%'";
        return $this->dao->consulta($sql);
    }


    public function PlanillaEssalud_detalle_colegiado(?fin_estado_cuenta_periodo_detalle $obj = null)
    {
        $sql = "select epa.cod_presupuestal,
            per.c_cmp,
            LTRIM(RTRIM(COALESCE(per.apellido_paterno, ''))) + ' ' +
            LTRIM(RTRIM(COALESCE(per.apellido_materno, ''))) + ' ' +
            LTRIM(RTRIM(COALESCE(per.nombre1,         ''))) + ' ' +
            LTRIM(RTRIM(COALESCE(per.nombre2,         ''))) AS nombre,
            CASE WHEN ed.flag_grabado = '*' THEN ed.importe ELSE 0 END AS ed_importe1,
            ed.boleta,
            SUBSTRING(ed.observacion, 14, 90) AS observacion
            FROM estado_cuenta_periodo_detalle AS ed WITH (NOLOCK)
            JOIN personas AS per WITH (NOLOCK) ON per.c_persona = ed.c_persona
            LEFT JOIN entidad_planilla AS epa WITH (NOLOCK) ON epa.cod_presupuestal = ed.ccceips_codigo
            WHERE ed.c_periodo = '{$obj->getPeriodo()}'
            AND ed.importe  > 0
            AND ed.c_entidad_pagadora LIKE '81' + '{$obj->getCc_local()}' + '%'
            AND epa.cod_presupuestal = '{$obj->getCod_presupuestal()}'
            ORDER BY per.c_cmp";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
