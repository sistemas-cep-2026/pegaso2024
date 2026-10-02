<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos_modulo.php';
class bo_cap_eventos_modulo
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos_modulo();
    }

    public function control(cap_eventos_modulo $obj, $opc)
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

    public function listar(?cap_eventos_modulo $obj = null)
    {
        $sql = "SELECT
            cc_capmod,
            cc_evento,
            ct_modulo,
            flag
        FROM cap_eventos_modulo
        WHERE cc_evento = {$obj->getCc_evento()}
        ORDER BY cc_capmod";
        return $this->dao->consulta($sql);
    }

    public function listarID(?cap_eventos_modulo $obj = null)
    {
        $sql = "SELECT
            cc_capmod,
            cc_evento,
            ct_modulo,
            flag
        FROM cap_eventos_modulo
        WHERE cc_capmod = {$obj->getCc_capmod()}";
        return $this->dao->consulta($sql);
    }
}
