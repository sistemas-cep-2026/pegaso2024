<?php
require_once dirname(__DIR__) . '/dao/dao_banc_beneficiofam.php';
class bo_banc_beneficiofam
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_beneficiofam();
    }

    public function control(banc_beneficiofam $obj, $opc)
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

    public function cod_anhos(?banc_beneficiofam $obj = null)
    {
        $sql = "select year(fecha_crea) as cod_anho 
        from banc_beneficiofam
        group by year(fecha_crea)
        order by year(fecha_crea) desc";
        return $this->dao->consulta($sql);
    }

    public function listar(?banc_beneficiofam $obj = null)
    {
        $sql = "select f.cc_beneficiofam, 
        f.fecha, 
        f.cc_local, 
        f.cc_persona, 
        f.referencia, 
        f.user_crea, 
        dbo.fc_fecha_texto(f.fecha_crea) fecha_crea,
        rtrim(p.c_cmp) as cep,
        rtrim(p.nombre) as nombre_completo,
        f.c_banco, 
        dbo.fc_fecha_texto(f.fecha_operacion) fecha_operacion, 
        f.monto, 
        f.operacion, 
        f.cod_tipo,
        dbo.fc_v1_parametro_valor('banc_beneficiofam','cod_tipo',f.cod_tipo) as cod_tipo_text, 
        f.flag
        FROM dbo.banc_beneficiofam f (nolock) inner join dbo.personas p (nolock)
        on f.cc_persona=p.c_persona
        where year(f.fecha_crea)='{$obj->getCod_anho()}'";
        if (strlen($obj->getCod_mes()) > 0) {
            $sql .= " and MONTH(f.fecha_crea)='{$obj->getCod_mes()}'";
        }

        if (strlen($obj->getCc_local()) > 0) {
            $sql .= " and f.cc_local='{$obj->getCc_local()}'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar_id(?banc_beneficiofam $obj = null)
    {
        $sql = "select f.cc_beneficiofam,dbo.fc_fecha_texto(f.fecha) fecha, f.cc_local, f.cc_persona, f.referencia, f.user_crea, 
        dbo.fc_fecha_texto(f.fecha_registro) fecha_crea, f.c_banco, dbo.fc_fecha_texto(f.fecha_operacion) fecha_operacion,
         f.monto, f.operacion, 
        f.cod_tipo, dbo.fc_v1_parametro_valor('banc_beneficiofam','cod_tipo',f.cod_tipo) as cod_tipo_text  
        FROM dbo.banc_beneficiofam f (nolock) 
        
        where f.cc_persona='{$obj->getCc_persona()}'";

        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function validar(?banc_beneficiofam $obj = null)
    {
        $sql = "select * from banc_beneficiofam 
            where cc_persona='{$obj->getCc_persona()}'
            and flag <> 'A'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function resumen(?banc_beneficiofam $obj = null)
    {
        $sql = "select f.cc_local,
            l.nombre1,
            SUM(CASE WHEN f.cod_tipo = '0' THEN 1 ELSE 0 END) AS cantidad0,
            SUM(CASE WHEN f.cod_tipo = '0' THEN f.monto ELSE 0 END) AS total0,
            SUM(CASE WHEN f.cod_tipo = '1' THEN 1 ELSE 0 END) AS cantidad1,
            SUM(CASE WHEN f.cod_tipo = '1' THEN f.monto ELSE 0 END) AS total1,
            SUM(CASE WHEN f.cod_tipo = '2' THEN 1 ELSE 0 END) AS cantidad2,
            SUM(CASE WHEN f.cod_tipo = '2' THEN f.monto ELSE 0 END) AS total2,
            SUM(CASE WHEN f.cod_tipo = '3' THEN 1 ELSE 0 END) AS cantidad3,
            SUM(CASE WHEN f.cod_tipo = '3' THEN f.monto ELSE 0 END) AS total3,
            SUM(CASE WHEN f.cod_tipo = '4' THEN 1 ELSE 0 END) AS cantidad4,
            SUM(CASE WHEN f.cod_tipo = '4' THEN f.monto ELSE 0 END) AS total4,
            SUM(CASE WHEN f.cod_tipo = '5' THEN 1 ELSE 0 END) AS cantidad5,
            SUM(CASE WHEN f.cod_tipo = '5' THEN f.monto ELSE 0 END) AS total5
            FROM  banc_beneficiofam f INNER JOIN local l 
            ON l.c_local = f.cc_local
            WHERE YEAR(f.fecha_crea) = {$obj->getCod_anho()}";

        if (strlen($obj->getCod_mes()) > 0) {
            $sql .= " and MONTH(f.fecha_crea)='{$obj->getCod_mes()}'";
        }
        if (strlen($obj->getCc_local()) > 0) {
            $sql .= " and f.cc_local='{$obj->getCc_local()}'";
        }
        $sql .= " GROUP BY f.cc_local, l.nombre1
            ORDER BY f.cc_local, l.nombre1";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function resumen_total(?banc_beneficiofam $obj = null)
    {
        $sql = "SELECT 
            COUNT(CASE WHEN cod_tipo = 0 THEN 1 END) AS cantidad_tipo_0,
            SUM(CASE WHEN cod_tipo = 0 THEN monto END) AS monto_tipo_0,

            COUNT(CASE WHEN cod_tipo = 1 THEN 1 END) AS cantidad_tipo_1,
            SUM(CASE WHEN cod_tipo = 1 THEN monto END) AS monto_tipo_1,

            COUNT(CASE WHEN cod_tipo = 2 THEN 1 END) AS cantidad_tipo_2,
            SUM(CASE WHEN cod_tipo = 2 THEN monto END) AS monto_tipo_2,

            COUNT(CASE WHEN cod_tipo = 3 THEN 1 END) AS cantidad_tipo_3,
            SUM(CASE WHEN cod_tipo = 3 THEN monto END) AS monto_tipo_3,

            COUNT(CASE WHEN cod_tipo = 4 THEN 1 END) AS cantidad_tipo_4,
            SUM(CASE WHEN cod_tipo = 4 THEN monto END) AS monto_tipo_4,

            COUNT(CASE WHEN cod_tipo = 5 THEN 1 END) AS cantidad_tipo_5,
            SUM(CASE WHEN cod_tipo = 5 THEN monto END) AS monto_tipo_5
            FROM banc_beneficiofam
            WHERE YEAR(fecha_crea) = {$obj->getCod_anho()}";

        if (strlen($obj->getCod_mes()) > 0) {
            $sql .= " and MONTH(fecha_crea)='{$obj->getCod_mes()}'";
        }
        if (strlen($obj->getCc_local()) > 0) {
            $sql .= " and cc_local='{$obj->getCc_local()}'";
        }
        return $this->dao->consulta($sql);
    }
}
