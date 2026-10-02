<?php
require_once dirname(__DIR__) . '/dao/dao_seg_pagina.php';
class bo_seg_pagina
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_seg_pagina();
    }

    public function control(seg_pagina $obj, $opc)
    {
        switch($opc){
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

    public function listar(seg_pagina $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(seg_pagina $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

}