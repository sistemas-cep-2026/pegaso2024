<?php
require_once dirname(__DIR__) . '/dao/dao_tram_personas_especialidad.php';
class bo_tram_personas_especialidad
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_personas_especialidad();
    }

    public function control(tram_personas_especialidad $obj, $opc)
    {
        switch ($opc) {
            case "I":
            case "U":
                return $this->dao->insertar($obj);
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function max_numero()
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listar(tram_personas_especialidad $obj = null)
    {
        $sql = "";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarXPersona(tram_personas_especialidad $obj)
    {
        $sql = "SELECT 
                pes.c_persona,
                pes.TIPO_ESPECIALIDAD,
                pes.linea,
                pes.c_universidad,
                pes.c_especialidad,
                RTRIM(pes.c_reg_esp) c_reg_esp,
                DBO.fc_fecha_Texto(pes.fecha) fecha,
                pes.c_local,
                pes.flag_escolarizado,
                pes.n_libro_cole,
                pes.n_folio_cole,
                pes.tipo_especialidad,
                DBO.fc_fecha_Texto(pes.fecha_diploma) fecha_diploma,
                pes.c_especialidad_res,
                pes.literal,
                pes.residentado,
                pes.semipresencial,
                pes.nombre mencion,
                et.nombre tipo_nombre_esp
                FROM personas_especialidad pes (NOLOCK)
                INNER JOIN especialidad_tipo et (NOLOCK) ON pes.tipo_especialidad = et.tipo_especialidad
                WHERE pes.c_persona='{$obj->getCc_persona()}'
                ORDER BY pes.tipo_especialidad,
                pes.c_reg_esp,
                pes.c_especialidad;";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function gradoPersona($c_persona, $tipo)
    {
        $sql = "SELECT pe.c_persona,
        pe.c_universidad,
        pe.c_especialidad,
        rtrim(c_reg_esp) as c_reg_esp,
        dbo.fc_fecha_Texto(pe.fecha) as fecha,
        pe.c_local, 
        pe.flag_escolarizado,
        pe.n_libro_cole,
        pe.semipresencial,
        pe.n_folio_cole,
        pe.tipo_especialidad,
        dbo.fc_fecha_Texto(pe.fecha_diploma) as fecha_diploma,
        pe.c_especialidad_res,
        e.nombre,
        pe.literal,
        pe.residentado 
        from personas_especialidad pe (nolock) inner join especialidad e
        on e.cc_especialidad=pe.cc_especialidad
        where pe.c_persona='" . $c_persona . "' and pe.tipo_especialidad='" . $tipo . "'
        order by pe.tipo_especialidad,
        pe.c_reg_esp,
        pe.c_especialidad";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarIDLinea(tram_personas_especialidad $obj)
    {
        $sql = "SELECT pe.c_persona,
        pe.c_universidad,
        pe.c_especialidad,
        pe.linea,
        rtrim(pe.c_reg_esp) as c_reg_esp,
        dbo.fc_fecha_texto(pe.fecha) as fecha,
        pe.c_local, 
        pe.flag_escolarizado,
        pe.n_libro_cole,
        pe.semipresencial,
        pe.n_folio_cole,
        pe.tipo_especialidad,
        dbo.fc_fecha_texto(pe.fecha_diploma) as fecha_diploma,
        pe.c_especialidad_res,
        pe.literal,
        pe.residentado,
        pe.flag_regularizado,
        pe.obs
        FROM personas_especialidad pe (NOLOCK)
        WHERE pe.c_persona='{$obj->getCc_persona()}'
        AND pe.linea='{$obj->getLinea()}' AND pe.tipo_especialidad='{$obj->getTipo_especialidad()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarReporteGradosRecaudo(tram_personas_especialidad $obj)
    {
        $sql = "SELECT dbo.fc_fecha_texto(pp.fecha) fecha_registro, pp.c_local, pp.c_reg_esp, pp.banco, pp.operacion, dbo.fc_fecha_texto(pp.fecha_op) fecha_op,
                pp.monto, pp.banco2, pp.operacion2, dbo.fc_fecha_texto(pp.fecha_op2) fecha_op2, pp.monto2, pp.flag_regularizado,
                p.nombre, p.c_cmp, b.id, b.referencia2, dbo.fc_fecha_texto(b.fecha_pago) fecha_pago,
                b.total, b.num_movimiento, te.nombre nombre_grado
                from Personas_especialidad pp
                INNER JOIN personas p (NOLOCK) ON pp.c_persona = p.c_persona
                INNER JOIN Especialidad_tipo te (NOLOCK) ON pp.TIPO_ESPECIALIDAD = te.tipo_especialidad
                left JOIN bbva_proceso_detalle b (NOLOCK) ON b.id = pp.id_recaudo_bbva
                WHERE fecha BETWEEN '{$obj->getDesde()}' AND '{$obj->getHasta()}'
                ORDER BY pp.fecha";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
