<?php
require_once dirname(__DIR__) . '/dao/dao_teso_conciliacion_mensual.php';
class bo_teso_conciliacion_mensual
{
  private $dao;

  function __construct()
  {
    $this->dao = new dao_teso_conciliacion_mensual();
  }

  public function errores()
  {
    return $this->dao->errores();
  }

  public function procesar(?teso_conciliacion_mensual $obj = null)
  {
    return $this->dao->procesar($obj);
  }


  public function procesar_asiento(?teso_conciliacion_mensual $obj = null)
  {
    return $this->dao->procesar_asiento($obj);
  }

  public function ListarPeriodo(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT 
        cc_local, 
        cod_mes, 
        cod_anho, 
        regional,
        nacional, 
        cantidad,
        referencia,
        porcentaje,
        usuario,
        fecha2,
        usuario2,
        CASE entidad
        WHEN 'BBVA' THEN 'RECAUDO BBVA'
        WHEN 'BCP' THEN 'RECAUDO BCP'
        WHEN 'ESSALUD' THEN 'PLANILLA DE ESSALUD'
        WHEN 'CAJA' THEN 'CAJA CR'
        ELSE entidad
        END AS entidad_text,
         RTRIM(entidad) entidad,
         dbo.fc_v1_fecha_hora(fecha) fecha,periodo 
        FROM teso_conciliacion_mensual
        WHERE cod_anho = '{$obj->getCod_anho()}'
        AND cod_mes='{$obj->getCod_mes()}'
        and cc_local='{$obj->getCc_local()}'
        and flag<>'A'";
    //echo $sql;
    return $this->dao->consulta($sql);
  }

  public function ListarPeriodoTotalConcepto(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT
        RTRIM(entidad) entidad,
        SUM(regional) regional,
        SUM(nacional) nacional
        FROM teso_conciliacion_mensual
        WHERE cod_anho = '{$obj->getCod_anho()}'
        AND cod_mes = '{$obj->getCod_mes()}'
        AND cc_local = '{$obj->getCc_local()}'
        GROUP BY RTRIM(entidad)";
    //echo $sql;
    return $this->dao->consulta($sql);
  }

  public function ListarPeriodo_resumen(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT t.cc_local, t.cod_mes, t.cod_anho, sum(t.regional) regional, sum(t.nacional) nacional, t.porcentaje, 
CASE t.entidad WHEN 'BBVA' THEN 'RECAUDO BBVA' WHEN 'BCP' THEN 'RECAUDO BCP' WHEN 'ESSALUD' THEN 'PLANILLA DE ESSALUD' WHEN 'CAJA' THEN 'CAJA CR' ELSE t.entidad END AS entidad_text,
RTRIM(t.entidad) entidad, dbo.fc_v1_fecha_hora(t.fecha) fecha ,t.usuario, dbo.fc_v1_fecha_hora(t.fecha2) fecha2,t.usuario2 ,p.nombre ,
p2.nombre nombre2,a.nombre area1,a2.nombre area2,t.periodo
FROM teso_conciliacion_mensual t
left join seg_usuarios u on u.usuario=t.usuario
left join personas p on p.c_persona=u.cc_persona
left join gen_area_adm a on a.cc_area_adm=u.c_area
left join seg_usuarios u2 on u2.usuario=t.usuario2
left join personas p2 on p2.c_persona=u2.cc_persona
left join gen_area_adm a2 on a2.cc_area_adm=u2.c_area
        WHERE t.cod_anho  = '{$obj->getCod_anho()}' AND t.cod_mes='{$obj->getCod_mes()}' and t.cc_local='{$obj->getCc_local()}' and t.flag IN('*','F')
      group by t.cc_local, t.cod_mes, t.cod_anho, t.porcentaje, 
CASE t.entidad WHEN 'BBVA' THEN 'RECAUDO BBVA' WHEN 'BCP' THEN 'RECAUDO BCP' WHEN 'ESSALUD' THEN 'PLANILLA DE ESSALUD' WHEN 'CAJA' THEN 'CAJA CR' ELSE t.entidad END ,
RTRIM(t.entidad) , dbo.fc_v1_fecha_hora(t.fecha) ,t.usuario, dbo.fc_v1_fecha_hora(t.fecha2) ,t.usuario2,p.nombre ,p2.nombre,a.nombre,a2.nombre,t.periodo";
    // echo $sql;
    return $this->dao->consulta($sql);
  }

