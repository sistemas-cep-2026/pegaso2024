<?php
require_once dirname(__DIR__) . '/dao/dao_banc_dietas_detalles.php';
class bo_banc_dietas_detalles
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_dietas_detalles();
    }

    public function control(banc_dietas_detalles $obj, $opc)
    {
        switch ($opc) {

            case "U":
                return $this->dao->modificar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(banc_dietas_detalles $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(?banc_dietas_detalles $obj = null)
    {
        $sql = "
SELECT 
    CASE 
        WHEN concepto = 1 THEN 'DIETAS'
        WHEN concepto = 2 THEN 'REFRIGERIO – MOVILIDAD Y REPRESENTACION'
        ELSE concepto
        END AS concepto_texto,concepto,
        renta_bruta,
        retencion,
        neto,cc_dietas,cc_dietas_detalles
        FROM banc_dietas_detalles
        where cc_dietas='{$obj->getCc_dietas()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
