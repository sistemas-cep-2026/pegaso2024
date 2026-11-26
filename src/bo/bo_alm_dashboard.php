<?php
require_once dirname(__DIR__) . '/dao/dao_alm_dashboard.php';

/**
 * Dashboard de almacén (solo lectura).
 * Estados según los botones de cada módulo:
 *  - requisicion_de_compras.flag: '0' en registro, '&' pendiente, '*' atendida, 'A' anulada.
 *  - guias_de_entrada / guias_de_salida.flag: '0' en registro, 'P' pendiente de kardex, 'T' procesada, 'A' anulada.
 * Se cuentan los documentos que no están en registro ni anulados. El período usa la columna fecha.
 * $c_local = '' significa todos los consejos.
 */
class bo_alm_dashboard
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_dashboard();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    /** Rango [desde, hasta) en formato yyyymmdd para filtrar la fecha sin funciones sobre la columna. */
    private function rango($anho, $mes)
    {
        $anho = (int) $anho;
        $mes = (int) $mes;
        if ($mes >= 1 && $mes <= 12) {
            $desde = sprintf('%04d%02d01', $anho, $mes);
            $hasta = ($mes === 12) ? sprintf('%04d0101', $anho + 1) : sprintf('%04d%02d01', $anho, $mes + 1);
        } else {
            $desde = sprintf('%04d0101', $anho);
            $hasta = sprintf('%04d0101', $anho + 1);
        }
        return array($desde, $hasta);
    }

    /** Agrega el filtro de consejo si corresponde. */
    private function filtroLocal($columna, $c_local, &$params)
    {
        $c_local = trim((string) $c_local);
        if ($c_local === '') {
            return '';
        }
        $params[] = $c_local;
        return " AND $columna = ?";
    }

    public function listarAnhos()
    {
        $sql = "SELECT DISTINCT anho FROM (
                    SELECT YEAR(fecha) anho FROM guias_de_salida WITH (NOLOCK) WHERE fecha IS NOT NULL
                    UNION SELECT YEAR(fecha) FROM guias_de_entrada WITH (NOLOCK) WHERE fecha IS NOT NULL
                    UNION SELECT YEAR(fecha) FROM requisicion_de_compras WITH (NOLOCK) WHERE fecha IS NOT NULL
                ) x WHERE anho BETWEEN 2000 AND YEAR(GETDATE()) + 1 ORDER BY anho DESC";
        return $this->dao->consultaParams($sql, array());
    }

    /** Requisiciones del período: total y pendientes (flag '&'). */
    public function kpiRequisiciones($anho, $mes, $c_local)
    {
        list($desde, $hasta) = $this->rango($anho, $mes);
        $params = array($desde, $hasta);
        $sql = "SELECT COUNT(*) total, SUM(CASE WHEN r.flag = '&' THEN 1 ELSE 0 END) pendientes
                FROM requisicion_de_compras r WITH (NOLOCK)
                WHERE r.fecha >= ? AND r.fecha < ? AND ISNULL(r.flag, '') NOT IN ('0', 'A')"
            . $this->filtroLocal('r.cc_local', $c_local, $params);
        return $this->dao->consultaParams($sql, $params);
    }

    /** Guías de entrada o vales de salida del período: total y pendientes de kardex (flag 'P'). */
    public function kpiGuias($tipo, $anho, $mes, $c_local)
    {
        list($desde, $hasta) = $this->rango($anho, $mes);
        $params = array($desde, $hasta);
        if ($tipo === 'E') {
            $sql = "SELECT COUNT(*) total, SUM(CASE WHEN g.flag = 'P' THEN 1 ELSE 0 END) pendientes
                    FROM guias_de_entrada g WITH (NOLOCK)
                    WHERE g.fecha >= ? AND g.fecha < ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')"
                . $this->filtroLocal('g.cc_local', $c_local, $params);
        } else {
            $sql = "SELECT COUNT(*) total, SUM(CASE WHEN g.flag = 'P' THEN 1 ELSE 0 END) pendientes
                    FROM guias_de_salida g WITH (NOLOCK)
                    WHERE g.fecha >= ? AND g.fecha < ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')"
                . $this->filtroLocal('g.c_local', $c_local, $params);
        }
        return $this->dao->consultaParams($sql, $params);
    }

    /** Documentos y unidades por mes del año (entradas 'E' o salidas 'S'). */
    public function movimientosPorMes($tipo, $anho, $c_local)
    {
        list($desde, $hasta) = $this->rango($anho, 0);
        $params = array($desde, $hasta);
        if ($tipo === 'E') {
            $sql = "SELECT MONTH(g.fecha) mes, COUNT(DISTINCT g.cc_guia) documentos, ISNULL(SUM(i.cantidad), 0) unidades
                    FROM guias_de_entrada g WITH (NOLOCK)
                    LEFT JOIN Items_Guias_de_Entrada i WITH (NOLOCK) ON i.cc_guia = g.cc_guia
                    WHERE g.fecha >= ? AND g.fecha < ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')"
                . $this->filtroLocal('g.cc_local', $c_local, $params)
                . " GROUP BY MONTH(g.fecha)";
        } else {
            $sql = "SELECT MONTH(g.fecha) mes, COUNT(DISTINCT g.cc_guia) documentos, ISNULL(SUM(i.cantidad), 0) unidades
                    FROM guias_de_salida g WITH (NOLOCK)
                    LEFT JOIN items_guias_de_salida i WITH (NOLOCK) ON i.cc_guia = g.cc_guia
                    WHERE g.fecha >= ? AND g.fecha < ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')"
                . $this->filtroLocal('g.c_local', $c_local, $params)
                . " GROUP BY MONTH(g.fecha)";
        }
        return $this->dao->consultaParams($sql, $params);
    }

    /** Artículos más entregados en vales. */
    public function topArticulos($anho, $mes, $c_local, $top = 10)
    {
        list($desde, $hasta) = $this->rango($anho, $mes);
        $params = array($desde, $hasta);
        $sql = "SELECT TOP " . (int) $top . " i.c_articulo, RTRIM(ar.nombre) nombre, RTRIM(ar.unidad) unidad,
                       SUM(i.cantidad) unidades
                FROM guias_de_salida g WITH (NOLOCK)
                INNER JOIN items_guias_de_salida i WITH (NOLOCK) ON i.cc_guia = g.cc_guia
                INNER JOIN gen_articulos ar WITH (NOLOCK) ON ar.c_articulo = i.c_articulo
                WHERE g.fecha >= ? AND g.fecha < ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')"
            . $this->filtroLocal('g.c_local', $c_local, $params)
            . " GROUP BY i.c_articulo, ar.nombre, ar.unidad ORDER BY SUM(i.cantidad) DESC";
        return $this->dao->consultaParams($sql, $params);
    }

    /** Unidades entregadas por familia de artículo. */
    public function consumoPorFamilia($anho, $mes, $c_local)
    {
        list($desde, $hasta) = $this->rango($anho, $mes);
        $params = array($desde, $hasta);
        $sql = "SELECT ISNULL(RTRIM(f.nombre), 'SIN FAMILIA') familia, SUM(i.cantidad) unidades
                FROM guias_de_salida g WITH (NOLOCK)
                INNER JOIN items_guias_de_salida i WITH (NOLOCK) ON i.cc_guia = g.cc_guia
                INNER JOIN gen_articulos ar WITH (NOLOCK) ON ar.c_articulo = i.c_articulo
                LEFT JOIN gen_articulos_familias f WITH (NOLOCK) ON f.c_familia = ar.c_familia
                WHERE g.fecha >= ? AND g.fecha < ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')"
            . $this->filtroLocal('g.c_local', $c_local, $params)
            . " GROUP BY f.nombre ORDER BY SUM(i.cantidad) DESC";
        return $this->dao->consultaParams($sql, $params);
    }

    /**
     * Artículos consumidos en los últimos $meses meses cuyo stock actual del consejo no cubre
     * un mes de consumo promedio. Necesita un consejo concreto.
     */
    public function stockBajo($c_local, $meses = 6, $top = 15)
    {
        $c_local = trim((string) $c_local);
        $meses = max(1, (int) $meses);
        $desde = date('Ymd', strtotime('-' . $meses . ' months'));
        $sql = "SELECT TOP " . (int) $top . " c.c_articulo, RTRIM(ar.nombre) nombre, RTRIM(ar.unidad) unidad,
                       ISNULL(al.stock_actual, 0) stock, c.consumo / " . $meses . ".0 promedio_mes
                FROM (
                    SELECT i.c_articulo, SUM(i.cantidad) consumo
                    FROM guias_de_salida g WITH (NOLOCK)
                    INNER JOIN items_guias_de_salida i WITH (NOLOCK) ON i.cc_guia = g.cc_guia
                    WHERE g.c_local = ? AND g.fecha >= ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')
                    GROUP BY i.c_articulo
                ) c
                INNER JOIN gen_articulos ar WITH (NOLOCK) ON ar.c_articulo = c.c_articulo
                LEFT JOIN gen_articulos_local al WITH (NOLOCK) ON al.c_articulo = c.c_articulo AND al.c_local = ?
                WHERE c.consumo > 0 AND ISNULL(al.stock_actual, 0) < c.consumo / " . $meses . ".0
                ORDER BY ISNULL(al.stock_actual, 0) / NULLIF(c.consumo / " . $meses . ".0, 0) ASC, c.consumo DESC";
        return $this->dao->consultaParams($sql, array($c_local, $desde, $c_local));
    }

    /** Cuántos artículos con consumo reciente tienen stock en cero o negativo en el consejo. */
    public function totalSinStock($c_local, $meses = 6)
    {
        $c_local = trim((string) $c_local);
        $desde = date('Ymd', strtotime('-' . max(1, (int) $meses) . ' months'));
        $sql = "SELECT COUNT(*) total FROM (
                    SELECT DISTINCT i.c_articulo
                    FROM guias_de_salida g WITH (NOLOCK)
                    INNER JOIN items_guias_de_salida i WITH (NOLOCK) ON i.cc_guia = g.cc_guia
                    WHERE g.c_local = ? AND g.fecha >= ? AND ISNULL(g.flag, '') NOT IN ('0', 'A')
                ) c
                LEFT JOIN gen_articulos_local al WITH (NOLOCK) ON al.c_articulo = c.c_articulo AND al.c_local = ?
                WHERE ISNULL(al.stock_actual, 0) <= 0";
        return $this->dao->consultaParams($sql, array($c_local, $desde, $c_local));
    }
}
