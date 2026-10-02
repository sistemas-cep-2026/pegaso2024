<?php
require_once(u_src() . "dao/dao_general.php");
class bo_general
{

    private $dao;

    function __construct()
    {
        $this->dao = new dao_general();
    }

    /*public function listarRegiones()
    {
        $sql = "SELECT c_local,
        nombre, 
        nombre_abv,
        local_direc,
        local_tel,
        local_mail
        FROM gen_local(nolock)
        WHERE adm='*'
        order by cast(c_local as int) asc";
        return $this->dao->consulta($sql);
    }*/
    public function RegionID($cc_local)
    {
        $sql = "SELECT c_local,
        rtrim(nombre) as nombre,
        nombre_abv,
        local_direc,
        local_tel,
        local_mail ,
        distrito
        FROM gen_local (nolock)
        WHERE c_local='" . $cc_local . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function AreaAdministrativa($sede)
    /**Areas**/
    {
        $sql = "SELECT rtrim(cc_area_adm) as cc_area_adm,
        nombre
        FROM gen_area_adm (nolock) 
        WHERE cc_area_adm <>'...'
        and sede='" . $sede . "'
        and flag='A'
        order by nombre asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function AreaAdministrativa_dieta()
    /**Areas dietas**/
    {
        $sql = "SELECT rtrim(cc_area_adm) as cc_area_adm,
        nombre
        FROM gen_area_adm (nolock) 
        where cc_area_adm in ('000006','000007','000008','000002','000033','000020','000021','000022','000023')       
        order by nombre asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function personal_areaAdministrativa($cc_local, $cc_area_adm)
    {
        $sql = "SELECT rtrim(u.usuario) as usuario,
        RTRIM(p.nombre) as nombre
        FROM seg_usuarios u
        INNER JOIN Personas p ON p.c_persona = u.cc_persona
        WHERE u.cc_local = '{$cc_local}'
        AND u.c_area = '{$cc_area_adm}'
        AND u.flag = 'A'
        ORDER BY p.nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarRegionesAdministrativo($cc_local, $usuario, $tipo = 'A')
    {
        if ($cc_local == 28 && $tipo == 'A') {
            $sql = "SELECT   c_local, nombre, nombre_abv, local_direc, local_tel, local_mail 
            FROM gen_local WITH (NOLOCK)
            WHERE isnumeric(c_local)=1 and c_local<>'..' and flag_administrativo='*'
            ORDER BY 
            CASE WHEN c_local = 28 THEN 0 ELSE 1 END,
            c_local ASC";
        } elseif ($cc_local == 28 && $tipo == 'C') {
            $sql = "SELECT c_local, nombre, nombre_abv, local_direc, local_tel, local_mail
            FROM gen_local WITH (NOLOCK)
            WHERE flag_administrativo='*'
            ORDER BY c_local ASC";
        } else {
            $sql = " SELECT l.c_local, l.nombre, l.nombre_abv
            FROM gen_local l WITH (NOLOCK)
            INNER JOIN gen_local_vinculado v WITH (NOLOCK)
            ON l.c_local = v.cc_local_vinculado
            WHERE v.usuario = '{$usuario}'
            ORDER BY l.c_local ASC";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar28Regiones()
    {
        $sql = "SELECT c_local,
        nombre, 
          nombre1,
        nombre_abv,
        local_direc,
        local_tel,
        local_mail,porc_cotizacion
        FROM gen_local (nolock)
        WHERE adm = '*'
        AND c_local <> 28
        ORDER BY c_local ASC";
        return $this->dao->consulta($sql);
    }

    public function listarPeriodos($cc_local)
    {
        $sql = "SELECT pl.c_ano,
    pl.c_mes,
    pl.c_ano+pl.c_mes as periodo
    FROM periodos_local pl inner join periodos pd 
    on pd.c_ano=pl.c_ano 
    and pd.c_mes=pl.c_mes
    WHERE pl.c_local='" . $cc_local . "' 
    and pl.flag_cierre_compras='&'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function periodos_recaudadoras($periodo)
    {/*para saber si esta pendiente o conciliado*/
        $sql = "SELECT pla_essalud, 
    recaudo_bcp_666 as bcp, 
    recaudo_bbva_571 as bbva
    FROM periodos 
    WHERE c_ano+c_mes='{$periodo}'";
        return $this->dao->consulta($sql);
    }

    public function periodo_activo_compras($cc_local, $c_year, $c_periodo)
    {
        $sql = "SELECT count(*) cantidad
    FROM periodos_local pl inner join periodos pd 
    on pd.c_ano=pl.c_ano 
    and pd.c_mes=pl.c_mes
    WHERE pl.c_local='" . $cc_local . "' and pl.c_mes='" . $c_periodo . "' and pl.c_ano='" . $c_year . "'
    and pl.flag_cierre_compras='&'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPeriodos_comp_banco($cc_local)
    {
        $sql = "SELECT pl.c_ano,
    pl.c_mes,
    pl.c_ano+pl.c_mes as periodo
    FROM periodos_local pl inner join periodos pd 
    on pd.c_ano=pl.c_ano 
    and pd.c_mes=pl.c_mes
    WHERE pl.c_local='" . $cc_local . "' and pl.c_mes between 1 and 12
    and pl.flag_cierre_compras='&' order by pl.c_ano desc,
    pl.c_mes desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function univeridadID($c_universidad)
    {
        $sql = "SELECT c_universidad, rtrim(nombre) as nombre_univ
                FROM universidad
                WHERE c_universidad='" . $c_universidad . "'";
        return $this->dao->consulta($sql);
    }

    public function listarUniversidad()
    {
        $sql = "SELECT c_universidad, nombre, ID_UNIV FROM universidad";
        return $this->dao->consulta($sql);
    }

    public function listarPais()
    {
        $sql = "SELECT cc_pais, 
                nombre, 
                codigo
                FROM gen_pais";
        return $this->dao->consulta($sql);
    }

    public function ListarCuentasContables($c_cuenta)
    {
        $sql = "SELECT rtrim(c_cuenta) as c_cuenta,
    rtrim(c_cuenta) +' '+ rtrim(nombre) as nombre_cuenta
    FROM plan_de_cuentas_year
    WHERE version='5'
    and (c_cuenta like '{$c_cuenta}%' or nombre like '%{$c_cuenta}%') and len(c_cuenta)=10
    and flag_general_movimiento='M'";
        return $this->dao->consulta($sql);
    }

    public function ListarCuentasContablesCompras($c_cuenta)
    {
        $sql = "SELECT rtrim(c_cuenta) as c_cuenta,
    rtrim(c_cuenta) +' '+ rtrim(nombre) as nombre_cuenta
    FROM plan_de_cuentas_year
    WHERE version='5'
    and substring(c_cuenta,1,2) in ('16','18','30','31','32','33','34','35','40','41','42','43','44','46','60','61','62','63','64','65')
    and (c_cuenta like '{$c_cuenta}%' or nombre like '%{$c_cuenta}%') and len(c_cuenta)=10
    and flag_general_movimiento='M'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarCuentasContablesBancosEgreso($c_cuenta)
    {
        $sql = "SELECT rtrim(c_cuenta) as c_cuenta,
    rtrim(c_cuenta) +' '+ rtrim(nombre) as nombre_cuenta
    FROM plan_de_cuentas_year
    WHERE version='5'
    and (substring(c_cuenta,1,2) in ('16','18','30','31','32','33','34','35','40','41','42','43','44','46','60','61','62','63','64','65','67') or 
    substring(c_cuenta,1,3) in ('103','102'))
    and (c_cuenta like '{$c_cuenta}%' or nombre like '%{$c_cuenta}%') and len(c_cuenta)=10
    and flag_general_movimiento='M'";
        return $this->dao->consulta($sql);
    }

    public function ListarCuentasContablesBancosIngreso($c_cuenta)
    {
        $sql = "SELECT rtrim(c_cuenta) as c_cuenta,
    rtrim(c_cuenta) +' '+ rtrim(nombre) as nombre_cuenta
    FROM plan_de_cuentas_year
    WHERE version='5'
    and (substring(c_cuenta,1,2) in ('16','46','70','71','72','73','74','75','76','77') or 
    substring(c_cuenta,1,3) in ('103','102'))
    and (c_cuenta like '{$c_cuenta}%' or nombre like '%{$c_cuenta}%') and len(c_cuenta)=10
    and flag_general_movimiento='M'";
        return $this->dao->consulta($sql);
    }
    /*****CUENTAS BANCARIAS CONTABILIDAD******/
    public function ListarcuentasBancarias($c_local, $c_banco, $c_cuenta, $flag_colegiacion = '')
    {
        $sql = "SELECT b.nombre,
        RTRIM(cc.c_banco) c_banco,
        RTRIM(cc.c_cta_corriente) c_cta_corriente,
        rtrim(b.c_banco)+'-'+rtrim(cc.c_cta_corriente) as banco_cta, 
        cc.c_cuenta_pcge2014
        FROM gen_cuentas_corrientes cc 
        inner join gen_bancos b 
        on b.c_banco=cc.c_banco
        WHERE cc.c_local='" . $c_local . "'
        and cc.c_cuenta_pcge2014 is not null";
        if (!empty($c_banco)) {
            $sql .= " and b.c_banco='" . $c_banco . "' and cc.c_cta_corriente='" . $c_cuenta . "' ";
        }
        if (!empty($flag_colegiacion)) {
            $sql .= " and cc.flag_colegiacion='" . $flag_colegiacion . "' ";
        }
        $sql .= " order by  b.nombre,cc.c_banco,cc.c_cta_corriente";
       echo $sql;
        return $this->dao->consulta($sql);
    }
    public function ListarcuentasBancarias_activas($c_local, $c_banco, $c_cuenta, $flag_colegiacion = '')
    {
        $sql = "SELECT b.nombre,
        RTRIM(cc.c_banco) c_banco,
        RTRIM(cc.c_cta_corriente) c_cta_corriente,
        rtrim(b.c_banco)+'-'+rtrim(cc.c_cta_corriente) as banco_cta, 
        cc.c_cuenta_pcge2014
        FROM gen_cuentas_corrientes cc 
        inner join gen_bancos b 
        on b.c_banco=cc.c_banco
        WHERE cc.c_local='" . $c_local . "'
        and cc.c_cuenta_pcge2014 is not null
        and cc.flag_activo='&'
                ";
        if (!empty($c_banco)) {
            $sql .= " and b.c_banco='" . $c_banco . "' and cc.c_cta_corriente='" . $c_cuenta . "' ";
        }
        if (!empty($flag_colegiacion)) {
            $sql .= " and cc.flag_colegiacion='" . $flag_colegiacion . "' ";
        }
        $sql .= " order by  b.nombre,cc.c_banco,cc.c_cta_corriente";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    /*****crear asienstos*****/
    public function subdiario()
    {
        $sql = "SELECT s.c_subdiario,   
    s.c_subdiario+' - '+s.nombre AS nombre
    FROM gen_subdiarios s  (NOLOCK)
    WHERE s.c_subdiario <> '..' ";
        return $this->dao->consulta($sql);
    }
    /*****crear asienstos*****/

    public function tipo_documento($tipo = '')
    {
        $sql = "SELECT rtrim(c_tipo_de_documento) as c_tipo_de_documento,
        c_tipo_de_documento+' - '+nombre  as nombre
        FROM gen_tipo_de_documentos (nolock) 
        WHERE c_tipo_de_documento <> '..'";
        if (!empty($tipo)) {
            $sql .= " and tramite= '" . $tipo . "' ";
        }

        return $this->dao->consulta($sql);
    }

    public function listarCargos()
    {
        $sql = "SELECT rtrim(c_cargo) as c_cargo, 
                nombre 
                FROM gen_cargos 
                WHERE flag = '*' 
                ORDER BY nombre";

        return $this->dao->consulta($sql);
    }

    public function tram_accion()
    {
        $sql = "SELECT c_accion, 
                nombre_accion 
                FROM tram_acciones";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPeridosContables()
    {
        $sql = "SELECT RIGHT('0' + CAST(c_mes AS VARCHAR(2)), 2) + '/' + CAST(c_ano AS VARCHAR(4)) AS data
                FROM periodos
                WHERE ISNUMERIC(c_mes) = 1 
                AND ISNUMERIC(c_ano) = 1
                AND CAST(c_mes AS INT) BETWEEN 1 AND 12
                AND (CAST(c_ano AS INT) * 100 + CAST(c_mes AS INT)) >= 200812
                AND (CAST(c_ano AS INT) * 100 + CAST(c_mes AS INT)) <= (YEAR(GETDATE()) * 100 + MONTH(GETDATE()))
                ORDER BY CAST(c_ano AS INT) * 100 + CAST(c_mes AS INT) DESC";
        return $this->dao->consulta($sql);
    }

    public function local_procentajeBcp($periodo)
    { /*lista cc_local y porcentaje de aportaciones*/
        $sql = "SELECT l.porc_cotizacion,
        p.c_local,
        l.nombre1
        FROM bcp_proceso_detalle p (nolock) 
        inner join local l(nolock) 
        on l.c_local=p.c_local 
        WHERE substring(p.fecha,1,6)='" . $periodo . "'
        AND p.c_local like '%' 
        group by l.porc_cotizacion,p.c_local ,l.nombre1 
        order by p.c_local ,l.nombre1";
        return $this->dao->consulta($sql);
    }

    public function local_procentajeBbva($periodo)
    { /*lista cc_local y porcentaje de aportaciones*/
        $sql = "SELECT l.porc_cotizacion,
        p.c_local,
        l.nombre1
        FROM bbva_proceso_detalle p (nolock) 
        inner join local l(nolock) 
        on l.c_local=p.c_local 
        WHERE substring(p.fecha_pago,1,6)='" . $periodo . "' 
        AND p.c_local like '%' 
        group by l.porc_cotizacion,p.c_local ,l.nombre1 
        order by p.c_local ,l.nombre1";
        return $this->dao->consulta($sql);
    }

    // funcion ubigeo
    public function listarUbigeoAgrupado($nombre = '')
    {
        $sql = "SELECT
        (d.cc_dpto+p.cc_prov+di.cc_dist) AS cc_ubigeo,
        d.cc_dpto,
        p.cc_prov,
        di.cc_dist,
        (d.nombre+ ' - '+ p.nombre+ ' - '+ di.nombre) AS nombre_ubigeo
        FROM gen_ubigeo d
        JOIN gen_ubigeo p 
        ON d.cc_dpto = p.cc_dpto AND p.cc_prov <> '00' AND p.cc_dist = '00'
        JOIN gen_ubigeo di 
        ON p.cc_dpto = di.cc_dpto AND p.cc_prov = di.cc_prov AND di.cc_dist <> '00'
        WHERE d.cc_prov = '00' AND d.cc_dist = '00'
        AND (d.nombre+ ' - '+ p.nombre+ ' - '+ di.nombre) LIKE '%$nombre%'
        ORDER BY d.cc_dpto, p.cc_prov, di.cc_dist";
        return $this->dao->consulta($sql);
    }

    public function listarPagosRecaudoGradosXPersona($cc_persona)
    {
        $sql = "SELECT b.id,b.referencia2, dbo.fc_fecha_texto(b.fecha_pago) fecha_pago,
                b.total, b.num_movimiento, pee.id_recaudo_bbva
                FROM bbva_proceso_detalle b (NOLOCK)
                LEFT JOIN Personas_especialidad pee (NOLOCK) ON b.id = pee.id_recaudo_bbva
                WHERE SUBSTRING(b.fecha_pago,1,4) >2024
                AND SUBSTRING(b.REFERENCIA2,1,1)='T'
                AND SUBSTRING(b.REFERENCIA2,1,3) IN ('T01','T02','T03','T04','T05','T06','T07')
                AND b.c_persona='$cc_persona'
                AND pee.id_recaudo_bbva IS NULL;";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarPagosRecaudoTramitesXPersona($cc_persona)
    {
        $sql = "SELECT b.id,b.referencia2, dbo.fc_fecha_texto(b.fecha_pago) fecha_pago,
                b.total, b.num_movimiento, trr.id_recaudo_bbva
                FROM bbva_proceso_detalle b (NOLOCK)
                LEFT JOIN tram_documentos_recaudo trr (NOLOCK) ON b.id = trr.id_recaudo_bbva
                WHERE SUBSTRING(b.fecha_pago,1,4) >2024
                AND SUBSTRING(b.REFERENCIA2,1,1)='T'
                 AND SUBSTRING(b.REFERENCIA2,1,3) NOT IN ('T01','T02','T03','T04','T05','T06','T07')
                AND b.c_persona='$cc_persona'
                AND trr.id_recaudo_bbva IS NULL";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarGestionActiva()
    {
        $sql = "SELECT cod, fecha_ini, fecha_fin 
        FROM gestiones_directivas 
        WHERE flag ='*' order by cod ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function estadoCuentasRecaudos($cod_ano, $cod_mes) //*********Estado de la cuenta recaudadora********* */
    {
        $sql = "SELECT 
        c_ano,
        c_mes,
        CASE 
            WHEN pla_essalud = 0 THEN 'Pendiente'
            WHEN pla_essalud = 9 THEN 'Conciliado'
            ELSE 'Otro valor'
        END AS estado_pla_essalud,
        CASE 
            WHEN recaudo_bcp_666 = 0 THEN 'Consiliación Pendiente'
            WHEN recaudo_bcp_666 = 9 THEN 'Conciliado'
            ELSE 'Otro valor'
        END AS estado_recaudo_bcp_666,
        CASE 
            WHEN recaudo_bbva_571 = 0 THEN 'Pendiente'
            WHEN recaudo_bbva_571 = 9 THEN 'Conciliado'
            ELSE 'Otro valor'
        END AS estado_recaudo_bbva_571
        FROM periodos
        WHERE c_ano = '{$cod_ano}'
        AND c_mes = '{$cod_mes}'";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarTramitesRecaudo()
    {
        $sql = "SELECT cc_concepto, 
        tra_titulo,
        rcd_concepto,
        cod_tram_recaudo
        FROM web_tram_otrostramites 
        WHERE tra_estado = '1'AND TIPO = 'T';";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarEntidadesPagadoras($c_local)
    {
        $sql = "SELECT c_entidad_pagadora, c_sector_entidad_pagadora, c_local, nombre nombre_entidad_pagadora
		        FROM entidad_pagadora (NOLOCK) WHERE c_local = '$c_local';";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarVinculoLaboral()
    {
        $sql = "SELECT cod_condicion_laboral, condicion_laboral, planilla
		        FROM condicion_laboral (NOLOCK)";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarSancionesPersonas($c_persona)
    {
        $sql = "SELECT c_persona, sancion, resol1, resol2, desde, hasta, url, flag
		        FROM personas_suspendidas (NOLOCK) WHERE c_persona = '$c_persona'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
