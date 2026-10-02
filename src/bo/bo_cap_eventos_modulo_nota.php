<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos_modulo_nota.php';
class bo_cap_eventos_modulo_nota
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos_modulo_nota();
    }

    public function control(cap_eventos_modulo_nota $obj, $opc)
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

    public function validar(?cap_eventos_modulo_nota $obj = null)
    {
        $sql = "SELECT cc_modnota
        FROM cap_eventos_modulo_nota
        WHERE cc_evento_mat = {$obj->getCc_evento_mat()}";
        return $this->dao->consulta($sql);
    }

    public function listarID(?cap_eventos_modulo_nota $obj = null)
    {
        $sql = "SELECT
            cc_modnota,
            cc_capmod,
            cc_evento_mat,
            nota
        FROM cap_eventos_modulo_nota
        WHERE cc_evento_mat = {$obj->getCc_evento_mat()}";
        return $this->dao->consulta($sql);
    }
}
