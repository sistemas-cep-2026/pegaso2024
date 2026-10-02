<?php
require_once dirname(__DIR__) . '/dao/dao_tram_permisos.php';
class bo_tram_permisos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_permisos();
    }

    public function control(tram_permisos $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "A":
            case "E":
                return $this->dao->eliminar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listaAnho(?tram_permisos $obj = null)
    {
        $sql = "select year(fecha) cod_anho from tram_permisos
                group by year(fecha)
                order by year(fecha) desc";
        return $this->dao->consulta($sql);
    }
    public function listar(?tram_permisos $obj = null)
    {
        $filtro_local = !empty($obj->getC_local()) ? " and pr.c_local='{$obj->getC_local()}'" : "";

        $sql = "select pr.cc_permisos,
        pr.cc_usuario_e,
        dbo.fc_v1_parametro_valor('tram_permisos','tipo_permisos',pr.tipo_permisos) AS tipo_permisos_text,
        RTRIM(p.nombre) as nombre, 
        dbo.fc_fecha_texto(pr.fecha) fecha_emi,
        LEFT(CONVERT(VARCHAR(8), pr.fecha_ida, 108), 5) AS salida,
        LEFT(CONVERT(VARCHAR(8), pr.fecha_retorno, 108), 5) AS retorno,
        pr.motivo,
        pr.flag,
        dbo.fc_v1_parametro_valor('tram_permisos','flag',pr.flag) AS flag_text
        from tram_permisos pr left join seg_usuarios u
        on pr.cc_usuario_e=u.usuario 
        left join Personas p
        on p.c_persona=u.cc_persona
        where pr.tipo_permisos='{$obj->getTipo_permisos()}' and YEAR(pr.fecha)='{$obj->getCod_anho()}' and MONTH(pr.fecha)='{$obj->getPeriodo()}'{$filtro_local}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?tram_permisos $obj = null)
    {
        $sql = "SELECT
            pr.cc_permisos,
            pr.tipo_permisos,
            dbo.fc_v1_parametro_valor('tram_permisos','tipo_permisos',pr.tipo_permisos) AS tipo_permisos_text,
            CONVERT(VARCHAR(10), pr.fecha, 23) AS fecha,
            dbo.fc_fecha_texto(pr.fecha) AS fecha_emi,
            CONVERT(VARCHAR(5), pr.fecha_ida, 108) AS fecha_ida,
            CONVERT(VARCHAR(5), pr.fecha_retorno, 108) AS fecha_retorno,
            pr.cc_usuario_e,
            pr.cc_area_adm,
            RTRIM(a.nombre) AS area_nombre,
            RTRIM(p.nombre) AS nombre,
            pr.motivo,
            pr.obs,
            pr.destinos
        FROM tram_permisos pr
        LEFT JOIN seg_usuarios u ON pr.cc_usuario_e = u.usuario
        LEFT JOIN Personas p ON p.c_persona = u.cc_persona
        LEFT JOIN gen_area_adm a ON a.cc_area_adm = pr.cc_area_adm
        WHERE pr.cc_permisos = {$obj->getCc_permisos()}";
        return $this->dao->consulta($sql);
    }

    public function ultimo()
    {
        $sql = "SELECT MAX(cc_permisos) AS ultimo FROM tram_permisos";
        return $this->dao->consulta($sql);
    }

    /** Dashboard */
    public function cantidadVigentes($c_local)
    {
        $filtro_local = !empty($c_local) ? " AND c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad
        FROM tram_permisos
        WHERE flag = '*'{$filtro_local}";
        return $this->dao->consulta($sql);
    }
}
