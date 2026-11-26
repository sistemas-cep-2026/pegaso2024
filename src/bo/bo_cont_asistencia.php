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
            case "U":
                return $this->dao->modificar($obj);
        }
        return false;
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    /** Rango [desde, hasta) del mes en formato yyyymmdd (filtra sin funciones sobre la columna). */
    private function rangoMes($anho, $periodo)
    {
        $anho = (int) $anho;
        $mes = (int) $periodo;
        $desde = sprintf('%04d%02d01', $anho, $mes);
        $hasta = ($mes === 12) ? sprintf('%04d0101', $anho + 1) : sprintf('%04d%02d01', $anho, $mes + 1);
        return array($desde, $hasta);
    }

    public function listarAnhos()
    {
        $sql = "select DISTINCT YEAR(punch_time) AS anho
        FROM dbo.cont_asistencia
        ORDER BY anho DESC";
        return $this->dao->consulta($sql);
    }

    public function listarPeriodos_conciliacion($cc_local)
    {
        $sql = "select c_ano,c_mes,c_ano+c_mes as periodo from periodos_local where flag_conciliacion<>'*'  and c_local='" . $cc_local . "'";
        return $this->dao->consulta($sql);
    }

    /** Marcaciones de una persona en el mes (vista Recuadre). */
    public function listarPersona($cc_persona, $anho, $periodo)
    {
        list($desde, $hasta) = $this->rangoMes($anho, $periodo);
        $sql = "select id,
        cc_persona,
        DATENAME(WEEKDAY, punch_time) AS dia_semana,
        dbo.fc_fecha_hora(punch_time) AS fecha,
        flag,
        status as horario,
        dbo.fc_v1_parametro_valor('cont_asistencia','flag',flag) as flag_text
        FROM cont_asistencia
        WHERE punch_time >= ? AND punch_time < ? AND cc_persona = ?
        ORDER BY punch_time";
        return $this->dao->consultaParams($sql, array($desde, $hasta, $cc_persona));
    }

    /**
     * Resumen diario de una persona: primera y última marcación activa (flag 'A') de cada día.
     * Antes se hacía un auto-join que tomaba la salida también de marcaciones anuladas.
     */
    public function ReporlistarPersona($cc_persona, $anho, $periodo)
    {
        list($desde, $hasta) = $this->rangoMes($anho, $periodo);
        $sql = "select
        a.cc_persona,
        dbo.fc_fecha_texto(MIN(a.punch_time)) as fecha,
        dbo.fc_v1_fecha_solo_hora(MIN(a.punch_time)) AS hora_inicio,
        dbo.fc_v1_fecha_solo_hora(MAX(a.punch_time)) AS hora_salida,
        COUNT(*) AS marcaciones,
        MAX(a.status) as horario,
        DATENAME(WEEKDAY, MIN(a.punch_time)) AS dia_semana
        FROM cont_asistencia a
        WHERE a.punch_time >= ? AND a.punch_time < ? AND a.flag = 'A' AND a.cc_persona = ?
        GROUP BY a.cc_persona, CONVERT(DATE, a.punch_time)
        ORDER BY CONVERT(DATE, a.punch_time)";
        return $this->dao->consultaParams($sql, array($desde, $hasta, $cc_persona));
    }

    /** Resumen diario de todo el personal. */
    public function ReporlistarPersona_todos($anho, $periodo)
    {
        list($desde, $hasta) = $this->rangoMes($anho, $periodo);
        $sql = "select
        a.cc_persona,
        dbo.fc_fecha_texto(MIN(a.punch_time)) as fecha,
        dbo.fc_v1_fecha_solo_hora(MIN(a.punch_time)) AS hora_inicio,
        dbo.fc_v1_fecha_solo_hora(MAX(a.punch_time)) AS hora_salida,
        COUNT(*) AS marcaciones,
        MAX(a.status) as horario,
        DATENAME(WEEKDAY, MIN(a.punch_time)) AS dia_semana,
        p.num_documento, p.nombre
        FROM cont_asistencia a
        INNER JOIN personas p ON p.c_persona = a.cc_persona
        WHERE a.punch_time >= ? AND a.punch_time < ? AND a.flag = 'A'
        GROUP BY a.cc_persona, p.num_documento, p.nombre, CONVERT(DATE, a.punch_time)
        ORDER BY p.nombre, CONVERT(DATE, a.punch_time)";
        return $this->dao->consultaParams($sql, array($desde, $hasta));
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
        where id = ?";
        return $this->dao->consultaParams($sql, array((int) $id));
    }
}
