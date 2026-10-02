<?php
require_once dirname(__DIR__) . '/dao/dao_cont_asistencia.php';
class bo_cont_asistencia
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cont_asistencia();
    }

    public function control(cont_asistencia $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "A":
                return $this->dao->anular($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listarAnhos()
    {
        $sql = "select DISTINCT YEAR(punch_time) AS anho
        FROM dbo.cont_asistencia
        ORDER BY anho";
        return $this->dao->consulta($sql);
    }

    public function listarPeriodos_conciliacion($cc_local)
    {
        $sql = "select c_ano,c_mes,c_ano+c_mes as periodo from periodos_local where flag_conciliacion<>'*'  and c_local='" . $cc_local . "'";
        return $this->dao->consulta($sql);
    }

    public function listarPersona($cc_persona, $anho, $periodo)
    {
        $sql = "select id,
        DATENAME(WEEKDAY, punch_time) AS dia_semana,
        dbo.fc_fecha_hora(punch_time) AS fecha,
        flag,
        status as horario,
        dbo.fc_v1_parametro_valor('cont_asistencia','flag',flag) as flag_text
        FROM  cont_asistencia wHERE 
        YEAR(punch_time) = '" . $anho . "'
        AND MONTH(punch_time) = '" . $periodo . "'
        AND cc_persona = '" . $cc_persona . "'
        order by punch_time";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ReporlistarPersona($cc_persona, $anho, $periodo)
    {
        $sql = "select
        a1.cc_persona,
        dbo.fc_fecha_texto(a1.punch_time) as fecha,
        MIN(dbo.fc_v1_fecha_solo_hora(a1.punch_time)) AS hora_inicio,
        MAX(dbo.fc_v1_fecha_solo_hora(a2.punch_time)) AS hora_salida,
        a1.flag,
        dbo.fc_v1_parametro_valor('cont_asistencia','flag',a1.flag) as flag_text,
        a1.status as horario,
        DATENAME(WEEKDAY, a1.punch_time) AS dia_semana
        FROM
        cont_asistencia a1
        JOIN
        cont_asistencia a2
        ON a1.cc_persona = a2.cc_persona
        AND CONVERT(DATE, a1.punch_time) = CONVERT(DATE, a2.punch_time)
        where  YEAR(a1.punch_time) = '" . $anho . "' and MONTH(a1.punch_time) = '" . $periodo . "' and a1.flag='A' AND a1.cc_persona = '" . $cc_persona . "'  GROUP BY
        a1.cc_persona,
        dbo.fc_fecha_texto(a1.punch_time),
        a1.flag,
        dbo.fc_v1_parametro_valor('cont_asistencia','flag',a1.flag),
        a1.status,
        DATENAME(WEEKDAY, a1.punch_time)";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function ReporlistarPersona_todos($anho, $periodo)
    {
        $sql = "select
        a1.cc_persona,
        dbo.fc_fecha_texto(a1.punch_time) as fecha,
        MIN(dbo.fc_v1_fecha_solo_hora(a1.punch_time)) AS hora_inicio,
        MAX(dbo.fc_v1_fecha_solo_hora(a2.punch_time)) AS hora_salida,
        a1.flag,
        dbo.fc_v1_parametro_valor('cont_asistencia','flag',a1.flag) as flag_text,
        a1.status as horario,
        DATENAME(WEEKDAY, a1.punch_time) AS dia_semana,p.num_documento,p.nombre
        FROM
        cont_asistencia a1
        JOIN
        cont_asistencia a2
        ON a1.cc_persona = a2.cc_persona
        AND CONVERT(DATE, a1.punch_time) = CONVERT(DATE, a2.punch_time)
        inner join personas p on p.c_persona=a1.cc_persona
        where  YEAR(a1.punch_time) = '" . $anho . "' and MONTH(a1.punch_time) = '" . $periodo . "' and a1.flag='A'
        GROUP BY a1.cc_persona,
        dbo.fc_fecha_texto(a1.punch_time),
        a1.flag,
        dbo.fc_v1_parametro_valor('cont_asistencia','flag',a1.flag),
        a1.status,
        DATENAME(WEEKDAY, a1.punch_time),p.num_documento,p.nombre";
        echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listarId($id)
    {
        $sql = "select id, 
        cc_persona, 
        status as horario,
        dbo.fc_fecha_from(punch_time) as punch_time,
        dbo.fc_v1_fecha_solo_hora(punch_time) as hora,
        flag
        from cont_asistencia
        where id='" . $id . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
