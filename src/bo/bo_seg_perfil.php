<?php
require_once dirname(__DIR__) . '/dao/dao_seg_perfil.php';
class bo_seg_perfil
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_seg_perfil();
    }

    public function control(seg_perfil $obj, $opc)
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

    public function listar(seg_perfil $obj = null)
    {
        $sql = "select rtrim(cc_perfil) as cc_perfil,
        ct_perfil,
        flag,
        dbo.fc_parametro_valor('seg_perfil','flag',flag) as flag_text 
        from seg_perfil
        where flag='".$obj->getFlag()."'";
        $sql.=" order by ct_perfil";
       // echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarId($cc_perfil)
    {
        $sql = "select 
        cc_perfil,
        ct_perfil,
        cc_modulo_defecto,
        flag
        FROM seg_perfil
        WHERE cc_perfil='" . $cc_perfil . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    
    public function listarContar(seg_perfil $obj = null)
    {
        $sql = "select a.cc_perfil, a.ct_perfil,
        a.flag,
        (select count(cc_modulo) from seg_modulo_perfil where seg_modulo_perfil.cc_perfil=a.cc_perfil ) as cantidad 
        FROM seg_perfil a WHERE a.cc_perfil LIKE '%%' 
        order by a.ct_perfil";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

}