<?php
require_once dirname(__DIR__) . '/dao/dao_banc_saldos_bancos_cuentas.php';
class bo_banc_saldos_bancos_cuentas
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_saldos_bancos_cuentas();
    }

    public function procesar(banc_saldos_bancos_cuentas $obj)
    {
        return $this->dao->procesar($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(?banc_saldos_bancos_cuentas $obj = null)
    {
        $sql = "select dbo.fc_fecha_texto(c.fecha) fecha,c.c_banco,c.c_cta_cte,c.saldo_final,
        c.c_anho,c.c_mes,c.cc_saldo,c.cc_local,b.nombre
        from saldos_bancos_cuentas c 
        inner join	bancos b on b.c_banco=c.c_banco
        where c.c_anho='" . $obj->getCod_ano() . "'";
        if (!empty($obj->getCod_mes())) {
            $sql .= "  and c.c_mes='" . $obj->getCod_mes() . "' ";
        }
        if (!empty($obj->getC_banco())) {
            $sql .= "  and c.c_banco='" . $obj->getC_banco() . "' ";
        }
        if (!empty($obj->getC_cta_cte())) {
            $sql .= "  and c.c_cta_cte='" . $obj->getC_cta_cte() . "' ";
        }
        $sql .= " order by c.c_cta_cte,c.c_anho, c.c_mes desc";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?banc_saldos_bancos_cuentas $obj = null)
    {
        $sql = "select dbo.fc_fecha_from(c.fecha) fecha,c.c_banco,c.c_cta_cte,c.saldo_final,
c.c_anho,c.c_mes,c.cc_saldo,c.cc_local ,c.c_banco+'-'+rtrim(c.c_cta_cte) banco_cta
from saldos_bancos_cuentas c 
where c.cc_saldo='" . $obj->getCc_saldo() . "';";
        return $this->dao->consulta($sql);
    }

    /** Dashboard bancos — saldo total del período (todas las cuentas del consejo) */
    public function totalSaldo($anho, $mes, $c_local)
    {
        $filtro_mes = !empty($mes) ? " AND c_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND cc_local = '{$c_local}'" : "";
        $sql = "SELECT SUM(saldo_final) AS total
        FROM saldos_bancos_cuentas
        WHERE c_anho = '{$anho}'{$filtro_mes}{$filtro_local}";
        return $this->dao->consulta($sql);
    }
}
