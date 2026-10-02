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
    public function control(cap_eventos $obj, $opc)
    {
        switch ($opc) {
            case "UPLOAD":
                return $this->dao->actualizarArchivo($obj);
                break;
            case "EA":
                return $this->dao->eliminarArchivo($obj);
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
        e.img_certificado,
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
        tipo, 
        horascreditos_text, 
        img_certificado, 
        fecha_evento_text, 
        detalle, 
        print_documento, 
        text_documento
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
}
