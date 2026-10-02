<?php
require_once dirname(__DIR__) . '/dao/dao_banc_dietas.php';
class bo_banc_dietas
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_dietas();
    }

    public function procesarDietas(banc_dietas $obj)
    {
        return $this->dao->procesarDietas($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(?banc_dietas $obj = null)
    {
        $sql = "select b.flag,b.cc_dietas, dbo.fc_fecha_texto(b.fecha) as fecha,b.referencia,b.c_area_adm,b.id_bancos,b.voucher,p.nombre nombre_persona,p.c_cmp 
,g.nombre nombre_area
,(select renta_bruta FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas and bd1.concepto='1' ) as movilidad
,(select renta_bruta FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas and bd1.concepto='2' ) as dieta

,(select sum(renta_bruta*retencion) FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas  ) as retencion
,b.voucher,b.cod_ano,b.cod_mes
from banc_dietas b 
inner join personas p on p.c_persona=b.cc_persona
inner join gen_area_adm g on g.cc_area_adm=b.c_area_adm

where b.fecha between '{$obj->getDesde()}' and '{$obj->getHasta()}' and b.cc_local='{$obj->getCc_local()}'
order by b.fecha desc,p.nombre
 ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listar_periodo(?banc_dietas $obj = null)
    {
        $sql = "
        select b.flag, b.cc_dietas,
        dbo.fc_fecha_texto(b.fecha) as fecha,b.referencia,b.c_area_adm,b.id_bancos,b.voucher,p.nombre nombre_persona,p.c_cmp 
,g.nombre nombre_area
,(select renta_bruta FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas and bd1.concepto='1' ) as movilidad
,(select renta_bruta FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas and bd1.concepto='2' ) as dieta

,(select sum(renta_bruta*retencion) FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas  ) as retencion
,(select sum(neto) FROM banc_dietas_detalles bd1 WHERE bd1.cc_dietas=b.cc_dietas  ) as neto
,b.voucher,b.cod_ano,b.cod_mes,
(CASE 
        WHEN b.flag = 'A' THEN 'Anulado'
        WHEN b.flag = '&' THEN 'Pendiente'
        ELSE 'Procesado'
    END) AS flag_texto 
from banc_dietas b 
inner join personas p on p.c_persona=b.cc_persona
inner join gen_area_adm g on g.cc_area_adm=b.c_area_adm

where b.cod_ano ='{$obj->getCod_ano()}' and b.cod_mes='{$obj->getCod_mes()}' and b.cc_local='{$obj->getCc_local()}'
order by b.fecha desc,p.nombre
 ";
        return $this->dao->consulta($sql);
    }

    public function listarID(?banc_dietas $obj = null)
    {
        $sql = "select b.cc_persona,b.flag,b.cc_dietas,b.cc_local,      
          dbo.fc_v1_fecha_texto(b.fecha) as fecha_text,
        dbo.fc_fecha_from(b.fecha) as fecha, 
          b.referencia,b.c_area_adm,b.id_bancos,b.voucher,p.nombre nombre_persona,p.c_cmp 
,g.nombre nombre_area
 
,b.voucher,p.cod_documento,p.num_documento,b.cod_ano,b.cod_mes,p.ruc
from banc_dietas b 
inner join personas p on p.c_persona=b.cc_persona
inner join gen_area_adm g on g.cc_area_adm=b.c_area_adm

where b.cc_dietas='{$obj->getCc_dietas()}'
";
        return $this->dao->consulta($sql);
    }

    /** Dashboard bancos — total y serie por mes (neto = monto real pagado) */
    public function totalDietas($anho, $mes, $c_local)
    {
        $filtro_mes = !empty($mes) ? " AND b.cod_mes = '{$mes}'" : "";
        $filtro_local = !empty($c_local) ? " AND b.cc_local = '{$c_local}'" : "";
        $sql = "SELECT COUNT(DISTINCT b.cc_dietas) AS cantidad, SUM(bd.neto) AS monto
        FROM banc_dietas b
        INNER JOIN banc_dietas_detalles bd ON bd.cc_dietas = b.cc_dietas
        WHERE b.cod_ano = '{$anho}'{$filtro_mes}{$filtro_local}";
        return $this->dao->consulta($sql);
    }

    public function montoPorMes($anho, $c_local)
    {
        $filtro_local = !empty($c_local) ? " AND b.cc_local = '{$c_local}'" : "";
        $sql = "SELECT b.cod_mes AS mes, COUNT(DISTINCT b.cc_dietas) AS cantidad, SUM(bd.neto) AS monto
        FROM banc_dietas b
        INNER JOIN banc_dietas_detalles bd ON bd.cc_dietas = b.cc_dietas
        WHERE b.cod_ano = '{$anho}'{$filtro_local}
        GROUP BY b.cod_mes
        ORDER BY b.cod_mes";
        return $this->dao->consulta($sql);
    }
}
