<?php
require_once dirname(__DIR__) . '/dao/dao_gen_periodos.php';
class bo_gen_periodos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_periodos();
    }

    public function control(gen_periodos $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "E":
                return $this->dao->eliminar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listarPeriodos(gen_periodos $obj = null)
    {
        $sql = "select RIGHT('00' + CAST(c_mes AS varchar(2)), 2) + '/' + CAST(c_ano AS char(4)) AS periodo
    FROM PERIODOS WITH (NOLOCK)
    WHERE ISNUMERIC(c_mes) = 1
    AND ISNUMERIC(c_ano) = 1
    AND CAST(c_mes AS int) BETWEEN 1 AND 12
    AND (CAST(c_ano AS int) * 100 + CAST(c_mes AS int))
    BETWEEN 200812 AND (YEAR(GETDATE()) * 100 + MONTH(GETDATE()))
    ORDER BY CAST(c_ano AS int) DESC, 
    CAST(c_mes AS int) DESC;";
        return $this->dao->consulta($sql);
    }

    public function listarID(gen_periodos $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
