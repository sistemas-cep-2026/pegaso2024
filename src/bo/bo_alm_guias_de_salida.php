<?php
require_once dirname(__DIR__) . '/dao/dao_alm_guias_de_salida.php';
class bo_alm_guias_de_salida
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_alm_guias_de_salida();
    }

    public function errores()
    {
        return $this->conecta->errores();
    }
    /**************actuializa kardex************************/
    public function consumos_mensual(alm_guias_de_salida $obj)
    {
        return $this->dao->consumos_mensual($obj);
    }

    /**************fin actuializa kardex************************/

    public function procesar(alm_guias_de_salida $obj)
    {
        return $this->dao->procesar($obj);
    }


    public function listar(?alm_guias_de_salida $obj = null)
    {
        $sql = "select g.cc_guia, dbo.fc_v1_fecha_hora(g.fecha) as fecha_text, 
g.flag,
dbo.fc_v1_parametro_valor('guias_de_salida','flag',g.flag) as flag_text, 
dbo.fc_fecha_texto(g.fecha_kardex) as fecha_mod_text,
g.justificacion ,p.nombre
FROM guias_de_salida g 
left join seg_usuarios u  on u.usuario=g.user_crea
left join personas p on p.c_persona=u.cc_persona
 where g.c_local='" . $obj->getC_local() . "'";
        if (strlen($obj->getAnho()) > 0) {
            $sql .= " and year(g.fecha)='" . $obj->getAnho() . "'";
        }
        if (strlen($obj->getPeriodo()) > 0) {
            $sql .= " and MONTH(g.fecha)='" . $obj->getPeriodo() . "'";
        }
        if (!empty($obj->getUser_crea())) {
            $sql .= " and g.user_crea='" . $obj->getUser_crea() . "'";
        }

        if ((!empty($obj->getDesde())) and (!empty($obj->getHasta()))) {
            $sql .= " and g.fecha BETWEEN '" . $obj->getDesde() . "' and '" . $obj->getHasta() . " 23:59:59'";
        }
        $sql .= "order by g.fecha desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listaID(?alm_guias_de_salida $obj = null)
    {
        $sql = "select cc_guia, c_local, c_area_adm,
fecha, dbo.fc_v1_fecha_hora(fecha) fecha_text,
flag, justificacion,
rtrim(user_crea) user_crea, fech_crea, 

dbo.fc_v1_parametro_valor('guias_de_salida','flag',flag) as flag_text from guias_de_salida where cc_guia='" . $obj->getCc_guia() . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarKardexArticulo(?alm_guias_de_salida $obj = null)
    {

        $sql = "SELECT Kardex.cod_tipo,  DBO.fc_fecha_texto_hora1(Kardex.fecha) as fecha1,
  Items_Kardex.c_articulo, Items_Kardex.cod_incremento_decremento, Items_Kardex.saldo, 
 Items_Kardex.cantidad, 
 
  kardex.cc_guia,Kardex.usu_crea,Kardex.obs, DBO.fc_fecha_texto_hora1(Kardex.fecha_doc) fecha_doc
FROM Kardex (nolock) 
inner join Items_Kardex (nolock) on kardex.cc_guia=Items_Kardex.cc_guia and kardex.cod_tipo=items_kardex.cod_tipo
INNER JOIN gen_articulos (nolock) ON gen_articulos.c_articulo=Items_Kardex.c_articulo

WHERE
    ( Kardex.fecha between '" . $obj->getDesde() . "' AND '" . $obj->getHasta() . " 23:59:59' ) AND  
      ( Kardex.cc_local = '" . $obj->getC_local() . "' ) AND
      (Items_Kardex.c_articulo like RIGHT(REPLICATE('0', 18) + CAST(RTRIM('" . $obj->getC_articulo() . "') AS VARCHAR(18)), 18) )   
      order by kardex.fecha";
        //  echo $sql;
        return $this->dao->consulta($sql);
    }

    public function rep_vale_cabec($cc_guia)
    {
        $sql = "select g.cc_guia,  dbo.fc_v1_fecha_hora(g.fecha) fecha,   g.c_local, g.user_crea as usuario, g.flag, rtrim(p.nombre) as solicitante, g.justificacion, 
l.nombre as entidad, g.c_area_adm, a.nombre as area_text , 
dbo.fc_v1_parametro_valor('guias_de_salida','flag',g.flag) as flag_text 
from guias_de_salida g (nolock)
inner join gen_local l (nolock) on l.c_local=g.c_local 
INNER JOIN gen_area_adm a (NOLOCK) ON a.cc_area_adm=g.c_area_adm 
left join seg_usuarios u  on u.usuario=g.user_crea
left join personas p on p.c_persona=u.cc_persona where g.cc_guia='" . $cc_guia . "'";
        
        return $this->dao->consulta($sql);
    }

    public function articulo_familia($cc_local, $periodo, $anho)
    {
        $sql = "select c_sub_familia,
    nombre_familia 
    from alm_consumo_mensual (nolock) 
    where c_local='" . $cc_local . "'  
    and c_mes='" . $periodo . "'  
    and c_year='" . $anho . "'  
    group by  c_sub_familia,nombre_familia
    order by nombre_familia";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function consumos_mensual_data($cc_local, $periodo, $anho)
    {
        $sql = " select c_articulo,
    nombre,
    bi,
    ti,
    tg,
    sf,presentacion,c_sub_familia,nombre_familia
    from alm_consumo_mensual  (nolock)  
    where c_local='" . $cc_local . "'  
    and c_mes='" . $periodo . "' 
    and c_year='" . $anho . "' 
    and ((bi+ti+tg+sf)<>0)   /* and sf>0 */
    
    order by nombre_familia,nombre  ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
