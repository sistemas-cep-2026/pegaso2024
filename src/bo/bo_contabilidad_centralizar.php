<?php
require_once dirname(__DIR__) . '/dao/dao_contabilidad_centralizar.php';
class bo_contabilidad_centralizar
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_contabilidad_centralizar();
    }

    /*public function control(cont_asistencia $obj, $opc)
    {
        switch($opc){
            case "I":
            return $this->dao->insertar($obj);
            break;
            case "U":
            return $this->dao->modificar($obj);
            break;
            case "A":
            return $this->dao->anular($obj);
            break;
        }
    }*/

    public function errores()
    {
        return $this->dao->errores();
    }




    public function ListarPeriodosCerrar($c_local, $c_anho)
    {
        $sql = "SELECT c_ano,c_mes,flag_cierre_compras,flag_cierre_bancos,flag_cierre_contabilidad FROM periodos_local WHERE c_local='" . $c_local . "' and c_ano='" . $c_anho . "'";
      //  echo $sql;
        return $this->dao->consulta($sql);
    }


    public function ListarCompras($c_local)
    {
        $sql = "select cod_ano,cod_mes,count(*) cantidad,sum(total) total 
from Documentos_de_compras where c_local='" . $c_local . "' and flag='*' and flag_centralizado='&'
group by cod_ano,cod_mes";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarBancos($c_local)
    {
        $sql = "select cod_ano,cod_mes,count(*) cantidad,sum(monto) total 
from comprobantes_de_caja where c_local='" . $c_local . "' and flag='*' and flag_centralizado='&'
group by cod_ano,cod_mes
 order by cod_ano desc,cod_mes desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarVentas($c_local)
    {
        $sql = "select   YEAR(documentos_de_venta.fecha)AS cod_ano,month(documentos_de_venta.fecha) AS cod_mes,	documentos_de_venta.cod_documento,documentos_de_venta.num_documento,substring(CONVERT(CHAR(8), documentos_De_venta.fecha, 112),7,2)+'/'+substring(CONVERT(CHAR(8),documentos_De_venta.fecha, 112),5,2)+'/'+substring(CONVERT(CHAR(8), documentos_De_venta.fecha,112),1,4) as fecha,personas.nombre,personas.ruc,documentos_De_venta.total_original,
documentos_De_venta.observacion from Documentos_De_venta(nolock) 
inner join personas  (nolock) on personas.c_persona=documentos_De_venta.c_persona where documentos_de_venta.c_local='" . $c_local . "' and documentos_De_venta.cod_documento<>'rc'
and documentos_de_venta.flag_centralizado='&' and documentos_De_venta.flag='*'
order by YEAR(documentos_de_venta.fecha),month(documentos_de_venta.fecha),fecha";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function ListarPlanilla728($c_local, $c_anho)
    {
        $sql = "SELECT  CIAS.codcia,cias.nomcia, p.periodo, p.mes,P.plla_id,p.glosa FROM PLANILLA202609.dbo.PL_MOVPLA p (nolock)
 inner join PLANILLA202609.dbo.pf_cias cias (nolock) on cias.codcia = P.codcia  
 INNER JOIN periodos_local PL (nolock)ON PL.c_local=cias.codcia AND PL.c_ano=p.periodo AND PL.c_mes=p.mes AND PL.flag_cierre_contabilidad='&'
 WHERE p.codcia='" . $c_local . "' and isnull(p.flag,'&')<>'*' AND PERIODO='" . $c_anho . "'
 GROUP BY CIAS.codcia,cias.nomcia, p.periodo, p.mes,P.plla_id,p.glosa
 ORDER BY p.periodo, p.mes,P.plla_id";
        //echo $sql;
        return $this->dao->consulta($sql);
    }




    public function procesarCompras($cc_local, $anho, $periodo)
    {
        return $this->dao->procesarCompras($cc_local, $anho, $periodo);
    }

    public function procesarBancos($cc_local, $anho, $periodo)
    {
        return $this->dao->procesarBancos($cc_local, $anho, $periodo);
    }

    public function procesarVentas($cc_local, $anho, $periodo)
    {
        return $this->dao->procesarCaja($cc_local, $anho, $periodo);
    }

    public function procesarPlanilla728($cc_local, $anho, $periodo)
    {
        return $this->dao->procesarPlanilla728($cc_local, $anho, $periodo);
    }

    public function procesarCerrrar($cc_local, $anho, $periodo, $mod, $estado)
    {
        return $this->dao->procesarCerrrar($cc_local, $anho, $periodo, $mod, $estado);
    }
}
