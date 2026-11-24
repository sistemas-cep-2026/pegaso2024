<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos.php';
class bo_cap_eventos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos();
    }
    public function creaeventos(cap_eventos $obj)
    {
        return $this->dao->creaeventos($obj);
    }
    public function control(cap_eventos $obj, $opc, $campo = 'img_asistente')
    {
        switch ($opc) {
            case "UPLOAD":
                return $this->dao->actualizarArchivo($obj, $campo);
                break;
            case "EA":
                return $this->dao->eliminarArchivo($obj, $campo);
                break;
            case "PU":
                return $this->dao->PublicarEvento($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }
    public function maxid()
    {
        $sql = "select MAX(cc_evento) cc_evento from cap_eventos";
        return $this->dao->consulta($sql);
    }
    public function listarAnhos()
    {
        $sql = "select DISTINCT YEAR(fecha_ini) AS anho
        FROM cap_eventos
        WHERE fecha_ini IS NOT NULL and YEAR(fecha_ini)>'2018'
        ORDER BY anho DESC";
        return $this->dao->consulta($sql);
    }

    public function listar(?cap_eventos $obj = null)
    {
        $sql = "select e.cc_evento, 
        e.nombre, 
        e.cc_local,
        dbo.fc_v1_parametro_valor('cap_eventos','tipo',e.tipo) as tipo,
        l.nombre as cc_local_text,
        dbo.fc_fecha_texto(e.fecha_ini) as fecha_inicio,
        dbo.fc_fecha_texto(e.fecha_fin) as fecha_fin,
        e.horascreditos_text,
        e.img_asistente,
        e.img_ponente,
        e.detalle,
        e.flag,
        dbo.fc_v1_parametro_valor('cap_eventos','flag',e.flag) as flag_text,
        (SELECT COUNT(*) 
        FROM cap_eventos_matricula m 
        WHERE m.cc_evento = e.cc_evento) AS cantidad
        from cap_eventos e (nolock) inner join gen_local l (nolock) 
        on e.cc_local=l.c_local
        where e.nombre like '%" . $obj->getNombre() . "%'";

        if (strlen($obj->getFecha_ini()) > 0) {
            $sql .= " and year(e.fecha_ini)='{$obj->getFecha_ini()}'";
        }
        if (strlen($obj->getCc_local()) > 0) {
            $sql .= " and e.cc_local='{$obj->getCc_local()}'";
        }
        if (strlen($obj->getTipo()) > 0) {
            $sql .= " and e.tipo='{$obj->getTipo()}'";
        }
        $sql .= " order by e.cc_evento desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?cap_eventos $obj = null)
    {
        $sql = "select  cc_evento,
        codigo,
        nombre, 
        rtrim(cc_local) as cc_local, 
        flag, 
        dbo.fc_fecha_from(fecha_ini) as fecha_inicio,
        dbo.fc_fecha_from(fecha_fin) as fecha_fin,
        dbo.fc_v1_fecha_texto(fecha_ini) as fecha_inicio_text,
        dbo.fc_v1_fecha_texto(fecha_fin) as fecha_fin_text,
        tipo, 
        dbo.fc_v1_parametro_valor('cap_eventos','tipo',tipo) as tipo_text,
        horascreditos_text, 
        img_asistente, 
        img_ponente,
        fecha_evento_text, 
        detalle,
        detalle_ponente, 
        print_documento, 
        text_documento,
        sala,
        organizador,
        convert(varchar(5), hora_inicio, 108) as hora_inicio,
        (SELECT COUNT(*) FROM cap_eventos_matricula m WHERE m.cc_evento = cap_eventos.cc_evento) AS cantidad
        FROM cap_eventos
        WHERE cc_evento='{$obj->getCc_evento()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarEventos($cc_local, $anho)
    {
        $sql = "select cc_evento,
        RTRIM(nombre) AS nombre_evento,
        CAST(cc_evento AS VARCHAR) + '-' + RTRIM(nombre) as nombre_evento_text
        FROM cap_eventos
        WHERE cc_local='" . $cc_local . "'
        AND YEAR(fecha)='" . $anho . "'
        order by cc_evento desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    /********************************Dashboard*********************************** */
    public  function canti_eventos_anho(?cap_eventos $obj = null)
    {
        $sql = "SELECT cc_local, COUNT(*) AS total_eventos
            FROM dbo.cap_eventos
            WHERE year(fecha)='{$obj->getFecha()}'
            GROUP BY cc_local
            ORDER BY cc_local";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public  function canti_eventos_local(?cap_eventos $obj = null)
    {
        $sql = "SELECT cc_local, COUNT(*) AS cant_eventos
            FROM dbo.cap_eventos
            WHERE year(fecha)='{$obj->getFecha()}' and cc_local='{$obj->getCc_local()}'
            GROUP BY cc_local
            ORDER BY cc_local";
        return $this->dao->consulta($sql);
    }

    public function asistentes_anho(?cap_eventos $obj = null)
    {
        $sql = "SELECT e.cc_local,
    SUM(CASE WHEN m.asistente   = 1 THEN 1 ELSE 0 END) AS n_asistentes,
    SUM(CASE WHEN m.ponente     = 1 THEN 1 ELSE 0 END) AS n_ponentes,
    SUM(CASE WHEN m.organizador = 1 THEN 1 ELSE 0 END) AS n_organizadores
    FROM dbo.cap_eventos e
    INNER JOIN dbo.cap_eventos_matricula m
            ON m.cc_evento = e.cc_evento
    WHERE year(e.fecha)='{$obj->getFecha()}'
    GROUP BY e.cc_local
    ORDER BY e.cc_local";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function asistentes_local(?cap_eventos $obj = null)
    {
        $sql = "SELECT e.cc_local,
        SUM(CASE WHEN m.asistente   = 1 THEN 1 ELSE 0 END) AS n_asistentes,
        SUM(CASE WHEN m.ponente     = 1 THEN 1 ELSE 0 END) AS n_ponentes,
        SUM(CASE WHEN m.organizador = 1 THEN 1 ELSE 0 END) AS n_organizadores
        FROM dbo.cap_eventos e
        INNER JOIN dbo.cap_eventos_matricula m
                ON m.cc_evento = e.cc_evento
        WHERE year(e.fecha)='{$obj->getFecha()}' and e.cc_local='{$obj->getCc_local()}'
        GROUP BY e.cc_local
        ORDER BY e.cc_local";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function asistentes_total_local(?cap_eventos $obj = null)
    {
        /***Pendiente */
        $sql = "SELECT p.c_local,
        COUNT(*) n_asistentes
        FROM dbo.cap_eventos e
        INNER JOIN dbo.cap_eventos_matricula m
                ON m.cc_evento = e.cc_evento
        INNER JOIN dbo.Personas p
                ON p.c_persona = m.c_persona
        WHERE ISNUMERIC(p.c_cmp)=1 and year(e.fecha)='{$obj->getFecha()}' and e.cc_local='{$obj->getCc_local()}'
        AND m.asistente = 1
        GROUP BY p.c_local
        ORDER BY p.c_local";
        return $this->dao->consulta($sql);
    }

    public function coleg_otros(?cap_eventos $obj = null)
    {
        /***Pendiente */
        $sql = "SELECT e.cc_local,
        SUM(CASE WHEN m.asistente = 1 AND p.c_cmp IS NOT NULL THEN 1 ELSE 0 END) AS colegiados,
        SUM(CASE WHEN m.asistente = 1 AND p.c_cmp IS NULL     THEN 1 ELSE 0 END) AS no_colegiados
        FROM dbo.cap_eventos AS e
        INNER JOIN dbo.cap_eventos_matricula AS m
                ON m.cc_evento = e.cc_evento
        INNER JOIN dbo.Personas AS p
                ON p.c_persona = m.c_persona 
        WHERE year(e.fecha)='{$obj->getFecha()}' and e.cc_local='{$obj->getCc_local()}'
        GROUP BY e.cc_local
        ORDER BY e.cc_local";
        return $this->dao->consulta($sql);
    }

    public function topColegiadosCursos(?cap_eventos $obj = null)
    {
        $sql = "SELECT TOP 10
            p.c_persona,
            p.c_cmp,
            RTRIM(p.nombre) AS nombre,
            COUNT(DISTINCT m.cc_evento) AS total_cursos
        FROM dbo.cap_eventos_matricula m
        INNER JOIN dbo.cap_eventos e
                ON e.cc_evento = m.cc_evento
        INNER JOIN dbo.Personas p
                ON p.c_persona = m.c_persona
        WHERE m.asistente = 1
          AND p.c_cmp IS NOT NULL
          AND YEAR(e.fecha) = '{$obj->getFecha()}'
          AND e.cc_local = '{$obj->getCc_local()}'
        GROUP BY p.c_persona, p.c_cmp, p.nombre
        ORDER BY total_cursos DESC";
        return $this->dao->consulta($sql);
    }

    public function grupoEtario(?cap_eventos $obj = null)
    {
        $sql = "SELECT
            CASE
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) < 25 THEN '< 25'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 25 AND 34 THEN '25-34'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 35 AND 44 THEN '35-44'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 45 AND 54 THEN '45-54'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 55 AND 64 THEN '55-64'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) >= 65 THEN '65+'
                ELSE 'S/D'
            END AS grupo_etario,
            COUNT(DISTINCT m.c_persona) AS total
        FROM dbo.cap_eventos_matricula m
        INNER JOIN dbo.cap_eventos e
                ON e.cc_evento = m.cc_evento
        INNER JOIN dbo.Personas p
                ON p.c_persona = m.c_persona
        WHERE m.asistente = 1
          AND YEAR(e.fecha) = '{$obj->getFecha()}'
          AND e.cc_local = '{$obj->getCc_local()}'
        GROUP BY
            CASE
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) < 25 THEN '< 25'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 25 AND 34 THEN '25-34'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 35 AND 44 THEN '35-44'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 45 AND 54 THEN '45-54'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) BETWEEN 55 AND 64 THEN '55-64'
                WHEN DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) >= 65 THEN '65+'
                ELSE 'S/D'
            END";
        return $this->dao->consulta($sql);
    }

    /**
     * Listado de cursos para eve_listar.php: paginado en SQL Server (ROW_NUMBER, compatible con 2008),
     * filtros parametrizados y contadores de roles en la misma consulta.
     * Devuelve las filas de la página; cada fila trae 'total' (cantidad total de cursos del filtro).
     */
    public function listarPaginado($nombre, $anho, $cc_local, $tipo, $pagina, $por_pagina)
    {
        $where  = " WHERE 1 = 1";
        $params = array();

        $nombre = trim((string) $nombre);
        if ($nombre !== '') {
            $where .= " AND e.nombre LIKE ?";
            $params[] = '%' . str_replace(array('[', '%', '_'), array('[[]', '[%]', '[_]'), $nombre) . '%';
        }
        if (preg_match('/^[0-9]{4}$/', (string) $anho) === 1) {
            $where .= " AND e.fecha_ini >= ? AND e.fecha_ini < ?";
            $params[] = $anho . '0101';
            $params[] = ((int) $anho + 1) . '0101';
        }
        if (preg_match('/^[0-9]{2}$/', (string) $cc_local) === 1) {
            $where .= " AND e.cc_local = ?";
            $params[] = $cc_local;
        }
        if (preg_match('/^[A-Za-z0-9]{1,2}$/', trim((string) $tipo)) === 1) {
            $where .= " AND RTRIM(e.tipo) = ?";
            $params[] = trim((string) $tipo);
        }

        $pagina     = max(1, (int) $pagina);
        $por_pagina = max(1, (int) $por_pagina);
        $params[] = ($pagina - 1) * $por_pagina + 1;
        $params[] = $pagina * $por_pagina;

        $sql = "SELECT t.cc_evento,
            RTRIM(e.codigo) AS codigo,
            e.nombre,
            e.cc_local,
            RTRIM(l.nombre) AS cc_local_text,
            dbo.fc_v1_parametro_valor('cap_eventos','tipo',e.tipo) AS tipo,
            dbo.fc_fecha_texto(e.fecha_ini) AS fecha_inicio,
            dbo.fc_fecha_texto(e.fecha_fin) AS fecha_fin,
            e.fecha_evento_text,
            e.horascreditos_text,
            e.img_asistente,
            e.img_ponente,
            CAST(e.detalle AS VARCHAR(1000)) AS detalle,
            RTRIM(e.flag) AS flag,
            RTRIM(ISNULL(e.portal, 'N')) AS portal,
            ISNULL(r.asistentes, 0) AS asistentes,
            ISNULL(r.ponentes, 0) AS ponentes,
            ISNULL(r.organizadores, 0) AS organizadores,
            t.total
        FROM (
            SELECT e.cc_evento,
                ROW_NUMBER() OVER (ORDER BY e.cc_evento DESC) AS fila,
                COUNT(*) OVER () AS total
            FROM cap_eventos e (NOLOCK)
            " . $where . "
        ) t
        INNER JOIN cap_eventos e (NOLOCK) ON e.cc_evento = t.cc_evento
        LEFT JOIN gen_local l (NOLOCK) ON l.c_local = e.cc_local
        LEFT JOIN (
            SELECT cc_evento,
                SUM(CASE WHEN asistente = 1 THEN 1 ELSE 0 END) AS asistentes,
                SUM(CASE WHEN ponente = 1 THEN 1 ELSE 0 END) AS ponentes,
                SUM(CASE WHEN organizador = 1 THEN 1 ELSE 0 END) AS organizadores
            FROM cap_eventos_matricula (NOLOCK)
            GROUP BY cc_evento
        ) r ON r.cc_evento = t.cc_evento
        WHERE t.fila BETWEEN ? AND ?
        ORDER BY t.fila";
        return $this->dao->consultaParams($sql, $params);
    }

    /** Ejecuta sp_v1_publicar_eventos_portal. $opc: SC, EC, PU o DP. */
    public function publicarPortal($cc_evento, $opc)
    {
        return $this->dao->publicarPortal($cc_evento, $opc);
    }
}
