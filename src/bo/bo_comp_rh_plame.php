<?php
require_once dirname(__DIR__) . '/dao/dao_comp_rh_plame.php';
class bo_comp_rh_plame
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_comp_rh_plame();
    }

    public function control(comp_rh_plame $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "A":
                return $this->dao->modificar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(comp_rh_plame $obj = null)
    {
        if($obj->getC_local()=="28"){$c_local='%';} else {$c_local=$obj->getC_local();}

        $sql = "select c.cc_id,c.cod_anho,c.cod_mes,c.c_usuario, dbo.fc_fecha_texto_hora1(c.fecha_registro) as fecha_registro,
        c.c_persona,c.cod_documento,c.num_documento,c.monto,dbo.fc_fecha_texto(c.fecha_documento) as fecha_documento,
        dbo.fc_fecha_texto(c.fecha_pago) as fecha_pago,c.cuarta,c.flag,p.nombre,p.ruc,c.c_persona,p.ruc,c.c_local from comp_rh_plame c 
    inner join personas p on p.c_persona=c.c_persona
where c.c_local like '" . $c_local."'  and c.cod_anho='" . $obj->getCod_anho() . "' and c.cod_mes='" . $obj->getCod_mes() . "' order by c.c_local,p.ruc,c.monto desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(comp_rh_plame $obj = null)
    {
        $sql = "select c.cc_id,c.cod_anho,c.cod_mes,c.c_usuario, dbo.fc_fecha_texto(c.fecha_registro) as fecha_registro,
        c.c_persona,c.cod_documento,c.num_documento,c.monto,
         dbo.fc_fecha_from(c.fecha_documento) as fecha_documento,
          dbo.fc_fecha_from(c.fecha_pago) as fecha_pago,
      
        c.cuarta,c.flag,p.nombre,p.ruc,c.c_persona from comp_rh_plame c 
    inner join personas p on p.c_persona=c.c_persona where c.cc_id=" . $obj->getCc_id() . ";";
    //echo $sql;
        return $this->dao->consulta($sql);
    }
}
