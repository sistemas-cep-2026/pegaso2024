<?php
require_once dirname(__DIR__) . '/dao/dao_bcp_proceso_detalle.php';
class bo_bcp_proceso_detalle
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_bcp_proceso_detalle();
    }

    public function control(bcp_proceso_detalle $obj, $opc)
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
    public function ultimaActualizacion(?bcp_proceso_detalle $obj = null)
    {

        $sql = "IF OBJECT_ID('dbo.bcp_proceso_detalle', 'U') IS NOT NULL
            select dbo.fc_v1_fecha_hora(max(fecha_id)) as ultimo
            FROM bcp_proceso_detalle
        ELSE
            select NULL as ultimo";
        return $this->dao->consulta($sql);
    }
    public function montoPorMes($anho, $c_local = '')
    {
        if (empty($c_local) || $c_local === '28') {
            $columna = 'nacional';
            $filtro_local = '';
        } else {
            $columna = 'region';
            $filtro_local = " AND c_local = '{$c_local}'";
        }
        $sql = "SELECT CAST(SUBSTRING(fecha, 5, 2) AS INT) AS mes, SUM({$columna}) AS monto
        FROM bcp_proceso_detalle
        WHERE LEFT(fecha, 4) = '{$anho}'
          AND LEN(fecha) = 8{$filtro_local}
        GROUP BY SUBSTRING(fecha, 5, 2)
        ORDER BY mes";
        return $this->dao->consulta($sql);
    }
}
