<?php
require_once dirname(__DIR__) . '/dao/dao_banc_excel_migrar.php';
class bo_banc_excel_migrar
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_excel_migrar();
    }

    public function errores()
    {
        return $this->dao->errores();
    }
    public function control(banc_excel_migrar $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "P":
                return $this->dao->procesar($obj);
                break;
            case "L":
                return $this->dao->limpiar($obj);
                break;
        }
    }



    public function listar()
    {
        $sql = "SELECT id, 
                    dbo.fc_v1_fecha_texto(fecha) fecha, 
                    numero_operacion, 
                    monto, 
                    referencia01, 
                    referencia02, 
                    cuenta_contable, 
                    banco, 
                    cuenta_bancaria, 
                    c_banco, 
                    num_banco
                FROM banc_excel_migrar
                ORDER BY id ASC";

        return $this->dao->consulta($sql);
    }

    public function cantidad()
    {
        $sql = "SELECT COUNT(*) as cantidad FROM banc_excel_migrar";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?banc_excel_migrar $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
