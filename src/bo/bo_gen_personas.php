<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas.php';
class bo_gen_personas
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas();
    }

    public function c_persona_max(gen_personas $obj)
    {
        $sql = "SELECT RIGHT('000000' + CAST(ISNULL(MAX(CAST(c_persona AS INT)), 0) + 1 AS VARCHAR(6)), 6) AS nuevo_c_persona
        FROM personas
        WHERE ISNUMERIC(c_persona) = 1";
        return $this->dao->consulta($sql);
    }

    public function control_ruc(gen_personas $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar_ruc($obj);
                break;
            case "U":
                return $this->dao->modificar_ruc($obj);
                break;
        }
    }

    public function control_capacitacion(gen_personas $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar_cap($obj);
                break;
            case "U":
                return $this->dao->modificar_cap($obj);
                break;
        }
    }

    public function control(gen_personas $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar_colegiacion($obj);
                break;
            case "E":
                return $this->dao->eliminar($obj);
                break;
            case "NVO_CEP":
                return $this->dao->insertarNuevoCEP($obj);
                break;
        }
    }

    public function printFotosColegiacion_limpiar()
    {
        return $this->dao->printFotosColegiacion_limpiar();
    }

    public function printFotosColegiacion($cep, $cepinicio, $cepfinal, $tipo)
    {
        return $this->dao->EjcutarFotosColegiacion($cep, $cepinicio, $cepfinal, $tipo);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function ValidarNuevaPersona(?gen_personas $obj = null)
    {
        $sql = "select c_persona from 
        personas 
        where ";
        if (!empty($obj->getRuc())) {
            $sql .= "  ltrim(isnull(ruc,''))='{$obj->getRuc()}'";
        }
        if (!empty($obj->getNum_documento())) {
            $sql .= " ltrim(num_documento)='{$obj->getNum_documento()}'";
        }


        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar_proveedores(?gen_personas $obj = null)
    {
        $sql = "SELECT top 50  dbo.fc_fecha_texto(fecha_de_registro) fecha_de_registro,c_persona ,isnull(ruc,'') ruc,isnull(nombre,'') nombre,c_cmp,celular1,email1,usuario,isnull(num_documento,'') num_documento
        FROM personas nolock
         WHERE 1=1 ";

        if (!empty($obj->getNombre())) {
            $sql .= " AND nombre LIKE '%" . $obj->getNombre() . "%' ";
        }

        if (!empty($obj->getRuc())) {
            $sql .= " AND ruc LIKE '%" . $obj->getRuc() . "%' ";
        }
        if (!empty($obj->getNum_documento())) {
            $sql .= " AND num_documento LIKE '%" . $obj->getNum_documento() . "%' ";
        }
        $sql .= " order by nombre,ruc,c_cmp";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function validarPersona(?gen_personas $obj = null)
    {
        $sql = "SELECT c_persona 
        FROM personas nolock
        WHERE c_persona='{$obj->getC_persona()}'";
        return $this->dao->consulta($sql);
    }

    public function buscarColegiadosJson(?gen_personas $obj) //COLEGIADOS
    {
        $sql = "SELECT TOP(15)  rtrim(c_cmp)+' - '+rtrim(nombre) AS nombre_completo,
        c_persona
        FROM personas
        WHERE ISNUMERIC(c_cmp)=1
        and flag_activo in('B','V','A','C')
        AND nombre LIKE '%" . $obj->getNombre() . "%'";
        if (!empty($obj->getC_cmp()) > 0) {
            $sql .= " and c_cmp='" . $obj->getC_cmp() . "'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function buscarPersonasJson(?gen_personas $obj) // NO COLEGIADOS
    {
        $sql = "select TOP 25 c_persona,
            isnull('DNI('+rtrim(num_documento)+')','PE:('+c_persona+')')   +') - '+ISNULL(' RUC:'+ruc+' - ','')+RTRIM(nombre) + isnull(' - CEP:'+c_cmp,'') AS nombre_completo
      
        FROM personas
        WHERE ISNULL(flag_activo,'') <> 'F'
		 
        AND nombre LIKE '{$obj->getNombre()}%'";
        if (!empty($obj->getNum_documento()) > 0) {
            $sql .= "and (num_documento  like '%{$obj->getNum_documento()}' or ruc like '{$obj->getNum_documento()}%')";
        }
        $sql .= "AND PATINDEX('%*%', nombre) = 0 ";
        $sql .= "AND ISNUMERIC(c_persona) = 1 ORDER BY nombre desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function buscarRucJson(gen_personas $obj) // EMPRESAS
    {
        $sql = "select c_persona,
        ruc,
        nombre,
        ISNULL(ruc,'')+' - '+ISNULL(rtrim(nombre),'') 
         as razon_social
        FROM personas 
        WHERE (ruc LIKE '%" . $obj->getRuc() . "%' OR nombre LIKE '%" . $obj->getRuc() . "%')
         and c_cmp is null";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function buscarTodoJson(gen_personas $obj)
    {
        $buscar = trim($obj->getNombre());
        if ($buscar == '') {
            $buscar = trim($obj->getNum_documento());
        }
        $sql = "SELECT TOP 10
            c_persona,
            grado,
            ruc,
            c_cmp,
            num_documento,
            '[' + 
            ISNULL(RTRIM(c_cmp), '') + 
            '] ' +
            RTRIM(nombre) +
            ' => ' +
            ISNULL(RTRIM(num_documento), '') AS nombre_completo
        FROM Personas
        WHERE ISNUMERIC(c_persona) = 1";
        if (is_numeric($buscar)) {
            if (strlen($buscar) <= 6) {
                $buscar = str_pad($buscar, 6, '0', STR_PAD_LEFT);
                $sql .= " AND c_cmp = '$buscar'";
            } else {
                $sql .= " AND num_documento = '$buscar'";
            }
        } else {
            $sql .= " AND nombre LIKE '%$buscar%'";
        }
        $sql .= " ORDER BY nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function listarShowID($c_persona)/*vistas cortas**/
    {
        $sql = "SELECT 
        p.c_persona,
        p.c_cmp,
        p.cod_documento,
        rtrim(p.num_documento) as num_documento,
        RTRIM(p.nombre) AS nombre_completo,
        p.flag_activo,
        a.nombre AS flag_activo_text,
        p.c_local,
        l.nombre as c_local_text,
        p.cod_sexo,
        p.celular1,
        dbo.fc_fecha_texto(p.fecha_de_inicio) AS fecha_colegiacion,
        p.Email1,
        p.flag_habil,
        p.abono_favor,
        CASE WHEN p.flag_habil = 'H' THEN 'HABIL'
        ELSE 'INHABIL'
        END AS flag_habil_text,
        dbo.fc_fecha_texto(p.fecha_de_nacimiento) AS fecha_nacimiento,
        ep.nombre as ent_pagadora,
        DATEDIFF(YEAR, p.fecha_de_nacimiento, GETDATE()) AS edad,
        DATEDIFF(MONTH, p.fecha_de_nacimiento, GETDATE()) - (DATEDIFF(YEAR, fecha_de_nacimiento, GETDATE()) * 12) AS edad_meses
        FROM 
        dbo.Personas p (NOLOCK)
        INNER JOIN 
        flag_activo a (NOLOCK) ON p.flag_activo = a.codigo
        LEFT JOIN
        Entidad_pagadora ep (NOLOCK)
        on ep.c_entidad_pagadora=p.c_entidad_pagadora
        inner join local l
        on l.c_local=p.c_local
        WHERE 
        p.c_persona ='" . $c_persona . "'";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarColegiados(gen_personas $obj)
    {
        $sql = "SELECT TOP 15 
        p.c_persona,
        RTRIM(p.c_cmp) AS cep, 
        RTRIM(p.nombre) AS nombre_completo,
        dbo.fc_fecha_texto(p.fecha_de_inicio) AS fecha_col,
        dbo.fc_fecha_texto(p.fecha_de_nacimiento) AS fecha_nac,
        p.num_documento,
        p.flag_activo,
        dbo.fc_v1_parametro_valor('personas','flag_activo',p.flag_activo) as flag_activo_text,
        p.Email1,
        p.celular1,
        l.nombre AS c_local_text,
        l.nombre_abv AS c_local_abv,
        ISNULL(dbo.fc_es_vacio(p.flag_habil),'I') flag_habil,
        dbo.fc_v1_parametro_valor('personas','flag_habil',ISNULL(dbo.fc_es_vacio(p.flag_habil),'I')) as flag_habil_text,
        p.abono_favor,
        p.tipo_direccion,
        DATEDIFF(YEAR, p.fecha_de_inicio, GETDATE()) AS anos_colegiacion,
        DATEDIFF(MONTH, DATEADD(YEAR, DATEDIFF(YEAR, p.fecha_de_inicio, GETDATE()), p.fecha_de_inicio), GETDATE()) AS meses_restantes
        FROM 
        Vw_personas_solo_cep p
        INNER JOIN 
        gen_local l WITH (NOLOCK)
        ON p.c_local = l.c_local
        WHERE UPPER(p.nombre) LIKE UPPER('%" . $obj->getNombre() . "%')";
        if (!empty($obj->getC_cmp())) {
            $sql .= " and rtrim(p.c_cmp)='" . $obj->getC_cmp() . "'";
        }
        $sql .= " ORDER BY p.c_cmp DESC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarReporteColegiados(gen_personas $obj)
    {
        $sql = "SELECT TOP 1000
        p.c_persona,
        RTRIM(p.c_cmp) AS cep, 
        RTRIM(p.nombre) AS nombre_completo,
        dbo.fc_fecha_texto(p.fecha_de_inicio) AS fecha_col,
        dbo.fc_fecha_texto(p.fecha_de_nacimiento) AS fecha_nac,
        p.num_documento,
        p.flag_activo,
        dbo.fc_v1_parametro_valor('personas','flag_activo',p.flag_activo) as flag_activo_text,
        p.Email1,
        p.celular1,
        l.nombre AS c_local_text,
        l.nombre_abv AS c_local_abv,
        ISNULL(dbo.fc_es_vacio(p.flag_habil),'I') flag_habil,
        dbo.fc_v1_parametro_valor('personas','flag_habil',ISNULL(dbo.fc_es_vacio(p.flag_habil),'I')) as flag_habil_text,
        dbo.fc_v1_parametro_valor_corto('personas','cod_documento',p.cod_documento) as cod_documento_text,
        p.abono_favor,
        p.tipo_direccion
        FROM 
        Vw_personas_solo_cep p (NOLOCK)
        INNER JOIN 
        gen_local l (NOLOCK)
        ON p.c_local = l.c_local
        WHERE ISNUMERIC(p.c_cmp) = 1
        AND UPPER(p.nombre) LIKE UPPER('%" . $obj->getNombre() . "%')";
        $sql .= $obj->getDesde() !== '000000' ? " AND p.c_cmp BETWEEN '" . $obj->getDesde() . "' AND '" . $obj->getHasta() . "'" : "";
        $sql .= !empty($obj->getCod_documento()) ? " AND p.cod_documento = '" . $obj->getCod_documento() . "'" : "";
        $sql .= !empty($obj->getNum_documento()) ? " AND p.num_documento = '" . $obj->getNum_documento() . "'" : "";
        $sql .= !empty($obj->getFlag_activo()) ? " AND p.flag_activo = '" . $obj->getFlag_activo() . "'" : "";
        $sql .= !empty($obj->getC_local()) ? " AND p.c_local = '" . $obj->getC_local() . "'" : "";

        $sql .= " ORDER BY p.nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarColegiadosFicha(gen_personas $obj)
    {
        $sql = "SELECT TOP 100 
        p.c_persona,
        RTRIM(p.c_cmp) AS cep, 
        RTRIM(p.nombre) AS nombre_completo,
        dbo.fc_fecha_texto(p.fecha_de_inicio) AS fecha_col,
        dbo.fc_fecha_texto(p.fecha_de_nacimiento) AS fecha_nac,
        p.num_documento,
        p.flag_activo,
        dbo.fc_v1_parametro_valor('personas','flag_activo',p.flag_activo) as flag_activo_text,
        p.Email1,
        p.celular1,
        l.nombre AS c_local_text,
        l.nombre_abv AS c_local_abv,
        ISNULL(dbo.fc_es_vacio(p.flag_habil),'I') flag_habil,
        dbo.fc_v1_parametro_valor('personas','flag_habil',ISNULL(dbo.fc_es_vacio(p.flag_habil),'I')) as flag_habil_text,
        p.abono_favor,
        p.tipo_direccion
        FROM 
        personas p (NOLOCK)
        INNER JOIN 
        gen_local l (NOLOCK)
        ON p.c_local = l.c_local
        WHERE ISNUMERIC(p.c_cmp) = 1
        AND p.fecha_de_inicio > '27/11/2024' AND rtrim(p.nombre) LIKE UPPER('%" . $obj->getNombre() . "%')";
        $sql .= !empty($obj->getDesde()) ? " AND p.c_cmp BETWEEN '" . $obj->getDesde() . "' AND '" . $obj->getHasta() . "'" : "";
        $sql .= " ORDER BY c_cmp";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(gen_personas $obj)
    {
        $sql = "SELECT p.c_persona,
        p.c_cmp,
        rtrim(p.apellido_materno) as apellido_materno,
        rtrim(p.apellido_paterno) as apellido_paterno,
        rtrim(p.nombre1) as nombre1,
        rtrim(p.nombre2) as nombre2,
        p.grado,
        rtrim(p.nombre) as nombre_completo,
        p.ruc,
        RTRIM(p.flag_activo) flag_activo,
        dbo.fc_v1_parametro_valor('personas','flag_activo',p.flag_activo) as flag_activo_text,
        p.cod_documento,
        dbo.fc_v1_parametro_valor('personas','cod_documento',p.cod_documento) as cod_documento_text,
        RTRIM(p.num_documento) num_documento,
        dbo.fc_fecha_FROM(p.fecha_de_registro) as fecha_de_registro,
        p.c_local,
        l.nombre as c_local_text,
        dbo.fc_fecha_FROM(p.fecha_de_inicio) as fecha_de_inicio,
        dbo.fc_fecha_FROM(p.fecha_de_cese) as fecha_de_cese,
        p.cod_sexo,
        dbo.fc_v1_parametro_valor('personas','cod_sexo',p.cod_sexo) as cod_sexo_text,
        p.abono_favor,
        p.forma_pago,
        dbo.fc_fecha_FROM(p.fecha_de_nacimiento) as fecha_de_nacimiento,
        rtrim(p.grupo_sanguineo) as grupo_sanguineo,
        (CASE WHEN rtrim(p.factor_sanguineo) = 'P' THEN '+' ELSE '-' END) as factor_sanguineo,
        rtrim(p.grupo_sanguineo)+(CASE WHEN rtrim(p.factor_sanguineo) = 'P' THEN '+' ELSE '-' END) as grupo_sanguineo_text,
        p.celular1,
        p.flag_habil,
        ISNULL(dbo.fc_es_vacio(p.flag_habil),'I') flag_habil,
        dbo.fc_v1_parametro_valor('personas','flag_habil',ISNULL(dbo.fc_es_vacio(p.flag_habil),'I')) as flag_habil_text,
        COALESCE(p.ubigeonac,
        p.coddpto_nacimiento+
        p.codprov_nacimiento+
        p.coddist_nacimiento) ubigeonac,
        dbo.fc_v1_ubigeo(COALESCE(p.ubigeonac,
        p.coddpto_nacimiento+
        p.codprov_nacimiento+
        p.coddist_nacimiento)) as ub_nacimiento,
        COALESCE(p.ubigeodirec,
        p.coddpto+
        p.codprov+
        p.coddist) ubigeodirec,
        dbo.fc_v1_ubigeo(COALESCE(p.ubigeodirec,
        p.coddpto+
        p.codprov+
        p.coddist)) as ub_actual,
        p.tipo_direccion,
        p.email1,
    
        dbo.fc_fecha_FROM(p.fecha_fallecido) as fecha_fallecido,
        p.c_entidad_pagadora,
        p.c_e_civil,
        dbo.fc_v1_parametro_valor('personas','c_e_civil',p.c_e_civil) as c_e_civil_text,
        p.c_universidad,
        (SELECT ub.nombre FROM universidad ub WHERE p.c_universidad=ub.c_universidad ) as uni_bachiller,
        dbo.fc_fecha_FROM(p.fecha_promocion) as fecha_de_vachiller,
        p.c_univ_licenciatura,
        (SELECT ut.nombre FROM universidad ut WHERE p.c_univ_licenciatura=ut.c_universidad ) as uni_titulo,
        dbo.fc_fecha_FROM(p.fecha_licenciatura) as fecha_licenciatura,
        p.n_folio_cole,
        p.n_libro_cole,
        p.n_resolucion_cole,
        p.n_folio_esp,
        p.n_libro_esp,
        p.c_local_colegiacion,
        DDIRECTO,
        lc.nombre as c_local_textcol,
        rtrim(pais_nacimiento) as pais_nacimiento
        FROM personas p (NOLOCK) left join gen_local l (NOLOCK)
        on p.c_local=l.c_local
        left join gen_local lc (NOLOCK)
        on p.c_local_colegiacion =lc.c_local
        WHERE c_persona='" . $obj->getC_persona() . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarLibroFolioLicenciatura($desde, $hasta)
    {
        $sql = "SELECT c_cmp,c_local_colegiacion,nombre,rtrim(num_documento) as num_documento,
            substring(CONVERT(CHAR(8),fecha_de_inicio, 112),7,2)+'/'+substring(CONVERT(CHAR(8),
            fecha_de_inicio, 112),5,2)+'/'+substring(CONVERT(CHAR(8), fecha_de_inicio, 112),1,4) as fecha,
            cod_sexo,n_libro_cole,n_folio_cole FROM personas(nolock) WHERE 
            n_folio_cole between " . $desde . " and " . $hasta . " order by c_cmp ";
        return $this->dao->consulta($sql);
    }

    public function listarLibroFolioOtrosGrados($tipo, $desde, $hasta)
    {
        $sql = "SELECT PE.C_REG_ESP AS c_cmp,rtrim(PE.C_LOCAL) AS c_local_colegiacion,RTRIM(P.nombre) AS nombre ,rtrim(p.num_documento) as num_documento,
                substring(CONVERT(CHAR(8),pe.fecha, 112),7,2)+'/'+substring(CONVERT(CHAR(8), pe.fecha, 112),5,2)+'/'+substring(CONVERT(CHAR(8), pe.fecha, 112),1,4)+' ('+RTRIM(e.nombre)+')' as fecha ,
                pe.n_libro_cole,pe.n_folio_cole,pe.literal as obs
                FROM personas P(nolock) 
                INNER JOIN Personas_especialidad PE (NOLOCK) 
                ON P.C_PERSONA=PE.C_PERSONA 
                inner join Especialidad_tipo e (nolock)on e.tipo_especialidad=SUBSTRING(pe.c_especialidad,1,1)
                WHERE SUBSTRING(pe.c_especialidad,1,1)='" . $tipo . "'
                and pe.n_folio_cole between " . $desde . " and " . $hasta . " 
                ORDER BY pe.c_reg_esp ";
        return $this->dao->consulta($sql);
    }

    public function listarLibroFolioHabExtranjero($desde, $hasta)
    {
        $sql = "SELECT ddii.id_doc, ddii.folio n_folio_cole, ddii.libro n_libro_cole,
                ABS(ddii.numero) c_cmp, 
                dbo.fc_fecha_texto(ddii.fecha) fecha,
                RTRIM(pp.nombre) nombre, pp.c_cmp cep,
                pp.c_local, 
                (SELECT ggll.nombre_abv FROM gen_local ggll WHERE ggll.c_local = pp.c_local) c_local_colegiacion,
                ddii.Cod_codigo, 
                (SELECT RTRIM(ps.nombre) FROM gen_pais ps WHERE ps.cc_pais = ddii.Cod_codigo) nombre_pais,
                UPPER(pp.tipo_direccion) tipo_direccion, UPPER(ddii.obs) obs
                FROM Documentos_Internos ddii 
                INNER JOIN Personas pp ON ddii.c_persona = pp.c_persona
                WHERE ddii.c_local = '28'
                    AND ddii.c_tipo = '03'
                AND ddii.FOLIO BETWEEN $desde AND $hasta
                ORDER BY ABS(ddii.numero)";
        return $this->dao->consulta($sql);
    }

    public function listarLibroFolioHabTemporal($desde, $hasta)
    {
        /**
         * ABS(ddii.numero)+391 c_cmp, => LIBRO INPRESO A SISTEMATIZADO
         */
        $sql = "SELECT ddii.id_doc, ddii.folio n_folio_cole, ddii.libro n_libro_cole,
                ABS(ddii.numero)+391 c_cmp, 
                dbo.fc_fecha_texto(ddii.fecha) fecha,
                dbo.fc_fecha_texto(ddii.fecha_visado) fecha_visado,
                dbo.fc_fecha_texto(ddii.fecha_entrega) fecha_entrega,
                RTRIM(pp.nombre) nombre,
                ddii.Cod_codigo, 
                (SELECT RTRIM(ps.nombre) FROM gen_pais ps WHERE ps.cc_pais = ddii.Cod_codigo) nombre_pais,
                (SELECT RTRIM(ppx.nombre) FROM personas ppx WHERE ppx.c_persona = dr.c_persona) persona_solicitante,
                UPPER(pp.tipo_direccion) tipo_direccion, UPPER(ddii.obs) obs
                FROM Documentos_Internos ddii 
                LEFT JOIN Personas pp ON ddii.c_persona = pp.c_persona
                LEFT JOIN documentos_recibidos dr ON ddii.c_expediente = dr.c_expediente
                WHERE ddii.c_local = '28'
                AND ddii.c_tipo = '04'
                AND ddii.FOLIO BETWEEN $desde AND $hasta
                ORDER BY ABS(ddii.numero)";
        return $this->dao->consulta($sql);
    }

    public function listarDatosLibroFoliosLicenciatura($nro_folio)
    {
        $sql = "SELECT pe.c_persona,pe.c_cmp,pe.c_local_colegiacion,pe.nombre,rtrim(pe.num_documento) as num_documento,
            DBO.fc_fecha_Texto(pe.fecha_de_nacimiento) as  fecha_de_nacimiento,
            DBO.fc_fecha_Texto(pe.fecha_de_inicio)  as  fecha,
            DBO.fc_fecha_Texto(pe.fecha_promocion) as fecha_promocion,
            pe.cod_sexo,u.nombre as nombre_uni,lo.nombre1 as nombre_local,pe.celular1,isnull(pe.tipo_direccion,'')+' '+isnull(pe.tipo_domicilio,'')as direccion,pe.email1
            FROM personas pe  (nolock) LEFT JOIN universidad u (nolock)
            on u.c_universidad=pe.c_universidad
            left join local lo on lo.c_local=pe.c_local_colegiacion
            WHERE 
            n_folio_cole ='" . $nro_folio . "' order by c_cmp ";
        return $this->dao->consulta($sql);
    }

    public function listarDatosLibroOtrosGrados($tipo, $nro_folio)
    {
        $sql = "SELECT p.c_persona,PE.C_REG_ESP AS c_reg_esp,p.c_cmp,rtrim(PE.C_LOCAL) AS c_local_colegiacion,substring(RTRIM(P.nombre),1,50) AS nombre_persona ,rtrim(p.num_documento) as num_documento,
            substring(CONVERT(CHAR(8),pe.fecha, 112),7,2)+'/'+substring(CONVERT(CHAR(8), pe.fecha, 112),5,2)+'/'+substring(CONVERT(CHAR(8), pe.fecha, 112),1,4) as fecha,pe.literal,
            p.cod_sexo,pe.residentado,pe.n_libro_cole,pe.n_folio_cole,substring(pe.literal,1,110) as obs,pe.flag_escolarizado,l.nombre_abv,
            substring(CONVERT(CHAR(8),pe.fecha_diploma, 112),7,2)+'/'+substring(CONVERT(CHAR(8), pe.fecha_diploma, 112),5,2)+'/'+substring(CONVERT(CHAR(8), pe.fecha_diploma, 112),1,4) as fecha_diploma,substring(u.nombre,1,35) as nombre
            ,substring(pe.literal,1,95) as obs2
            FROM personas P(nolock) 
            INNER JOIN Personas_especialidad PE (NOLOCK) 
            ON P.C_PERSONA=PE.C_PERSONA 
            INNER JOIN LOCAL l ON l.C_LOCAL=PE.C_LOCAL
            inner join universidad u  (nolock) on u.c_universidad=pe.c_universidad   
            WHERE pe.n_folio_cole ='" . $nro_folio . "' and pe.tipo_Especialidad='" . $tipo . "'
            ORDER BY pe.c_reg_esp ";
        return $this->dao->consulta($sql);
    }

    public function listarPersonaNuevoCol(gen_personas $obj)
    {
        $sql = "SELECT TOP(5)
                p.c_persona,
                RTRIM(p.c_cmp) AS c_cmp,
                LTRIM(RTRIM(p.nombre)) as nombre_completo, 
                LTRIM(RTRIM(p.num_documento)) as num_documento,
                l.nombre c_localtex
                /*LTRIM(RTRIM(p.apellido_Paterno)) as ap_paterno,
                LTRIM(RTRIM(p.apellido_Materno)) as ap_materno,
                LTRIM(RTRIM(p.Nombre1)) as nombre1,
                p.c_local,
                p.cod_sexo,
                LTRIM(RTRIM(p.cod_documento)) as cod_documento,
                p. abono_favor ,
                p.flag_habil,
                p.flag_activo,
                dbo.fc_fecha_texto(p.fecha_de_inicio) as fecha_registro,
                p.c_local_colegiacion as c_local_tramite, 
                LTRIM(RTRIM(p.Nombre2)) as nombre2,*/
                from personas p(nolock)
                INNER JOIN local l(nolock) ON l.c_local=p.c_local
                WHERE cod_tipo='ME' AND isnumeric(p.c_persona)=1
                AND num_documento IS NOT NULL ";
        $sql .= !empty($obj->getNum_documento()) ?
            " AND num_documento LIKE '{$obj->getNum_documento()}%' " :
            " AND RTRIM(p.nombre) LIKE UPPER('%{$obj->getNombre()}%')";
        $sql .= " ORDER BY p.nombre";

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ultimoCMP()
    {
        $sql = "SELECT max(cast(isnull(c_cmp,0) AS INTEGER))+1 AS cmp
        FROM Personas (NOLOCK) WHERE ISNUMERIC(c_cmp)=1";
        return $this->dao->consulta($sql);
    }

    public function ImprimirFotosColegiados($cep, $cepinicio, $cepfinal)
    {
        $sql = "select cep, 
			RTRIM(num_documento) as dni , 
			RTRIM(apellido_paterno)+' '+RTRIM(Nombre1) as nombre_completo, 
			grupo_sanguineo, 
			factor_sanguineo, 
			
			dbo.fc_fecha_texto(fecha_de_inicio) as inicio, 
			dbo.fc_fecha_texto(vence) as hasta, 
			nombre_abv, 
			C_CMP
			from PERSONAS_CARNE order by c_cmp ";

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function diploma_lista($tipo, $desde, $hasta)
    {

        if ($tipo == "C") {
            $sql = "SELECT RTRIM(c_cmp) as c_cmp,c_local_colegiacion,nombre,rtrim(num_documento) as num_documento,
                    dbo.fc_fecha_texto(fecha_de_inicio) fecha,
                    cod_sexo, 'C' AS tipo_especialidad from Vw_personas_solo_cep
                    where c_cmp between '" . $desde . "' and '" . $hasta . "' order by c_cmp ";
        } else {
            $sql = "SELECT RTRIM(C_REG_ESP) AS c_cmp,
                    RTRIM(C_LOCAL) AS c_local_colegiacion,
                    RTRIM(nombre) AS nombre,
                    RTRIM(num_documento) as num_documento,
                    dbo.fc_fecha_texto(fecha) fecha,
                    tipo AS tipo_especialidad,
                    cod_sexo
                    From vw_personas_especialidad
                    WHERE tipo = '" . $tipo . "'
                    and c_reg_esp between '" . $desde . "' and '" . $hasta . "' 
                    ORDER BY c_reg_esp ";
        }

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function diploma_data($tipo, $desde, $hasta)
    {

        if ($tipo == "C") {
            $sql = "SELECT rtrim(c_cmp) as c_cmp,c_local_colegiacion,nombre,rtrim(num_documento) as num_documento,
                    dbo.fc_fecha_texto(fecha_de_inicio) as  fecha,
                    cod_sexo from Vw_personas_solo_cep where 
                    c_cmp between '" . $desde . "' and '" . $hasta . "' order by c_cmp";
        } else {
            $sql = "SELECT rtrim(C_REG_ESP) AS c_reg_esp,rtrim(c_cmp) as c_cmp,rtrim(C_LOCAL) AS c_local_colegiacion,
                    RTRIM(nombre) AS nombre,
                    rtrim(num_documento) as num_documento,
                    dbo.fc_fecha_texto(fecha) as fecha,literal,
                    cod_sexo,residentado, semipresencial, flag_escolarizado
                    From vw_personas_especialidad 
                    WHERE tipo = '" . $tipo . "'
                    and c_reg_esp between '" . $desde . "' and '" . $hasta . "' 
                    ORDER BY c_reg_esp ";
        }

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function resolucion_data($tipo, $desde, $hasta)
    {

        if ($tipo == "C") {
            $sql = "SELECT p.c_cmp,p.c_local_colegiacion,p.nombre,
                    rtrim(p.num_documento) as num_documento,
                    dbo.fc_fecha_texto(fecha_de_inicio)as fecha, 
                    p.cod_sexo,l.nombre1,
                    YEAR(fecha_de_inicio) as c_year,
                    p.N_RESOLUCION_cole,
                    p.n_libro_cole,
                    p.n_folio_cole 
                    from Vw_personas_solo_cep p inner join local l with (nolock) 
                    on l.c_local=p.c_local 
                    where c_cmp between '" . $desde . "' and '" . $hasta . "' order by c_cmp";
        } else {
            $sql = "SELECT PE.C_REG_ESP AS c_reg_esp,
            p.c_cmp,p.apellido_paterno,p.apellido_materno,
            p.nombre1 as na,p.nombre2 as nb,
            rtrim(PE.C_LOCAL) AS c_local_colegiacion,
            RTRIM(P.nombre) AS nombre ,rtrim(p.num_documento) as num_documento,
            dbo.fc_fecha_texto(pe.fecha)as fecha, 
            pe.literal
            ,pe.n_libro_cole,pe.n_folio_cole,p.c_persona,
            p.cod_sexo,pe.residentado
            From personas P(nolock) 
            INNER JOIN Personas_especialidad PE (NOLOCK) 
            ON P.C_PERSONA=PE.C_PERSONA 
            WHERE SUBSTRING(pe.c_especialidad,1,1)='" . $tipo . "'
            and pe.c_reg_esp between '" . $desde . "' and '" . $hasta . "'
            ORDER BY pe.c_reg_esp ";
        }
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar_cemd_rango($grado, $desde)
    {

        if ($grado == "C") {
            $sql = "SELECT c_cmp, dbo.fc_fecha_texto(fecha_de_inicio) AS fecha, c_local,  c_local_colegiacion,RTRIM(nombre) as nombre from Vw_personas_solo_cep
            where c_cmp between " . $desde . " and " . $desde . "+300 order by c_cmp ";
        } else {
            $sql = "SELECT dbo.fc_fecha_texto(fecha) as fecha,
            C_REG_ESP AS c_cmp,rtrim(C_LOCAL) AS c_local_colegiacion,RTRIM(nombre)
            AS nombre 
            From vw_personas_especialidad
            WHERE tipo='" . $grado . "'
            and c_reg_esp between " . $desde . " and " . $desde . "+300 
            ORDER BY c_reg_esp ";
        }

        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ultimos($tipo, $c_local_colegiacion = '')
    {
        if ($tipo == "C") {
            $sql = "SELECT c_cmp,nombre,c_local_colegiacion,
                    dbo.fc_fecha_texto(fecha_de_inicio) AS fecha_de_inicio 
                    from Vw_personas_solo_cep where YEAR(fecha_de_inicio) = YEAR(GETDATE())
                    AND c_local_colegiacion LIKE '%" . $c_local_colegiacion . "%' order by c_cmp desc";
        } else {
            $sql = "SELECT c_reg_esp as c_cmp,nombre,c_local as c_local_colegiacion,
                    dbo.fc_fecha_texto(fecha) AS fecha_de_inicio,literal
                    from vw_personas_especialidad
                    where tipo='" . $tipo . "' and c_local LIKE '%" . $c_local_colegiacion . "%' and year(fecha) = year(getdate()) order by c_reg_esp desc";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar_cemd($cr, $grado)
    {
        if ($cr == "") {
            $cr = "%";
        }
        if ($grado == "C") {
            $sql = "SELECT local.c_local, local.nombre1, COUNT(*) as cantidad
            FROM personas(NOLOCK)
            INNER JOIN local (NOLOCK) ON LOCAL.c_local=personas.c_local_colegiacion 
            WHERE ISNUMERIC(personas.c_cmp)=1 and personas.c_local_colegiacion like '%" . $cr . "%'
            GROUP BY local.c_local, local.nombre1
            ORDER BY local.c_local, local.nombre1";
        } else {
            $sql = "SELECT local.c_local,local.nombre1,COUNT(*) as cantidad FROM personas_especialidad(NOLOCK) INNER JOIN local (NOLOCK)
            ON LOCAL.c_local=personas_especialidad.C_LOCAL 
            WHERE SUBSTRING(personas_especialidad.c_especialidad,1,1)='" . $grado . "'
            GROUP BY local.c_local,local.nombre1
            ORDER BY local.c_local,local.nombre1  ";
        }

        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar_cemd_historico($c_local, $tipo)
    {
        $sql = "SELECT c_year,
            isnull(sum(ene),0) as ene,
            isnull(sum(feb),0) as feb,
            isnull(sum(mar),0) as mar,
            isnull(sum(abr),0) as abr,
            isnull(sum(may),0) as may,
            isnull(sum(jun),0) as jun,
            isnull(sum(jul),0) as jul,
            isnull(sum(ago),0) as ago,
            isnull(sum(sep),0) as sep,
            isnull(sum(oct),0) as oct,
            isnull(sum(nov),0) as nov,
            isnull(sum(dic),0) as dic ,
            isnull(sum(ene),0) +
            isnull(sum(feb),0) +
            isnull(sum(mar),0) +
            isnull(sum(abr),0) +
            isnull(sum(may),0) +
            isnull(sum(jun),0) +
            isnull(sum(jul),0) +
            isnull(sum(ago),0) +
            isnull(sum(sep),0) +
            isnull(sum(oct),0) +
            isnull(sum(nov),0) +
            isnull(sum(dic),0)  as total";
        switch ($tipo) {
            case "C":
                $sql .= " from v_colegiados_por_year_mes where c_local_colegiacion like '%" . $c_local . "%' group by c_year order by c_year desc";
                break;
            default:
                $sql .= " from v_grados_por_year_mes where c_local like '%" . $c_local . "%' and tipo_ESPECIALIDAD='" . $tipo . "' group by c_year order by c_year desc  ";
                break;
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function buscarpre_matri(gen_personas $obj)
    {
        $sql = "SELECT top(250) dbo.fc_fecha_texto(fecha_proceso) as fecha,
                UPPER(rtrim(w.apellido_paterno))+' '+UPPER(rtrim(w.apellido_materno))+' '+UPPER(rtrim(w.nombre1))+' '+UPPER(rtrim(w.nombre2)) as nombre_completo,
                w.c_persona  ,w.cod_documento ,w.c_persona as num_documento,W.c_usuario,w.c_region ,
                w.recaudo,
                -- ISNULL('BBVA-'+BBVA.FECHA_PAGO,'BCP-'+BCP.FECHA) recaudo,
                w.cod_bancario
                from web_tram_colegiacion w (NOLOCK)
                inner join web_tram_colegiacion_control co (NOLOCK) on co.c_persona=w.c_persona AND co.codigo='CR' AND co.estado='A'
                left join Personas p (NOLOCK) on p.num_documento = w.num_documento and p.c_cmp is null
                -- LEFT JOIN bcp_proceso_detalle BCP (NOLOCK) ON BCP.codigo_depositante=REPLICATE('0',14-LEN(rtrim(P.num_documento)))+rtrim(P.num_documento)
                -- left JOIN bbva_proceso_detalle BBVA (NOLOCK) ON substring(BBVA.referencia2,1,3)='M04' and ISNUMERIC(rtrim(p.num_documento))=1 and REPLICATE('0',14-LEN(rtrim(BBVA.referencia1)))+rtrim(BBVA.referencia1)=REPLICATE('0',14-LEN(rtrim(P.num_documento)))+rtrim(P.num_documento)
                where  (p.c_cmp IS NULL AND ISNUMERIC(p.c_persona)=1)
                AND (co.codigo='CR' AND co.estado='A')
                AND co.fecha IS NOT NULL
                AND UPPER(rtrim(w.apellido_paterno))+' '+UPPER(rtrim(w.apellido_materno))+' '+UPPER(rtrim(w.nombre1))+' '+UPPER(rtrim(w.nombre2)) like UPPER('%{$obj->getNombre()}%')";
        if (!empty($obj->getC_local())) {
            $sql .= " AND w.c_region = '{$obj->getC_local()}'";
        }
        if (!empty($obj->getDesde()) && !empty($obj->getHasta())) {
            $sql .= " AND co.fecha BETWEEN '{$obj->getDesde()} 00:00:00' AND '{$obj->getHasta()} 23:59:59'";
        }
        if (!empty($obj->getNum_documento())) {
            $sql .= " AND w.num_documento LIKE '%{$obj->getNum_documento()}%'";
        }
        if (!empty($obj->getRecaudo())) {
            $sql .= " AND w.cod_bancario='{$obj->getRecaudo()}'";
        }
        $sql .= "  ORDER BY w.c_persona";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    function listar_exo_total($cr)
    {
        $sql = "SELECT l.nombre,l.c_local,
                sum(case when e.motivo='01' then 1 else 0 end) as personal,
                sum(case when e.motivo='02' then 1 else 0 end) as trabajo,
                sum(case when e.motivo='03' then 1 else 0 end) as estudios,
                sum( 1) as total from personas_exoneraciones e 
                inner join Personas p on p.c_persona=e.c_persona
                inner join local l on l.c_local=p.c_local
                where l.c_local like '%" . $cr . "%' 
                group by l.nombre,l.c_local order by l.c_local";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    function listar_exo_detalle($cr)
    {
        $sql = "SELECT e.motivo, dbo.fc_v1_parametro_valor('personas_exoneraciones','motivo',e.motivo) as motivo_text,
                DBO.fc_fecha_Texto(e.fecha) as fecha,e.mes_salida,e.year_salida,e.mes_retorno,e.year_retorno,rtrim(e.sustento) as sustento,
                e.usuario,e.flag_no_retorno,
                p.c_cmp,p.nombre,p.c_local from personas_exoneraciones e
                left join Personas p on p.c_persona=e.c_persona
                where p.c_local like '%" . $cr . "%' 
                order by DBO.fc_fecha_from(e.fecha) desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    function listarPersonasBajaRegistro($desde)
    {
        $sql = "SELECT pb.cc_baja c_cmp, p.c_local c_local_colegiacion, p.nombre FROM Personas p
                INNER JOIN personas_baja pb ON p.c_persona = pb.c_persona
                INNER JOIN personas_suspendidas ps ON p.c_persona = ps.c_persona
                WHERE ISNUMERIC(p.C_CMP)=1 AND p.flag_activo = 'D' AND pb.cc_baja between $desde and  $desde+300;";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    //DASHBOARD COLEGIACION
    function listaResumenColegiadosDashboard($c_local = "", $anho = "")
    {
        $sql = "SELECT
                COUNT(flag_activo) colegiados,
                SUM(CASE WHEN flag_activo = 'A' THEN 1 ELSE 0 END) activos,
                SUM(CASE WHEN flag_activo = 'C' THEN 1 ELSE 0 END) cesante,
                SUM(CASE WHEN flag_activo = 'F' THEN 1 ELSE 0 END) fallecido,
                SUM(CASE WHEN flag_activo = 'B' THEN 1 ELSE 0 END) exo_70,
                SUM(CASE WHEN flag_activo = 'V' THEN 1 ELSE 0 END) exo_viaje
                FROM Vw_personas_solo_cep where c_local like '%$c_local%'";
        $sql .= !empty($anho) ? " AND (fecha_de_inicio >= '01/01/$anho' AND fecha_de_inicio < '31/12/$anho')" : "";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    function listaResumenGradosColegiadosDashboard($c_local = "", $anho = "")
    {
        $sql = "SELECT
                SUM(CASE WHEN tipo = 'E' THEN 1 ELSE 0 END) especialidad,
                SUM(CASE WHEN tipo = 'M' THEN 1 ELSE 0 END) maestria,
                SUM(CASE WHEN tipo = 'D' THEN 1 ELSE 0 END) doctorado,
                SUM(CASE WHEN tipo = 'A' THEN 1 ELSE 0 END) auditoria,
                SUM(CASE WHEN tipo = 'N' THEN 1 ELSE 0 END) lactancia,
                SUM(CASE WHEN tipo = 'P' THEN 1 ELSE 0 END) posdoctorado,
                SUM(CASE WHEN tipo = 'J' THEN 1 ELSE 0 END) conciliador
                FROM vw_personas_especialidad where c_local like '%" . $c_local . "%'";
        $sql .= !empty($anho) ? " AND (fecha >= '01/01/$anho' AND fecha < '31/12/$anho')" : "";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    function listaResumenAnualColegiadosDashboard($c_local = "", $anho = "")
    {
        $sql = "SELECT
            isnull(sum(ene),0) as ene,
            isnull(sum(feb),0) as feb,
            isnull(sum(mar),0) as mar,
            isnull(sum(abr),0) as abr,
            isnull(sum(may),0) as may,
            isnull(sum(jun),0) as jun,
            isnull(sum(jul),0) as jul,
            isnull(sum(ago),0) as ago,
            isnull(sum(sep),0) as sep,
            isnull(sum(oct),0) as oct,
            isnull(sum(nov),0) as nov,
            isnull(sum(dic),0) as dic
            from v_colegiados_por_year_mes
            where c_local_colegiacion like '%$c_local%' AND c_year LIKE '%$anho%';";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    function listaResumenSexoEtareoColegiadosDashboard($c_local = "", $anho = "")
    {
        $sql = "SELECT
                CASE
                    WHEN edad BETWEEN 20 AND 29 THEN '20-29'
                    WHEN edad BETWEEN 30 AND 39 THEN '30-39'
                    WHEN edad BETWEEN 40 AND 49 THEN '40-49'
                    WHEN edad BETWEEN 50 AND 59 THEN '50-59'
                    WHEN edad BETWEEN 60 AND 69 THEN '60-69'
                    ELSE '70+'
                END AS rango_edad,
                cod_sexo,
                COUNT(*) AS cantidad
                FROM (
                    SELECT
                        DATEDIFF(YEAR,fecha_de_nacimiento , GETDATE())
                        - CASE
                            WHEN DATEADD(YEAR,
                                        DATEDIFF(YEAR, fecha_de_nacimiento, GETDATE()),
                                        fecha_de_nacimiento) > GETDATE()
                            THEN 1
                            ELSE 0
                        END AS edad,
                        cod_sexo
                    FROM Vw_personas_solo_cep
                    where c_local like '%$c_local%' AND flag_activo <> 'F'";
        $sql .= !empty($anho) ? " AND (fecha_de_inicio >= '01/01/$anho' AND fecha_de_inicio < '31/12/$anho')" : "";
        $sql .= " ) t
                GROUP BY
                    CASE
                        WHEN edad BETWEEN 20 AND 29 THEN '20-29'
                        WHEN edad BETWEEN 30 AND 39 THEN '30-39'
                        WHEN edad BETWEEN 40 AND 49 THEN '40-49'
                        WHEN edad BETWEEN 50 AND 59 THEN '50-59'
                        WHEN edad BETWEEN 60 AND 69 THEN '60-69'
                        ELSE '70+'
                    END,
                    cod_sexo
                ORDER BY MAX(edad);";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function Actualiza_deuda($c_persona)
    {
        return $this->dao->Actualiza_deuda($c_persona);
    }
}
