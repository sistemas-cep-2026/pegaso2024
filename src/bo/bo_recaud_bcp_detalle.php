<?php
require_once dirname(__DIR__) . '/dao/dao_recaud_bcp_detalle.php';
class bo_recaud_bcp_detalle
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_recaud_bcp_detalle();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(recaud_bcp_detalle $obj = null)
    {
        $sql = "select 
        bcp.id,
        bcp.c_local,
        bcp.dato_adicional AS nombre1,
        p.c_cmp AS c_cmp,
        ISNULL(LEFT(RTRIM(p.nombre), 30), bcp.dato_adicional) AS nombre2,  
        CONVERT(VARCHAR(10), CAST(bcp.fecha AS DATE), 103) AS fecha,
        bcp.total_distribuir,
        bcp.distribuir,
        bcp.fijoregion,
        bcp.region,
        bcp.nacional,
        bcp.fecha + bcp.hora AS num,
        p.c_persona,
        bcp.hora,
        bcp.numero_operacion,
        bcp.operacion_canal,
        bcp.operacion_db 
        FROM recaud_bcp_detalle bcp
        LEFT JOIN personas p ON p.c_persona = bcp.c_persona
        WHERE dato_adicional like '%'";
        if ($obj->getTipo() === 'H') {
            $sql .= " and bcp.fecha = CONVERT(VARCHAR(8), GETDATE(), 112)";
        }
        if ($obj->getTipo() === 'D') {
            $sql .= " and LEFT(bcp.fecha,6)='".$obj->getPeriodo()."'";
        }
        $sql .= " and bcp.c_local LIKE '{$obj->getC_local()}%'";
        $sql .= " ORDER BY bcp.fecha + bcp.hora DESC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function total_recaudo(recaud_bcp_detalle $obj = null)
    {
        $sql = "select 
        count(id) as cantidad,
        SUM(total_distribuir) AS total_total_distribuir, 
        SUM(distribuir) AS total_distribuir, 
        SUM(fijoregion) AS total_fijoregion, 
        SUM(region) AS total_region, 
        SUM(nacional) AS total_nacional
        FROM recaud_bcp_detalle
        WHERE dato_adicional LIKE '%'"; 
        if ($obj->getTipo() === 'H') {
            $sql .= " and fecha = CONVERT(VARCHAR(8), GETDATE(), 112)";
        }
        if ($obj->getTipo() === 'D') {
            $sql .= " and LEFT(fecha,6)='".$obj->getPeriodo()."'";
        }
        return $this->dao->consulta($sql);
    }

}