  public function ListarPeriodo_resumen_pend(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT t.cc_local, t.cod_mes, t.cod_anho, sum(t.regional) regional, sum(t.nacional) nacional, t.porcentaje, 
CASE t.entidad WHEN 'BBVA' THEN 'RECAUDO BBVA' WHEN 'BCP' THEN 'RECAUDO BCP' WHEN 'ESSALUD' THEN 'PLANILLA DE ESSALUD' WHEN 'CAJA' THEN 'CAJA CR' ELSE t.entidad END AS entidad_text,
RTRIM(t.entidad) entidad, dbo.fc_v1_fecha_hora(t.fecha) fecha ,t.usuario, dbo.fc_v1_fecha_hora(t.fecha2) fecha2,t.usuario2 ,p.nombre ,
p2.nombre nombre2,a.nombre area1,a2.nombre area2,t.periodo
FROM teso_conciliacion_mensual t
left join seg_usuarios u on u.usuario=t.usuario
left join personas p on p.c_persona=u.cc_persona
left join gen_area_adm a on a.cc_area_adm=u.c_area
left join seg_usuarios u2 on u2.usuario=t.usuario2
left join personas p2 on p2.c_persona=u2.cc_persona
left join gen_area_adm a2 on a2.cc_area_adm=u2.c_area
        WHERE   t.cc_local='{$obj->getCc_local()}' and t.flag IN('*','F') and t.periodo='*PEND*'
        and t.cod_anho+t.cod_mes<=abs({$obj->getCod_anho()}{$obj->getCod_mes()})
      group by t.cc_local, t.cod_mes, t.cod_anho, t.porcentaje, 
CASE t.entidad WHEN 'BBVA' THEN 'RECAUDO BBVA' WHEN 'BCP' THEN 'RECAUDO BCP' WHEN 'ESSALUD' THEN 'PLANILLA DE ESSALUD' WHEN 'CAJA' THEN 'CAJA CR' ELSE t.entidad END ,
RTRIM(t.entidad) , dbo.fc_v1_fecha_hora(t.fecha) ,t.usuario, dbo.fc_v1_fecha_hora(t.fecha2) ,t.usuario2,p.nombre ,p2.nombre,a.nombre,a2.nombre,t.periodo";
    //echo $sql;
    return $this->dao->consulta($sql);
  }

  public function ListarPeriodo_resumen_cdn(?teso_conciliacion_mensual $obj = null)
  {
    $sql = " 
SELECT 
  sum(t.regional) monto  
FROM teso_conciliacion_mensual t
      WHERE t.cod_anho  = '{$obj->getCod_anho()}' AND t.cod_mes='{$obj->getCod_mes()}' and t.cc_local='{$obj->getCc_local()}' and t.flag IN('*','F')
		and t.periodo=t.cod_anho+t.cod_mes  and RTRIM(t.entidad)<>'CAJA'
      group by    
   t.periodo
   	   union all
SELECT 
  sum(t.NACIONAL)*-1 monto 
FROM teso_conciliacion_mensual t
      WHERE t.cod_anho  = '{$obj->getCod_anho()}' AND t.cod_mes='{$obj->getCod_mes()}' and t.cc_local='{$obj->getCc_local()}' and t.flag IN('*','F')
		and t.periodo=t.cod_anho+t.cod_mes  and RTRIM(t.entidad)='CAJA'
      group by    
   t.periodo";
    //echo $sql;
    return $this->dao->consulta($sql);
  }

  public function ListarPeriodoReporte(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT l.c_local, 
        l.nombre AS c_local_text, 
          l.nombre_abv AS c_local_text1,
        t.usuario, 
        dbo.fc_fecha_texto(t.fecha) AS fecha, 
        t.usuario2 AS usuario2, 
        dbo.fc_fecha_texto(t.fecha2) AS fecha2, 
        l.porc_cotizacion,
        (SELECT SUM(tt.regional) FROM teso_conciliacion_mensual tt WHERE tt.entidad <> 'CAJA' AND tt.flag IN ('*','F') AND tt.cod_anho = '{$obj->getCod_anho()}' AND tt.cod_mes = '{$obj->getCod_mes()}' AND tt.cc_local = l.c_local) AS nacional,
        (SELECT SUM(tt.nacional) FROM teso_conciliacion_mensual tt WHERE tt.entidad = 'CAJA'  AND tt.flag IN ('*','F') AND tt.cod_anho = '{$obj->getCod_anho()}' AND tt.cod_mes = '{$obj->getCod_mes()}' AND tt.cc_local = l.c_local) AS regional,
        (CASE WHEN EXISTS (SELECT 1 FROM teso_conciliacion_mensual_transferencia tr
                    WHERE tr.cc_local = l.c_local 
                    AND tr.cod_anho = '{$obj->getCod_anho()}' 
                    AND tr.cod_mes = '{$obj->getCod_mes()}'
                )
                THEN 1
                ELSE 0
            END
        ) AS n
        FROM gen_local l (NOLOCK)LEFT JOIN teso_conciliacion_mensual t 
        ON t.cc_local = l.c_local 
        AND t.cod_anho = '{$obj->getCod_anho()}' 
        AND t.cod_mes = '{$obj->getCod_mes()}' 
        AND t.flag IN ('*','F') 
        WHERE  ISNUMERIC(l.c_local) = 1 
        AND l.flag_administrativo = '*' 
        AND (l.c_local BETWEEN 1 AND 27 OR l.c_local = 58) 
        GROUP BY l.c_local, l.nombre, l.nombre_abv, t.usuario, t.usuario2, 
        t.fecha, t.fecha2, l.porc_cotizacion 
        ORDER BY l.c_local";
    //echo $sql;
    return $this->dao->consulta($sql);
  }

