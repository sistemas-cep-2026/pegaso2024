<?php
require_once dirname(__DIR__) . '/dao/dao_nps_respuestas.php';
class bo_nps_respuestas
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_nps_respuestas();
    }

    public function errores()
    {
        return $this->dao->errores();
    }
    public function numeroClasificacion()
    {
        $sql = "SELECT
    SUM(CASE WHEN respuesta BETWEEN 9 AND 10 THEN 1 ELSE 0 END) AS promotores,
    SUM(CASE WHEN respuesta BETWEEN 7 AND 8 THEN 1 ELSE 0 END) AS pasivos,
    SUM(CASE WHEN respuesta BETWEEN 0 AND 6 THEN 1 ELSE 0 END) AS detractores,

    CAST(SUM(CASE WHEN respuesta BETWEEN 9 AND 10 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) AS DECIMAL(5,2)) AS promotores_pct,
    CAST(SUM(CASE WHEN respuesta BETWEEN 7 AND 8 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) AS DECIMAL(5,2)) AS pasivos_pct,
    CAST(SUM(CASE WHEN respuesta BETWEEN 0 AND 6 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) AS DECIMAL(5,2)) AS detractores_pct,
    CAST(
        (SUM(CASE WHEN respuesta BETWEEN 9 AND 10 THEN 1 ELSE 0 END) * 100.0 / COUNT(*))
        -
        (SUM(CASE WHEN respuesta BETWEEN 0 AND 6 THEN 1 ELSE 0 END) * 100.0 / COUNT(*))
        AS DECIMAL(5,2)
    ) AS nps
    FROM cloud_huawei.beta_app2023.dbo.nps_respuestas";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function Canti_particopantes(?nps_respuestas $obj = null)
    {
        $sql = "SELECT COUNT(DISTINCT c_persona) AS total_personas
            FROM cloud_huawei.beta_app2023.dbo.nps_cabecera
            WHERE estado = '1'";
        return $this->dao->consulta($sql);
    }
    public function ultomo_registro()
    {
        $sql = "SELECT 
        RIGHT('00' + CAST(DAY(MAX(fecha_registro)) AS VARCHAR), 2) + '/' +
        RIGHT('00' + CAST(MONTH(MAX(fecha_registro)) AS VARCHAR), 2) + '/' +
        CAST(YEAR(MAX(fecha_registro)) AS VARCHAR) + ' ' +
        RIGHT('00' + CAST(DATEPART(HOUR, MAX(fecha_registro)) AS VARCHAR), 2) + ':' +
        RIGHT('00' + CAST(DATEPART(MINUTE, MAX(fecha_registro)) AS VARCHAR), 2)
        AS ultimo_registro
        FROM cloud_huawei.beta_app2023.dbo.nps_cabecera";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function barras_sector(?nps_respuestas $obj = null)
    {
        $sql = "SELECT 
    COUNT(CASE WHEN sector = 'U' AND estado = '1' THEN 1 END) AS u,
    COUNT(CASE WHEN sector = 'F' AND estado = '1' THEN 1 END) AS f,
    COUNT(CASE WHEN sector = 'E' AND estado = '1' THEN 1 END) AS e,
    COUNT(CASE WHEN sector = 'M' AND estado = '1' THEN 1 END) AS m,
    COUNT(CASE WHEN sector = 'P' AND estado = '1' THEN 1 END) AS p,
    COUNT(CASE WHEN sector = 'I' AND estado = '1' THEN 1 END) AS i
    FROM cloud_huawei.beta_app2023.dbo.nps_cabecera";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function personas_cr(?nps_respuestas $obj = null)
    {
        $sql = "SELECT l.cc_local,
        COUNT(c.c_persona) AS total_personas
        FROM cloud_huawei.beta_app2023.dbo.gen_local AS l LEFT JOIN cloud_huawei.beta_app2023.dbo.nps_cabecera AS c
        ON l.cc_local = c.c_local AND c.estado = '1' 
        WHERE l.adm = '*'  
        GROUP BY l.cc_local
        ORDER BY l.cc_local";
        return $this->dao->consulta($sql);
    }
    public function total_local()
    {
        $sql = "SELECT 
    l.nombre,
    COUNT(DISTINCT e.c_persona) AS cantidad
    FROM cloud_huawei.beta_app2023.dbo.nps_cabecera AS e
    INNER JOIN cloud_huawei.beta_app2023.dbo.gen_personas AS p
        ON e.c_persona = p.cc_persona
    INNER JOIN cloud_huawei.beta_app2023.dbo.gen_local AS l
        ON l.cc_local = p.cc_local
    WHERE e.estado = '1'
    GROUP BY l.nombre
    ORDER BY l.nombre";
        return $this->dao->consulta($sql);
    }
}
