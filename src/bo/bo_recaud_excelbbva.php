<?php
require_once dirname(__DIR__) . '/dao/dao_recaud_excelbbva.php';
class bo_recaud_excelbbva
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_recaud_excelbbva();
    }

    public function subirRecaudadorabbva(recaud_excelbbva $obj)
    {
        return $this->dao->subirRecaudadorabbva($obj);
    }

    public function procesarRecaudadoraBBVA(recaud_excelbbva $obj)
    {
        return $this->dao->procesarRecaudadoraBBVA($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function Recaudadora_Excelbbva(recaud_excelbbva $obj = null)
    {
        // La tabla recaud_excelbbva es transitoria (carga cruda del archivo, se
        // limpia/recrea en cada ciclo) y puede no existir en un momento dado.
        // Se verifica antes de consultarla para no provocar un error SQL fatal.
        $sql = "IF OBJECT_ID('dbo.recaud_excelbbva', 'U') IS NOT NULL
            select 	nombre, referencia1, referencia2, importe1,num_movimiento, fecha_pago 
            FROM recaud_excelbbva";
        return $this->dao->consulta($sql);
    }

    public function ultimaActualizacion(recaud_excelbbva $obj = null)
    {
        // misma razón que en Recaudadora_Excelbbva(): la tabla puede no existir.
        $sql = "IF OBJECT_ID('dbo.recaud_excelbbva', 'U') IS NOT NULL
            select dbo.fc_v1_fecha_hora(max(fecha_pago)) as ultimo
            FROM recaud_excelbbva
        ELSE
            select NULL as ultimo";
        return $this->dao->consulta($sql);
    }

    /**
     * Dashboard — montos ya procesados/distribuidos (bbva_proceso_detalle).
     * Esta tabla SÍ es permanente (la usan bo_gen_personas_pagos, bo_tram_honorabilidad,
     * bo_general y otros), así que no necesita el mismo blindaje que la tabla cruda.
     * Según la estructura real: 'nacional' = parte que corresponde al Consejo
     * Nacional (de TODAS las transacciones del sistema); 'region' = parte que
     * corresponde a un consejo regional puntual (solo de sus propias filas).
     * Vista Consejo Nacional (c_local vacío o '28'): SUM(nacional), sin filtrar por c_local.
     * Vista de un consejo regional específico: SUM(region) WHERE c_local = ese consejo.
     */
    public function montoPorMes($anho, $c_local = '')
    {
        if (empty($c_local) || $c_local === '28') {
            $columna = 'nacional';
            $filtro_local = '';
        } else {
            $columna = 'region';
            $filtro_local = " AND c_local = '{$c_local}'";
        }
        $sql = "SELECT MONTH(fecha_pago) AS mes, SUM({$columna}) AS monto
        FROM bbva_proceso_detalle
        WHERE YEAR(fecha_pago) = '{$anho}'{$filtro_local}
        GROUP BY MONTH(fecha_pago)
        ORDER BY mes";
        return $this->dao->consulta($sql);
    }
}