  public function ListarPeriodoReporte_cr(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT t.cod_anho,t.cod_mes,l.c_local,  
        l.nombre_abv AS c_local_text1, t.usuario, dbo.fc_fecha_texto(t.fecha) AS fecha,
  l.porc_cotizacion,
tra.banco_cuenta,tra.vnop
,dbo.fc_fecha_texto(tra.vfecha) AS vfecha
,tra.vmonto,cast(tra.obs as char(200)) obs,tra.user_crea,tra.flag 
FROM gen_local l (NOLOCK) 
LEFT JOIN teso_conciliacion_mensual t ON t.cc_local = l.c_local AND t.cod_anho = '{$obj->getCod_anho()}'  AND t.flag IN ('*','F') 
inner join teso_conciliacion_mensual_transferencia tra on tra.cc_local=t.cc_local and tra.cod_anho=t.cod_anho and tra.cod_mes=t.cod_mes 
WHERE ISNUMERIC(l.c_local) = 1 AND l.flag_administrativo = '*' AND (l.c_local='{$obj->getCc_local()}'  ) 
GROUP by  t.cod_anho,t.cod_mes,l.c_local,  
        l.nombre_abv  , t.usuario, dbo.fc_fecha_texto(t.fecha) ,
  l.porc_cotizacion,
tra.banco_cuenta,tra.vnop
,dbo.fc_fecha_texto(tra.vfecha) 
,tra.vmonto,cast(tra.obs as char(200))  ,tra.user_crea,tra.flag 
 ORDER by t.cod_anho,t.cod_mes,l.c_local";
    //echo $sql;
    return $this->dao->consulta($sql);
  }


  public function ListarPeriodoReporte_dif_caja(?teso_conciliacion_mensual $obj = null)
  {
    $sql = " select D.c_local, sum(I.precio* I.cantidad ) as total 
from items_documentos_de_venta I (nolock) 
inner join documentos_de_venta D (nolock) on ( I.cod_documento = D.cod_documento and I.num_documento = D.num_documento )
inner join articulos A (nolock) on ( I.c_articulo = A.c_articulo )
where MONTH(D.fecha)='{$obj->getCod_mes()}'  and YEAR(fecha)='{$obj->getCod_anho()}' 
 AND A.c_cuenta_ventas='7042120001' 
 and d.c_local='{$obj->getCc_local()}' 
group by  D.c_local,a.c_cuenta_ventas 
   ";
    //echo $sql;
    return $this->dao->consulta($sql);
  }
  public function ListarPeriodoReporte_dif_liq(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "  
select t.cc_local,(t.regional+t.nacional) as total 
from teso_conciliacion_mensual t where entidad='CAJA'
 AND t.cc_local='{$obj->getCc_local()}' and t.cod_mes='{$obj->getCod_mes()}'  and t.cod_anho='{$obj->getCod_anho()}' and t.flag<>'A' ";
    //echo $sql;
    return $this->dao->consulta($sql);
  }
  public function ListarPeriodoAsientos(?teso_conciliacion_mensual $obj = null)
  {
    $sql = "SELECT t.cc_local, l.nombre,
    SUM(CASE WHEN t.entidad = 'BBVA' THEN t.regional ELSE 0 END) AS bbva_reg,
    SUM(CASE WHEN t.entidad = 'BBVA' THEN t.nacional ELSE 0 END) AS bbva_nac,
    SUM(CASE WHEN t.entidad = 'BCP' THEN t.regional ELSE 0 END) AS bcp_reg,
    SUM(CASE WHEN t.entidad = 'BCP' THEN t.nacional ELSE 0 END) AS bcp_nac,
    SUM(CASE WHEN t.entidad = 'CAJA' THEN t.regional ELSE 0 END) AS caja_reg,
    SUM(CASE WHEN t.entidad = 'CAJA' THEN t.nacional ELSE 0 END) AS caja_nac,
    SUM(CASE WHEN t.entidad = 'ESSALUD' THEN t.regional ELSE 0 END) AS essalud_reg,
    SUM(CASE WHEN t.entidad = 'ESSALUD' THEN t.nacional ELSE 0 END) AS essalud_nac,
    t.asiento
FROM teso_conciliacion_mensual t inner join gen_local l
on t.cc_local=l.c_local
WHERE t.cod_mes = '{$obj->getCod_mes()}'
  AND t.cod_anho = '{$obj->getCod_anho()}'
GROUP BY t.cc_local, l.nombre,t.asiento";
    return $this->dao->consulta($sql);
  }
}
