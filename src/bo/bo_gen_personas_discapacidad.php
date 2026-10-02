<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas_discapacidad.php';
class bo_gen_personas_discapacidad
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas_discapacidad();
    }

    public function control(gen_personas_discapacidad $obj, $opc)
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

    public function listarAnhos(gen_personas_discapacidad $obj = null)
    {
        $sql = "SELECT DISTINCT YEAR(fecha_crea) AS anho
                FROM gen_personas_discapacidad";
        return $this->dao->consulta($sql);
    }

    public function ultimo(?gen_personas_discapacidad $obj = null)
    {
        $sql = "select MAX(cc_discapac) ultimo from gen_personas_discapacidad";
        return $this->dao->consulta($sql);
    }

    public function listar(?gen_personas_discapacidad $obj = null)
    {
        $sql = "select d.cc_discapac,
                p.c_cmp, RTRIM(p.nombre) nombre,
                p.c_local,
                l.nombre_abv as c_local_text,
                dbo.fc_v1_parametro_valor('gen_personas_discapacidad','cod_tipo',d.cod_tipo) as cod_tipo_text,
                dbo.fc_fecha_texto(d.fecha_registro) AS fecha_registro,
                d.reg_conadis,
                d.obs,
                d.flag,
                dbo.fc_v1_parametro_valor('gen_personas_discapacidad','flag',d.flag) as flag_text
                from gen_personas_discapacidad d inner join Personas p
                on d.cc_persona=p.c_persona
                inner join gen_local l
                on p.c_local=l.c_local
                where RTRIM(p.nombre) like '%{$obj->getNombre()}%'";
        if (strlen($obj->getC_local()) > 0) {
            $sql .= " and p.c_local='{$obj->getC_local()}'";
        }
        if (strlen($obj->getAnho()) > 0) {
            $sql .= " and year(d.fecha_registro)='{$obj->getAnho()}'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?gen_personas_discapacidad $obj = null)
    {
        $sql = "select
				d.cc_discapac,
				p.c_persona,
				dbo.fc_fecha_from(d.fecha_registro) AS fecha_conadis,
				dbo.fc_fecha_from(d.fecha_crea) AS fecha_registro,
				RTRIM(p.nombre) nombre,
				d.cod_tipo,
				d.reg_conadis,
                d.obs,
                d.flag
				from gen_personas_discapacidad d inner join Personas p
				on d.cc_persona=p.c_persona
				where d.cc_discapac={$obj->getCc_discapac()}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /** Dashboard */
    public function cantidadPorLocal($c_local, $anho)
    {
        $filtro_local = !empty($c_local) ? " AND p.c_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad
        FROM gen_personas_discapacidad d
        INNER JOIN Personas p ON d.cc_persona = p.c_persona
        WHERE YEAR(d.fecha_registro) = '{$anho}'{$filtro_local}";
        return $this->dao->consulta($sql);
    }
}
