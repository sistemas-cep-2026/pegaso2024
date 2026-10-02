<?php
require_once(u_src() . "dao/dao_seg_permiso.php");
class bo_seg_permiso
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_seg_permiso();
    }

    public function actualizarPermisoModulo(seg_permiso $obj)
    {
        return $this->dao->actualizarPermisoModulo($obj);
    }



    public function listaUsuarioPermiso(seg_permiso $obj)
    {
        $sql = "SELECT * FROM seg_permiso
        WHERE cc_usuario = '{$obj->getCc_usuario()}'
        AND flag = 1";
        return $this->dao->consulta($sql);
    }

    public function listaUsuarioPermisoModulo(seg_permiso $obj)
    {
        $sql = "SELECT * FROM seg_permiso WHERE cc_usuario = '{$obj->getCc_usuario()}' and cc_mod = '{$obj->getCc_mod()}'";
        return $this->dao->consulta($sql);
    }

    public function listaPermisoModulo(seg_permiso $obj)
    {
        $sql = "SELECT * FROM seg_permiso 
        WHERE cc_usuario = '" . $obj->getCc_usuario() . "'
        and cc_modulo = '" . $obj->getCc_modulo() . "'
        AND flag = 1";
        return $this->dao->consulta($sql);
    }

    public function accesoMenuPrincipal($cc_usuario)
    {
        $sql = "SELECT l.c_local, l.nom_comercial,l.logo 
        FROM gen_local l INNER JOIN gen_usuario_local ul
        ON l.cc_local=ul.cc_local
        WHERE ul.cc_usuario='" . $cc_usuario . "'
        AND l.tipo_local='1'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function accesoMenuPrincipalSedes($cc_usuario)
    {
        $sql = "SELECT lolo.c_local, lolo.nom_comercial,lolo.logo
        FROM gen_usuario_local  l
        INNER JOIN gen_local lo ON lo.c_local=l.c_local
        inner JOIN gen_local lolo ON lo.tipo_local=lolo.c_local
        WHERE l.cc_usuario='" . $cc_usuario . "' 
        GROUP BY  lolo.c_local, lolo.nom_comercial,lolo.logo
        ORDER BY lolo.orden, lolo.cc_local, lolo.nom_comercial,lolo.logo; ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /*public function accesoMenuSecundario($cc_usuario)
    { //*menu secundario
        $sql = "SELECT l.cc_local,
        ul.cc_perfil,
        l.tipo_local,
        l.fecha_reg,
        l.razon_social,
        l.nom_comercial,
        l.ruc, 
        l.direccion,
        l.telefono,
        l.celular,
        l.email,
        l.web,
        l.logo,
        l.flag,
        l.orden,
        (SELECT lx.nom_comercial FROM gen_local lx WHERE lx.cc_local = l.tipo_local) AS nom_local
        FROM gen_local l INNER JOIN gen_usuario_local ul
        ON l.cc_local=ul.cc_local
        WHERE ul.cc_usuario='" . $cc_usuario . "'
        order by l.cc_local";
        return $this->dao->consulta($sql);
    }*/


    public function menupublic($cc_local)
    {
        $sql = "select cc_local,
        nombre,
        nombre_abv from gen_local where c_local='" . $cc_local . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    function __destruct()
    {
        $this->dao = FALSE;
    }
}
