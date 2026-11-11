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

 public function procesarCompras($cc_local, $anho, $periodo)
    {
        return $this->dao->procesarCompras($cc_local, $anho, $periodo);
    }

public function procesarBancos($cc_local, $anho, $periodo)
    {
        return $this->dao->procesarBancos($cc_local, $anho, $periodo);
    }

    }