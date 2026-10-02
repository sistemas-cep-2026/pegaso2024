<?php
require_once dirname(__DIR__) . '/dao/dao_prestamos_socios.php';
class bo_prestamos_socios
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_prestamos_socios();
    }

    public function control(prestamos_socios $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "A":
                return $this->dao->eliminar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(prestamos_socios $obj = null)
    {
        $sql = "select  f.cc_fraccionamiento,dbo.fc_fecha_texto(f.fecha) AS fecha,p.c_cmp,p.nombre,f.c_usuario,f.c_local,
f.valor_cuota,f.capital,f.num_cuotas,f.flag,
    dbo.fc_v1_parametro_valor('documentos_de_venta', 'flag', f.flag) AS flag_text
from prestamos_socios f 
inner join Personas p on p.c_persona=f.c_persona
where f.fecha BETWEEN '{$obj->getCod_desde()} 00:00:00' AND '{$obj->getCod_hasta()} 23:59:59' and f.c_local='{$obj->getC_local()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPersona(prestamos_socios $obj = null)
    {
        $sql = "select *,
                dbo.fc_fecha_texto(fecha) AS fecha_texto,
                dbo.fc_v1_parametro_valor('prestamos_socios', 'flag', flag) AS flag_text
        from prestamos_socios where c_persona = '{$obj->getC_persona()}' order by fecha DESC,cc_fraccionamiento;";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(prestamos_socios $obj = null)
    {
        $sql = "select ps.*,
                dbo.fc_fecha_texto(ps.fecha) AS fecha_texto,
                dbo.fc_v1_parametro_valor('prestamos_socios', 'flag', ps.flag) AS flag_text,p.nombre,p.c_cmp,lo.nombre as nombre_local,p.cod_documento,p.num_documento
        from prestamos_socios ps inner join personas p on p.c_persona=ps.c_persona 
        inner join local lo on lo.c_local=ps.c_local
        where cc_fraccionamiento = '{$obj->getCc_fraccionamiento()}'  ;";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
