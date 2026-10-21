<?php
require_once dirname(__DIR__) . '/dao/dao_recaud_bcp_proceso_detalle.php';
class bo_recaud_bcp_proceso_detalle
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_recaud_bcp_proceso_detalle();
    }

    public function control(recaud_bcp_proceso_detalle $obj, $opc)
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

    public function listar(?recaud_bcp_proceso_detalle $obj = null)
    {
        $sql = "select 
        bcp.fecha,bcp.id, bcp.c_local, bcp.dato_adicional AS nombre1,
        p.c_cmp AS c_cmp, ISNULL(LEFT(RTRIM(p.nombre), 30), bcp.dato_adicional) AS nombre2,
        CONVERT(VARCHAR(10), CAST(bcp.fecha AS DATE), 103) AS fecha, 
        bcp.total_distribuir, 
        bcp.distribuir, 
        bcp.fijoregion, 
        bcp.region, 
        bcp.nacional,
        bcp.fecha + bcp.hora AS num, p.c_persona, bcp.hora,  
        bcp.operacion_canal ,dbo.fc_fecha_hora(bcp.fecha_id) fecha_id
        FROM bcp_proceso_detalle bcp LEFT JOIN personas p ON p.c_persona = bcp.c_persona
        WHERE dato_adicional like '%'";
        if ($obj->getTipo() === 'H') {
            $sql .= " and rtrim(bcp.fecha) = CONVERT(VARCHAR(8), GETDATE(), 112)";
        }
        if ($obj->getTipo() === 'D') {
            $sql .= " and LEFT(bcp.fecha,6)='" . $obj->getPeriodo() . "'";
        }
        $sql .= " and ISNULL(bcp.c_local,'%') LIKE '{$obj->getC_local()}%'";
        $sql .= " ORDER BY bcp.fecha + bcp.hora DESC";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function total_recaudo(?recaud_bcp_proceso_detalle $obj = null)
    {
        $sql = "select 
        count(id) as cantidad,
        SUM(total_distribuir) AS total_total_distribuir, 
        SUM(distribuir) AS total_distribuir, 
        SUM(fijoregion) AS total_fijoregion, 
        SUM(region) AS total_region, 
        SUM(nacional) AS total_nacional
        FROM bcp_proceso_detalle
        WHERE dato_adicional LIKE '%'";
        if ($obj->getTipo() === 'H') {
            $sql .= " and fecha = CONVERT(VARCHAR(8), GETDATE(), 112)";
        }
        if ($obj->getTipo() === 'D') {
            $sql .= " and LEFT(fecha,6)='" . $obj->getPeriodo() . "'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function recaudo_resumen(?recaud_bcp_proceso_detalle $obj = null)
    {
        $sql = " SELECT  cast(COUNT(*) as CHAR(10)) as tt,SUBSTRING(bcp_proceso_detalle.dato_adicional,1,1) AS dd,bcp_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+
        '( '+(case SUBSTRING(bcp_proceso_detalle.dato_adicional,1,1)
	when 'C'
	then substring(rtrim(bcp_proceso_detalle.dato_adicional),10,21)
	when 'M'
	then substring(rtrim(bcp_proceso_detalle.dato_adicional),15,25)
	 when 'R' then substring(rtrim(bcp_proceso_detalle.dato_adicional),15,25) 
	else 'NO ubicado' end )
	+' )'  +' OPE=>'+cast(COUNT(*) as CHAR(10)) AS nombre1, 
	sum(bcp_proceso_detalle.total_distribuir) as total, sum(bcp_proceso_detalle.distribuir) as distribuir, 
	sum(bcp_proceso_detalle.fijoregion) as fijoregion, sum(bcp_proceso_detalle.region) as region, 
	sum(bcp_proceso_detalle.nacional) as nacional 
	FROM bcp_proceso_detalle (nolock) inner join local (nolock) on local.c_local=bcp_proceso_detalle.c_local 
	where substring(bcp_proceso_detalle.fecha,1,4)+substring(bcp_proceso_detalle.fecha,5,2)=substring('{$obj->getPeriodo()}',1,6)
				AND bcp_proceso_detalle.c_local LIKE RTRIM('{$obj->getC_local()}') 
	group by  SUBSTRING(bcp_proceso_detalle.dato_adicional,1,1),bcp_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+'( '+(case SUBSTRING(bcp_proceso_detalle.dato_adicional,1,1)
when 'C'
then substring(rtrim(bcp_proceso_detalle.dato_adicional),10,21)
when 'M'
then substring(rtrim(bcp_proceso_detalle.dato_adicional),15,25)
 when 'R' then substring(rtrim(bcp_proceso_detalle.dato_adicional),15,25) 
else 'NO ubicado' end )
+' )'  
	order by bcp_proceso_detalle.c_local, RTRIM(local.nombre_abv)+' '+'( '+(case SUBSTRING(bcp_proceso_detalle.dato_adicional,1,1)
when 'C'
then substring(rtrim(bcp_proceso_detalle.dato_adicional),10,21)
when 'M'
then substring(rtrim(bcp_proceso_detalle.dato_adicional),15,25)
 when 'R' then substring(rtrim(bcp_proceso_detalle.dato_adicional),15,25) 
else 'NO ubicado' end )
+' )'   
	
 ";
//echo $sql;
        return $this->dao->consulta($sql);
    }


    public function recaudadora_conciliado(?recaud_bcp_proceso_detalle $obj = null)
    {
        $sql = "SELECT recaudo_bcp_666 FROM periodos (nolock) 
    where c_ano=substring('{$obj->getPeriodo()}',1,4) and c_mes=substring('{$obj->getPeriodo()}',5,2) ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}