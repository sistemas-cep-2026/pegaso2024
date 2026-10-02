<?php
require_once dirname(__DIR__) . '/dao/dao_alm_guias_de_entrada.php';
class bo_alm_guias_de_entrada
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_guias_de_entrada();
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    public function procesar(alm_guias_de_entrada $obj)
    {
        return $this->dao->procesar($obj);
    }
    
    public function listarRequisciones($cc_local){
     
        $sql = "select top 30 * 
        FROM requisicion_de_compras 
        WHERE cc_local='".$cc_local."' order by fecha desc;";    
        return $this->dao->consulta($sql);
    }

    public function listar(alm_guias_de_entrada $obj)
    {
        $sql = "select g.cc_guia, dbo.fc_v1_fecha_hora(g.fecha) as fecha, g.flag, 
        dbo.fc_v1_parametro_valor('guias_de_entrada','flag',g.flag) as flag_text,
        g.observacion ,g.cod_documento,g.num_documento,g.c_persona,g.cc_requisicion,p.nombre,p.ruc
        FROM guias_de_entrada g 
        left join personas p on p.c_persona=g.c_persona
        where g.cc_local='" . $obj->getCc_local() . "'";
        if (strlen($obj->getAnho()) > 0) {
            $sql .= " and year(g.fecha)='" . $obj->getAnho() . "'";
        }
        if (strlen($obj->getPeriodo()) > 0) {
            $sql .= " and month(g.fecha)='" . $obj->getPeriodo() . "'";
        }
        $sql.=" order by g.fecha desc";

      //  echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listaID(alm_guias_de_entrada $obj)
    {
        $sql = "select 
        dbo.fc_fecha_texto(g.fecha) as fecha,
        g.observacion,rtrim(g.cc_usuario) c_usuario,
        g.cc_local, 
        g.cc_guia,
        g.flag, 
        g.c_persona,
        g.cod_documento,
        g.num_documento,
        dbo.fc_v1_parametro_valor('guias_de_entrada','flag',g.flag) as flag_text,
        p.nombre,
        p.ruc,
        g.cc_requisicion
        from guias_de_entrada g left join personas p on p.c_persona=g.c_persona
        where g.cc_guia ='" . $obj->getCc_guia() . "'";
       // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function cabecera(alm_guias_de_entrada $obj)
    {
        $sql = "select dbo.fc_v1_fecha_hora(r.fecha) fecha,
        r.observacion,
        r.cc_usuario,
        u.obs nombre_usuario,
        r.cc_local,r.flag , 
        uc.obs nombre_crea ,
        dbo.fc_v1_parametro_valor('guias_de_entrada','flag',r.flag) as flag_text,
        p.ruc,p.nombre,
        r.cod_documento,
        r.num_documento,
        r.cc_requisicion
        from guias_de_entrada r left join seg_usuarios u 
        on u.usuario=r.cc_usuario
        left join seg_usuarios uc on uc.usuario=r.cc_usuario 
        left join Personas p on p.c_persona=r.c_persona
        where r.cc_guia =" . $obj->getCc_guia().";";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    


    
}
