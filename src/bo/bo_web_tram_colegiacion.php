<?php
require_once dirname(__DIR__) . '/dao/dao_web_tram_colegiacion.php';
class bo_web_tram_colegiacion
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_web_tram_colegiacion();
    }

    public function control(web_tram_colegiacion $obj, $opc)
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

    public function listar(web_tram_colegiacion $obj)
    {
        $sql = "SELECT TOP(15) dbo.fc_fecha_texto(col_fecha) AS col_fecha,
                c_region, nombre_region_abbr nombre_region,
                UPPER(RTRIM(RTRIM(apellido_paterno) + ' ' + RTRIM(apellido_materno) + ' ' + RTRIM(nombre1) + ' ' + RTRIM(nombre2))) as nombres,
                RTRIM(num_documento) num_documento, cod_documento, estado, email, celular,
                DBO.fc_v1_parametro_valor_corto('personas','cod_documento',cod_documento) cod_documento_text
                FROM vw_web_tram_colegiacion (NOLOCK)
                WHERE YEAR(col_fecha) > (YEAR(GETDATE())-2) 
                AND UPPER(RTRIM(RTRIM(apellido_paterno) + ' ' + RTRIM(apellido_materno) + ' ' + RTRIM(nombre1) + ' ' + RTRIM(nombre2))) LIKE UPPER('%{$obj->getNombre1()}%')";
        $sql .= (!empty($obj->getNum_documento())) ? " AND num_documento LIKE '{$obj->getNum_documento()}%'" : '';
        $sql .= ($obj->getC_region() !== '28') ? " AND c_region='{$obj->getC_region()}' " : '';
        $sql .= " ORDER BY UPPER(RTRIM(RTRIM(apellido_paterno) + ' ' + RTRIM(apellido_materno) + ' ' + RTRIM(nombre1) + ' ' + RTRIM(nombre2)));";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function showNuevoColegiadoId(web_tram_colegiacion $obj)
    {
        $sql = "SELECT 
                wt.c_persona,
                wt.nombre_region,
                RTRIM(wt.num_documento) as num_documento,
                UPPER(RTRIM(RTRIM(wt.apellido_paterno) + ' ' + RTRIM(wt.apellido_materno) + ' ' + RTRIM(wt.nombre1) + ' ' + RTRIM(wt.nombre2))) as nombres,
                wt.pais_nacim,
                wt.Email,
                wt.celular,
                wt.direccion,
                wt.ubigeodirec,
                wt.ubigeonac,
                wt.estado_civil,
                wt.grupo_sanguineo,
                wt.factor_sanguineo,
                wt.univ_lic,
                wt.prof_titulo,
                wt.prof_c_universidad,
                wt.prof_c_pais,
                wt.prof_sunedu,
                wt.bach_c_universidad,
                wt.bach_c_pais,
                wt.bach_forma,
                wt.bach_nombre,
                wt.prof_modingreso,
                wt.prof_sede,
                wt.prof_duracion,
                wt.prof_exa_suf,
                wt.recaudo,
                (SELECT P.c_cmp FROM personas P WITH (NOLOCK) WHERE P.num_documento = wt.num_documento AND P.c_cmp IS NOT NULL) AS cep,
                DBO.fc_v1_parametro_valor_corto('personas','cod_documento',wt.cod_documento) cod_documento_text,
                DBO.fc_v1_parametro_valor_corto('personas','cod_sexo',wt.genero) genero_text,
                DBO.fc_fecha_texto(wt.fecha_de_nacimiento) fec_nac,
                DBO.fc_fecha_texto(wt.prof_fecha) as fec_titulo,
                DBO.fc_fecha_texto(wt.bach_fecha) as fec_bach,
                DBO.fc_fecha_texto(wt.col_fecha) as fecha_registro,
                DBO.fc_ubigeo(wt.ubigeonac) as lugar_nacimiento,
                DBO.fc_ubigeo(wt.ubigeodirec) as lugar_direccion
                from vw_web_tram_colegiacion wt
                where wt.num_documento='{$obj->getNum_documento()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function showNuevoColegiadoId_pago_Reaudo(web_tram_colegiacion $obj)
    {
        $sql = "SELECT '*BCP* '+dato_adicional AS dato_adicional,fecha,referencia,monto
                from bcp_proceso_detalle where referencia like RTRIM('%{$obj->getNum_documento()}%')
                union all 
                SELECT '*BBVA* '+nombre,fecha_pago,referencia2,total
                from bbva_proceso_detalle where referencia1 like '%{$obj->getNum_documento()}%'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function PersonaIDdni_nuevocol_recaudox(web_tram_colegiacion $obj)
    {
        $sql = "SELECT
                'CR '+bcp.c_local+' - '+bcp.fecha+' BCP ** DOCUMENTO_PAGO = '+cast(bcp.total_distribuir as char(10)) AS bcp1 ,
                'CR '+bbva.c_local+' - '+bbva.fecha_pago+' BBVA ** DOCUMENTO_PAGO = '+cast(bbva.total as char(10)) AS bbva1
                FROM personas P (NOLOCK)
                LEFT JOIN bcp_proceso_detalle bcp (NOLOCK) ON bcp.dato_adicional like '%'+ rtrim(p.num_documento)+'%' and substring(bcp.dato_adicional,1,3) in ('M04' ,'R01')
                LEFT JOIN bbva_proceso_detalle bbva (NOLOCK) on bbva.referencia1 = rtrim(p.num_documento) and substring(bbva.referencia2,1,3)='M04'
                where rtrim(p.num_documento)='{$obj->getNum_documento()}'
                group by 'CR '+bcp.c_local+' - '+bcp.fecha+' BCP ** DOCUMENTO_PAGO = '+cast(bcp.total_distribuir as char(10)) ,
                'CR '+bbva.c_local+' - '+bbva.fecha_pago+' BBVA ** DOCUMENTO_PAGO = '+cast(bbva.total as char(10))
                ORDER BY 'CR '+bcp.c_local+' - '+bcp.fecha+' BCP ** DOCUMENTO_PAGO = '+cast(bcp.total_distribuir as char(10)) ,
                'CR '+bbva.c_local+' - '+bbva.fecha_pago+' BBVA ** DOCUMENTO_PAGO = '+cast(bbva.total as char(10))";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarHistorialXNumDocumento(web_tram_colegiacion $obj)
    {
        $sql = "SELECT wh.id,wh.num_documento,wh.c_usuario, dbo.fc_fecha_hora(wh.fecha) as fecha, wh.codigo, wh.detalle,
                (CASE wh.codigo WHEN 'CL' THEN 'NUEVO COLEGIADO' WHEN 'CR' THEN 'CONSEJO REGIONAL' WHEN 'CN' THEN 'CONSEJO NACIONAL' END) AS fase
                FROM web_tram_colegiacion_historial wh
                WHERE wh.num_documento='{$obj->getNum_documento()}'
                ORDER BY wh.fecha";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(web_tram_colegiacion $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function reportFicha(web_tram_colegiacion $obj)
    {
        $sql = "SELECT wt.c_persona,
                wt.nombre_region c_region,
                wt.cod_documento,
                wt.pais_nacim,
                wt.Email,
                wt.celular,
                wt.direccion,
                wt.ubigeodirec,
                wt.ubigeonac,
                wt.estado_civil,
                wt.grupo_sanguineo,
                wt.factor_sanguineo,
                wt.univ_lic,
                wt.prof_titulo,
                wt.prof_c_universidad,
                wt.prof_c_pais,
                wt.prof_sunedu,
                wt.bach_c_universidad,
                wt.bach_c_pais,
                wt.bach_nombre,
                wt.prof_sede,
                wt.prof_duracion,
                wt.prof_exa_suf,
                wt.pais_univ_lic,
                wt.pais_uni_bach,
                wt.univ_bach,
                wt.distrito_region,
                UPPER(RTRIM(RTRIM(wt.apellido_paterno) + ' ' + RTRIM(wt.apellido_materno) + ' ' + RTRIM(wt.nombre1) + ' ' + RTRIM(wt.nombre2))) as nombres,
                RTRIM(wt.num_documento) as num_documento,
                (SELECT P.c_cmp FROM personas P WITH (NOLOCK) WHERE P.num_documento = wt.num_documento AND P.c_cmp IS NOT NULL) AS cep,
                DBO.fc_v1_parametro_valor_corto('personas','cod_documento',wt.cod_documento) cod_documentocod,
                DBO.fc_v1_parametro_valor_corto('personas','cod_sexo',wt.genero) genero_text,
                DBO.fc_v1_parametro_valor('personas','c_e_civil',wt.estado_civil) estado_civil_text,
                dbo.fc_parametro_valor('web_tram_colegiacion','prof_modingreso',prof_modingreso) as prof_modingreso,
                dbo.fc_parametro_valor('web_tram_colegiacion','bach_forma',bach_forma) as bach_forma,
                dbo.fc_parametro_valor('web_tram_colegiacion','grupo_sanguineo',grupo_sanguineo) +' '+ 
                dbo.fc_parametro_valor('web_tram_colegiacion','factor_sanguineo',factor_sanguineo)  as sangre,
                DBO.fc_fecha_texto(wt.fecha_de_nacimiento) fec_nac,
                DBO.fc_fecha_texto(wt.prof_fecha) as fec_titulo,
                DBO.fc_fecha_texto(wt.bach_fecha) as fec_bach,
                DBO.fc_fecha_texto(wt.col_fecha) as col_fecha,
                DBO.fc_ubigeo(wt.ubigeonac) as lugar_nacimiento,
                DBO.fc_ubigeo(wt.ubigeodirec) as lugar_direccion
                from vw_web_tram_colegiacion wt where wt.num_documento='{$obj->getNum_documento()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
