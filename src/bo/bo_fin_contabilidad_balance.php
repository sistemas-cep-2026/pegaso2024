<?php
require_once dirname(__DIR__) . '/dao/dao_fin_contabilidad_balance.php';
class bo_fin_contabilidad_balance
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_contabilidad_balance();
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

    public function EjecutaBalanceComprobacion(fin_contabilidad_balance $obj = null)
    {
       return $this->dao->ProcesarBalanceComprobacion($obj);
   }

   public function BalanceComprobacion(fin_contabilidad_balance $obj = null)
   {
    $sql = "select cuenta, 
    nombre,
    debe,haber,
    deudor,
    acreedor,
    activo,
    pasivo,
    nperdida,
    nganancia,fperdida,fganancia,
    local,dig,
    c_year,desde,hasta,origen 
    from final_bc (NOLOCK)
    where local= '".$obj->getCc_local()."' 
    and dig='".$obj->getDigitos()."' 
    and c_year='".$obj->getAnho()."' 
    and desde='".$obj->getDesde()."' 
    and hasta='".$obj->getHasta()."' 
    order by cuenta";
        //echo $sql;
    return $this->dao->consulta($sql);
}

public function TotalesBalanceComprobacion(fin_contabilidad_balance $obj = null){
    $sql="select 
    SUM(debe) AS total_debe,
    SUM(haber) AS total_haber,
    SUM(deudor) AS total_deudor,
    SUM(acreedor) AS total_acreedor,
    SUM(activo) AS total_activo,
    SUM(pasivo) AS total_pasivo,
    SUM(nperdida) AS total_nperdida,
    SUM(nganancia) AS total_nganancia,
    SUM(fperdida) AS total_fperdida,
    SUM(fganancia) AS total_fganancia
    FROM 
    final_bc (NOLOCK)
    WHERE local= '".$obj->getCc_local()."' 
    and dig='".$obj->getDigitos()."' 
    and c_year='".$obj->getAnho()."' 
    and desde='".$obj->getDesde()."' 
    and hasta='".$obj->getHasta()."'";
    //echo $sql;
    return $this->dao->consulta($sql);
}






}
