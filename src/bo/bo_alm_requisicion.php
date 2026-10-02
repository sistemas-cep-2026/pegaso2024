<?php
require_once dirname(__DIR__) . '/dao/dao_alm_requisicion.php';
class bo_alm_requisicion
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_requisicion();
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    public function procesar(alm_requisicion $obj)
    {
        return $this->dao->procesar($obj);
    }

 

    public function listar(alm_requisicion $obj)
    {
        $sql = "  select g.cc_requisicion, dbo.fc_v1_fecha_hora(g.fecha) as fecha_text, g.cc_requisicion, 
         g.flag, dbo.fc_v1_parametro_valor('requisicion_de_compras','flag',g.flag) as flag_text,
  dbo.fc_fecha_texto(g.fecha) as fecha_mod_text,g.observacion
  FROM requisicion_de_compras g
        where g.cc_local='" . $obj->getCc_local() . "'";
        if (strlen($obj->getAnho()) > 0) {
            $sql .= " and year(g.fecha)='" . $obj->getAnho() . "'";
        }
        if (strlen($obj->getPeriodo()) > 0) {
            $sql .= " and month(g.fecha)='" . $obj->getPeriodo() . "'";
        }
        if (!empty($obj->getUser_crea())) {
            $sql .= " and g.user_crea='" . $obj->getUser_crea() . "'";
        }         
$sql.=" order by g.fecha desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listaID(alm_requisicion $obj)
    {
        $sql = "select  
 
    dbo.fc_v1_fecha_hora(fecha) fecha,observacion,rtrim(c_usuario) c_usuario, cc_local, c_area_adm,fecha_creacion,cc_requisicion ,flag, c_usuario_crea,
    dbo.fc_v1_parametro_valor('requisicion_de_compras','flag',flag) as flag_text
    from requisicion_de_compras
    where cc_requisicion='" . $obj->getCc_requisicion() . "'";
       // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function cabecera(alm_requisicion $obj)
    {
        $sql = "select dbo.fc_v1_fecha_hora(r.fecha) fecha,r.observacion,r.c_usuario,u.obs nombre_usuario,r.cc_local,r.c_area_adm,ad.nombre,r.flag ,r.c_usuario_crea,uc.obs nombre_crea,
        dbo.fc_v1_parametro_valor('requisicion_de_compras','flag',r.flag) as flag_text
from requisicion_de_compras r
left join seg_usuarios u on  u.usuario=r.c_usuario
left join seg_usuarios uc on  uc.usuario=r.c_usuario_crea
left join gen_area_adm ad on ad.cc_area_adm=r.c_area_adm
                where r.cc_requisicion=" . $obj->getCc_requisicion().";";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
       
}
