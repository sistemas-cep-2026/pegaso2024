<?php
require_once dirname(__DIR__) . '/dao/dao_gen_entidad_pagadora.php';
class bo_gen_entidad_pagadora
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_entidad_pagadora();
    }

    public function control(gen_entidad_pagadora $obj, $opc)
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

    public function listar(?gen_entidad_pagadora $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(?gen_entidad_pagadora $obj = null)
    {
        $sql = "select c_entidad_pagadora, 
        rtrim(nombre) nombre_entidad 
        from entidad_pagadora
        where c_entidad_pagadora='{$obj->getC_entidad_pagadora()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarIDLocal(?gen_entidad_pagadora $obj = null)
    {
        $sql = "select c_entidad_pagadora, 
        rtrim(nombre) nombre_entidad 
        from entidad_pagadora
        where c_local='{$obj->getC_local()}'";
        echo $sql;
        return $this->dao->consulta($sql);
    }
}
