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

    public function Recaudadora_Excelbbva(?recaud_excelbbva $obj = null)
    {

        $sql = "IF OBJECT_ID('dbo.recaud_excelbbva', 'U') IS NOT NULL
            select nombre,
            codigo,
            obs,
            imp1,
            imp2,
            oficina,
            mov,
            fecha_pago,
            fecha_proceso,
            forma_pago,
            canal
            FROM recaud_excelbbva";
        return $this->dao->consulta($sql);
    }
}
