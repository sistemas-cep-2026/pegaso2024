<?php
require_once dirname(__DIR__) . '/dao/dao_contabilidad_libros.php';
class bo_contabilidad_libros
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_contabilidad_libros();
    }

    /*public function control(cont_asistencia $obj, $opc)
    {
        switch($opc){
            case "I":
            return $this->dao->insertar($obj);
            break;
            case "U":
            return $this->dao->modificar($obj);
            break;
            case "A":
            return $this->dao->anular($obj);
            break;
        }
    }*/

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listarCompras($cc_local, $anho, $periodo, $tipo)
    {
        if ($tipo == 'CP') {
            $sql = " SELECT  substring('" . $anho . "',1,4) + '-'+ '" . $periodo . "' as comprobante,                                             
                dbo.fc_fecha_texto(dd.fecha_documento) as fecha_documento,                         
                (CASE WHEN dd.fecha_de_cancelacion is null  THEN dbo.fc_fecha_texto(dd.fecha_documento)  ELSE dbo.fc_fecha_texto(dd.fecha_de_cancelacion)     END) as fecha_de_pago,    
                (case v.cod_documento when 'FP' THEN '1'  when 'FE' THEN '1'  WHEN 'RH' THEN '2' WHEN 'BP' THEN '3' ELSE '0' END ) AS cod_documento,          
                v.num_documento,                       
                (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN '1' ELSE '6' END )As tipo_doc,                      
                (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN personas.num_documento ELSE PERSONAS.RUC END )As num_doc,                      
                substring(v.cod_documento+'**'+Personas.nombre,1,30) as nombre,                         
                iv.haber as valor_venta,                         
                0 AS IGV,                  
                0.0 as agdo2_bi,                      
                0.0 as agdo2_igv,                      
                0.0 as agdo3_bi,                      
                0.0 as agdo3_igv,                       
                0.0 as vdlang,                       
                0 as otyc,                       
                0 + iv.haber AS total_original,                       
                0  as detraccion,                     
                dbo.fc_fecha_texto(v.fecha) as fecha_detraccion,                
                v.tipo_de_cambio   
                , v.cod_mes_contable as cod_mes                 
                FROM voucher v (nolock)       
                inner join items_voucher iv on iv.numero=v.numero     and iv.c_cuenta='4212100001'    
                INNER JOIN   Personas (nolock) ON PERSONAS.C_PERSONA=v.C_PERSONA                         
                INNER JOIN TIPO_DE_DOCUMENTOS td on td.c_tipo_de_documento=v.cod_documento        
                left join Documentos_de_compras dd on v.numero=dd.voucher    
                WHERE   v.cod_mes_contable= '" . $periodo . "'  AND                        
                ( v.ano_contable = '" . $anho . "' ) AND                        
                (v.c_local = '" . $cc_local . "' )                        
                and v.flag ='*'                      
                and td.reg_compras='*'       
                and iv.debe=0      
                and iv.c_cuenta='4212100001'      
                and v.cod_documento<>'RS'    

                UNION ALL    
                SELECT                         
                substring('" . $anho . "',1,4) + '-'+ '" . $periodo . "' as comprobante,   
                dbo.fc_fecha_texto(dd.fecha_documento) as fecha_documento,                         
                (CASE WHEN dd.fecha_de_cancelacion  < dd.fecha_vencimiento  THEN dbo.fc_fecha_texto(dd.fecha_de_cancelacion)        ELSE dbo.fc_fecha_texto(dd.fecha_vencimiento)     END) as fecha_de_pago,      
                (case v.cod_documento when 'FP' THEN '1'   when 'FE' THEN '1' WHEN 'RH' THEN '2' WHEN 'BP' THEN '3' ELSE '0' END ) AS cod_documento,          
                v.num_documento,               
                (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN '1' ELSE '6' END )As tipo_doc,                      
                (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN personas.num_documento ELSE PERSONAS.RUC END )As num_doc,                      
                substring(v.cod_documento+'*'+Personas.nombre,1,30) as nombre,                         
                iv.haber as valor_venta,                         
                0 AS IGV,                  
                0.0 as agdo2_bi,                      
                0.0 as agdo2_igv,                      
                0.0 as agdo3_bi,                      
                0.0 as agdo3_igv,                       
                0.0 as vdlang,                       
                0 as otyc,                       
                0 + iv.haber AS total_original,                       
                0  as detraccion,             
                dbo.fc_fecha_texto(v.fecha) as fecha_detraccion,                     
                v.tipo_de_cambio    
                , v.cod_mes_contable as cod_mes                 
                FROM voucher v (nolock)       
                inner join items_voucher iv on iv.numero=v.numero     and v.cod_documento='RS'    
                INNER JOIN   Personas (nolock) ON PERSONAS.C_PERSONA=v.C_PERSONA                         
                INNER JOIN TIPO_DE_DOCUMENTOS td on td.c_tipo_de_documento=v.cod_documento        
                left join Documentos_de_compras dd on v.numero=dd.voucher    
                WHERE   v.cod_mes_contable= '" . $periodo . "'  AND                        
                ( v.ano_contable = '" . $anho . "' ) AND                        
                (v.c_local = '" . $cc_local . "' )                         
                and v.flag='*'                     
                and td.reg_compras='*'       
                and iv.debe=0      
                and iv.c_cuenta='4212100001'      
                and v.cod_documento='RS'    
                order by iv.haber ";
            } else {
                $sql = " SELECT  substring('" . $anho . "',1,4) + '-'+ '" . $periodo . "' as comprobante,                                             
                    dbo.fc_fecha_texto(dd.fecha_documento) as fecha_documento,                         
                    (CASE WHEN dd.fecha_de_cancelacion is null  THEN dbo.fc_fecha_texto(dd.fecha_documento)  ELSE dbo.fc_fecha_texto(dd.fecha_de_cancelacion)     END) as fecha_de_pago,    
                    (case v.cod_documento when 'FP' THEN '1'  when 'FE' THEN '1'  WHEN 'RH' THEN '2' WHEN 'BP' THEN '3' ELSE '0' END ) AS cod_documento,          
                    v.num_documento,                       
                    (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN '1' ELSE '6' END )As tipo_doc,                      
                    (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN personas.num_documento ELSE PERSONAS.RUC END )As num_doc,                      
                    substring(v.cod_documento+'*'+Personas.nombre,1,30) as nombre,                         
                    iv.haber as valor_venta,                         
                    0 AS IGV,                  
                    0.0 as agdo2_bi,                      
                    0.0 as agdo2_igv,                      
                    0.0 as agdo3_bi,                      
                    0.0 as agdo3_igv,                       
                    0.0 as vdlang,                       
                    (select sum(ivv.haber) from items_voucher ivv where c_cuenta='4017200001' and ivv.numero=v.numero)as otyc,                       
                    0 + iv.haber AS total_original,                       
                    0  as detraccion,                     
                    dbo.fc_fecha_texto(v.fecha) as fecha_detraccion,                
                    v.tipo_de_cambio   
                    , v.cod_mes_contable as cod_mes                 
                    FROM voucher v (nolock)       
                    inner join items_voucher iv on iv.numero=v.numero     and iv.c_cuenta='4690000006'    
                    INNER JOIN   Personas (nolock) ON PERSONAS.C_PERSONA=v.C_PERSONA                         
                    INNER JOIN TIPO_DE_DOCUMENTOS td on td.c_tipo_de_documento=v.cod_documento        
                    left join Documentos_de_compras dd on v.numero=dd.voucher    
                    WHERE   v.cod_mes_contable= '" . $periodo . "'  AND                        
                    ( v.ano_contable = '" . $anho . "' ) AND                        
                    (v.c_local = '" . $cc_local . "' )                        
                    and v.flag ='*'                      
                    and iv.debe=0      
                    and iv.c_cuenta='4690000006'      
                    and v.cod_documento='RH' 
                    ORDER BY dd.fecha_documento";
                }
        //echo $sql;

                return $this->dao->consulta($sql);
            }


            /**************Libro diario***********/


            public function ListarLibroDiario($cc_local, $anho, $periodo)
            {


                $sql = "WITH ObservacionCalculada AS ( SELECT V.cod_mes_contable, V.numero, dbo.fc_fecha_texto(V.fecha) AS fecha, V.c_subdiario, CAST(V.observacion AS NVARCHAR(MAX)) AS observacion, 

                  V.voucher, V.cod_documento, V.num_documento, S.codigo_sunat8, S.nombre AS sub_nombre, t8.descripcion AS sunat_descripcion,
                  CHARINDEX('Comp.:', CAST(V.observacion AS NVARCHAR(MAX))) AS idx_comp, CHARINDEX('Comp.', CAST(V.observacion AS NVARCHAR(MAX))) AS idx_comp_start ,
                  iv.c_cuenta, 
                  LEFT(RTRIM(pc.nombre), 60) AS nombre,
                  iv.debe,
                  iv.haber,iv.linea,(select min(ivvv.linea) from items_voucher ivvv where ivvv.numero=v.numero) as minimo
                  FROM Voucher V 
                  LEFT JOIN Subdiarios S ON V.c_subdiario = S.c_subdiario 
                  LEFT JOIN SUNAT_TABLA8_CODIGO_DEL_LIBRO_O_REGISTRO t8 ON t8.codigo = S.codigo_sunat8 
                  inner join Items_voucher iv on iv.numero=v.numero
                  LEFT JOIN  plan_de_cuentas_YEAR pc   ON pc.c_cuenta = iv.c_cuenta       
                  INNER JOIN         plan_De_cuentas_year_version PCV WITH (NOLOCK) 
                  ON   PC.VERSION = PCV.version  and pcv.c_year='" . $anho . "'
                  WHERE V.ano_contable = '" . $anho . "'  AND V.cod_mes_contable = '" . $periodo . "'  AND V.flag = '*' AND V.c_local LIKE '" . $cc_local . "' ) 

                  SELECT O.cod_mes_contable, O.numero, O.fecha,
                  UPPER(CASE WHEN O.c_subdiario = '03' THEN LEFT(O.observacion, CASE WHEN O.idx_comp = 0 THEN 40 ELSE O.idx_comp - 1 END) WHEN O.c_subdiario = '01' AND O.idx_comp_start = 1 
                  THEN SUBSTRING(O.observacion, O.idx_comp_start + 30, 10) ELSE O.observacion END) AS observacion, O.codigo_sunat8 + ' ' + O.sunat_descripcion AS sunat, RIGHT(O.voucher, 6) AS voucher, 
                  O.cod_documento, O.num_documento, O.c_subdiario + ' ' + O.sub_nombre AS sub,o.c_cuenta, 
                  o.nombre,
                  o.debe,
                  o.haber,o.linea,o.minimo,O.codigo_sunat8 FROM ObservacionCalculada O ORDER BY O.cod_mes_contable, O.fecha,O.numero,o.linea asc";
        // echo $sql;
                  return $this->dao->consulta($sql);
              }


              public function ListarLibroDiario_saldoincial($cc_local, $anho, $periodo)
              {
                $sql = "Select sum(debe) as debe_s, sum(haber)	as haber_s

                From items_voucher (Nolock) inner join  voucher (Nolock) on items_voucher.numero = voucher.numero  
                where flag = '*'   
                and ano_contable = '" . $anho . "'  and cast(cod_mes_contable as int) < CASt('" . $periodo . "' as int)
                and  c_local ='" . $cc_local . "'
                ;";
        //     echo $sql;
                return $this->dao->consulta($sql);
            }

            /**************Libro Mayor***********/
            public function ListarLibroMayor_saldoincial($cc_local, $anho, $periodo,$c_cuenta)
            {
                $sql = "Select sum(debe) as debe_s, sum(haber)	as haber_s

                From items_voucher (Nolock) inner join  voucher (Nolock) on items_voucher.numero = voucher.numero  
                where flag = '*'   
                and ano_contable = '" . $anho . "'  and cast(cod_mes_contable as int) < CASt('" . $periodo . "' as int)
                and  c_local ='" . $cc_local . "' and items_voucher.c_cuenta='".$c_cuenta."'
                ;";
       //     echo $sql;
                return $this->dao->consulta($sql);
            }

            public function ListarLibroMayor_cuentasbase($cc_local, $anho, $periodo, $cta_ini, $cta_fin)
            {
                $sql = "Select substring(iv.c_cuenta,1,2) as cuenta_padre ,pcy.nombre as nombre_cuenta
                From items_voucher iv
                inner join voucher v on iv.numero = v.numero 
                inner join plan_De_cuentas_year_version pcyv on pcyv.c_year='" . $anho . "' 
                inner join PLAN_DE_CUENTAS_YEAR pcy on pcy.C_CUENTA=substring(iv.c_cuenta,1,2) and pcy.version=pcyv.version
                where flag = '*' and ano_contable = '" . $anho . "'  and cast(cod_mes_contable as int) = CASt('" . $periodo . "' as int) and c_local ='" . $cc_local . "'
                and substring(iv.c_cuenta,1,2) between '" . $cta_ini . "' and '" . $cta_fin . "'
                group by substring(iv.c_cuenta,1,2) ,pcy.NOMBRE 
                order by substring(iv.c_cuenta,1,2) asc;";
        //echo $sql;
                return $this->dao->consulta($sql);
            }

            public function ListarLibroMayor_cuentas($cc_local, $anho, $periodo, $cta_ini)
            {
                $sql = "Select iv.c_cuenta  as cuenta_dato ,pcy.nombre as nombre_dato 
                From items_voucher iv 
                inner join voucher v on iv.numero = v.numero 
                inner join plan_De_cuentas_year_version pcyv on pcyv.c_year='" . $anho . "' 
                inner join PLAN_DE_CUENTAS_YEAR pcy on pcy.C_CUENTA=iv.c_cuenta and pcy.version=pcyv.version
                where flag = '*' and ano_contable = '" . $anho . "'  and cast(cod_mes_contable as int) = CASt('" . $periodo . "' as int) and c_local ='" . $cc_local . "'
                and substring(iv.c_cuenta,1,2) like  '" . $cta_ini . "%' and len(rtrim(iv.c_cuenta))=10
                group by iv.c_cuenta ,pcy.NOMBRE 
                order by iv.c_cuenta asc;";
        // echo $sql;
                return $this->dao->consulta($sql);
            }

            public function ListarLibroMayor_detalle($cc_local, $anho, $periodo, $cta_ini,$o)
            {
                $sql = "WITH ObservacionCalculada AS 
                ( SELECT    V.numero, dbo.fc_fecha_texto(V.fecha) AS fecha, CAST(V.observacion AS NVARCHAR(MAX)) AS observacion, 
                    V.voucher, V.cod_documento, V.num_documento, 

                    iv.debe,
                    iv.haber, ";
                    if($o=='B')
                        {$sql.="    
                    (SELECT ivx.c_cuenta FROM Voucher Vx (NOLOCK)INNER JOIN ITEMS_VOUCHER IVx (NOLOCK) ON Vx.NUMERO=IVx.NUMERO
                    inner join plan_De_cuentas_year_version pcyv on pcyv.c_year='" . $anho . "' 
                    inner join plan_de_cuentas_year pcy on pcy.c_cuenta=ivx.c_cuenta  and pcyv.version=pcy.version
                    WHERE v.numero=vx.numero AND IVx.linea=2)   as cuenta_origen,
                    (SELECT pcy.nombre FROM Voucher vv (NOLOCK)INNER JOIN ITEMS_VOUCHER IVv (NOLOCK) ON vV.NUMERO=IVv.NUMERO
                    inner join plan_De_cuentas_year_version pcyv on pcyv.c_year='" . $anho . "' 
                    inner join plan_de_cuentas_year pcy on pcy.c_cuenta=ivv.c_cuenta  and pcyv.version=pcy.version
                    WHERE v.numero=vv.numero AND IVv.linea=2)   as cuenta_origen_n,
                    (select isnull(p.ruc,p.num_documento)+'-'+p.nombre from personas p where p.c_persona=v.c_persona) as nombre_social
                    ";
                } else{
                    $sql.=" '" . $cta_ini . "' as cuenta_origen,'" . $cta_ini . "' as cuenta_origen_n,'' as nombre_social ";

                }
                $sql.=" FROM Voucher V 
                inner join Items_voucher iv on iv.numero=v.numero

                WHERE V.ano_contable = '" . $anho . "'  AND V.cod_mes_contable = '" . $periodo . "'  AND V.flag = '*' AND V.c_local LIKE '" . $cc_local . "' 
                and rtrim(iv.c_cuenta)='" . $cta_ini . "'
                ) 
                SELECT   O.numero, O.fecha,
                O.observacion,o.voucher, 
                O.cod_documento, O.num_documento,  

                o.debe,
                o.haber ,o.cuenta_origen,o.cuenta_origen_n,o.nombre_social
                FROM ObservacionCalculada O ORDER BY  O.fecha,O.numero ";
     //   echo $sql;
                return $this->dao->consulta($sql);
            }

            /**************Libro bancos***********/

            public function ListarcuentasBancarias($c_local,$c_banco,$c_cuenta)
            {
             $sql = "select b.nombre,cc.c_banco,cc.c_cta_corriente,cc.c_cuenta_pcge2014
             from Cuentas_corrientes cc 
             inner join Bancos b on b.c_banco=cc.c_banco
             where cc.c_local='" . $c_local . "'
             and cc.c_cuenta_PCGE2014 is not null ";
             if (!empty($c_banco)) { 
                $sql .= " and b.c_banco='".$c_banco."' and cc.c_cta_corriente='".$c_cuenta."' ";
            }
            $sql .= " order by  b.nombre,cc.c_banco,cc.c_cta_corriente";


      // echo $sql;
            return $this->dao->consulta($sql);
        }


        /**************Libro ventas***********/
        public function ListarLibroVentas($cc_local, $anho, $periodo)
        {
            $sql = "select                                
            substring('" . $anho . "',1,4) + '-'+ '" . $periodo . "' as correlativo,
            dbo.fc_fecha_texto(Documentos_de_venta.fecha) as fecha,
            dbo.fc_fecha_texto(documentos_de_venta.fecha) as fecha2,
            ( CASE documentos_de_venta.COD_DOCUMENTO WHEN 'FC' THEN '01' WHEN 'BC'  THEN '02' ELSE '07' END) as rci,                                        
            documentos_de_venta.num_documento as  num_documento,
            (CASE documentos_de_venta.COD_DOCUMENTO WHEN 'FC' THEN '06' ELSE '01' END) as tipo_doc,
            (CASE PERSONAS.COD_TIPO WHEN 'ME' THEN personas.num_documento ELSE PERSONAS.RUC END )As num_doc,
            RTRIM(Personas.nombre)+( CASE PERSONAS.COD_TIPO WHEN 'ME' THEN  '(#'+rtrim(isnull(Personas.c_cmp,''))+')' ELSE '' END) +                                   
            (case documentos_de_venta.FLAG WHEN 'A' THEN ' *ANULADO*' else '' END ) AS nombre,                                           
            (case factor_igv when 0 then 0.00 else cast((documentos_de_venta.TOTAL_ORIGINAL)*100/(100+(factor_igv*100)) AS decimal(10,2)) end) as biplong,                 
            (case factor_igv when  0 then cast((documentos_de_venta.TOTAL_ORIGINAL)*100/(100+(factor_igv*100)) AS decimal(10,2))  else 0.00 end) as  exonerada,                                    
            0.00 as inafecta,                                    
            CAST(((documentos_de_venta.TOTAL_ORIGINAL*(factor_igv*100))/(100+(factor_igv*100))) AS decimal(10,2)) as igv,                    
            0.00 as otrosimp,                                    
            documentos_de_venta.TOTAL_ORIGINAL AS importe_total,
            documentos_de_venta.tipo_De_cambio AS tipo_de_cambio,
            documentos_de_venta.c_persona_ref,
            documentos_de_venta.flag,
            (CASE Documentos_de_venta.cod_documento_ref WHEN 'FC' THEN '06'  WHEN 'BC' THEN '01' ELSE '07' END) +' '+
            Documentos_de_venta.cod_documento_ref+' '+Documentos_de_venta.num_documento_ref AS na_doc_referencia    
            FROM documentos_de_venta(NOLOCK) LEFT JOIN PERSONAS(NOLOCK) ON documentos_de_venta.C_PERSONA=PERSONAS.C_PERSONA                                        
            WHERE Documentos_de_venta.c_local='" . $cc_local . "'                                    
            AND (cast(year(Documentos_de_venta.fecha) as char(4))+replicate('0',2-len(month(Documentos_de_venta.fecha))) +cast(month(Documentos_de_venta.fecha) as char(2))) = '" . $anho . $periodo . "'                                        
            and Documentos_de_venta.cod_documento in ('fc','bc','NA') 
            group by Documentos_de_venta.fecha, 
            documentos_de_venta.fecha ,documentos_de_venta.cod_documento,documentos_de_venta.num_documento,PERSONAS.num_documento 
            ,PERSONAS.cod_tipo,PERSONAS.ruc,PERSONAS.nombre,PERSONAS.c_cmp,documentos_de_venta.flag,documentos_de_venta.total_original,documentos_de_venta.factor_igv
            ,documentos_de_venta.Tipo_de_cambio,
            documentos_de_venta.c_persona_ref,
            documentos_de_venta.flag, 
            ((CASE Documentos_de_venta.cod_documento_ref WHEN 'FC' THEN '06'  WHEN 'BC' THEN '01' ELSE '07' END) +' '+Documentos_de_venta.cod_documento_ref+' '+Documentos_de_venta.num_documento_ref)      
            ORDER BY Documentos_de_venta.fecha";
        //echo $sql;
            return $this->dao->consulta($sql);
        }
    }
