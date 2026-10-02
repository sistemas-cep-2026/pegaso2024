<?php
require_once dirname(__DIR__) . '/dao/dao_tram_honorabilidad.php';
class bo_tram_honorabilidad
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_honorabilidad();
    }

    public function control(tram_honorabilidad $obj, $opc)
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
            case "A":
                return $this->dao->anular($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listarAnhos()
    {
        $sql = "SELECT DISTINCT anho
            FROM tram_honorabilidad
            ORDER BY anho desc";
        return $this->dao->consulta($sql);
    }

    public function max_numero()
    {
        $sql = "select max(numero+1) numero 
        from tram_honorabilidad (nolock)";
        return $this->dao->consulta($sql);
    }

    public function listar(?tram_honorabilidad $obj = null)
    {
        $sql = "SELECT h.cc_honorab,
        dbo.fc_fecha_texto(h.fecha_reg) AS fecha_reg,
        RTRIM(p.c_cmp) AS cep,
        RTRIM(p.num_documento) AS num_documento,
        RTRIM(p.nombre) AS nombre,
        l.nombre_abv AS c_localtext,
        RTRIM(h.img_fondo) AS img_fondo,
        RTRIM(h.fecha_text) AS fecha_text,
        RTRIM(h.autoridad) AS autoridad,
        h.numero,
        RTRIM(h.cargo) AS cargo,
        h.nombre_anho,
        h.flag,
        dbo.fc_v1_parametro_valor('tram_honorabilidad','flag',h.flag) AS flag_text,
        +ISNULL(bc.referencia2, '') + ' | ' +ISNULL(dbo.fc_fecha_texto(bc.fechax), '') + ' | ' + ISNULL(bc.num_movimiento,'') + ' | ' +ISNULL(CAST(bc.total AS VARCHAR(20)), '') AS banco
        FROM tram_honorabilidad h WITH (NOLOCK)
        INNER JOIN personas p WITH (NOLOCK)
            ON h.cc_persona = p.c_persona
        INNER JOIN local l WITH (NOLOCK)
            ON l.c_local = h.cc_local
        LEFT JOIN bbva_proceso_detalle bc
            ON bc.c_persona = h.cc_persona
        AND bc.flag_tramite = '1'  AND BC.id=H.recaudo_id
        WHERE p.nombre LIKE '%" . $obj->getNombre() . "%' and bc.referencia2 like 'T31%'";
        if (strlen($obj->getAnho()) > 0) {
            $sql .= " and h.anho='" . $obj->getAnho() . "'";
        }
        if (strlen($obj->getPeriodo()) > 0) {
            $sql .= " and MONTH(h.fecha_reg)='" . $obj->getPeriodo() . "'";
        }
        $sql .= " ORDER BY h.cc_honorab asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listaIDPersona($cc_honorab)
    {
        $sql = "select th.cc_honorab, 
        th.cc_local, 
        th.cc_persona, 
        th.anho, 
        th.numero, 
        th.fecha_reg, 
        th.fecha_text, 
        th.img_fondo, 
        th.autoridad, 
        th.cargo,
        nombre_anho,
        th.flag,
        rtrim(p.nombre) as nombre,
        p.c_cmp
        from dbo.tram_honorabilidad th INNER JOIN dbo.personas p
        ON th.cc_persona=p.c_persona
        WHERE th.cc_honorab='" . $cc_honorab . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    /**Dashboard*/
    public function cantidad()
    {
        $sql = "select count(*) cantidad from tram_honorabilidad";
        return $this->dao->consulta($sql);
    }

    public function cantidadPorLocal($cc_local, $anho)
    {
        $filtro_local = !empty($cc_local) ? " AND cc_local = '{$cc_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad
        FROM tram_honorabilidad
        WHERE anho = '{$anho}'{$filtro_local}";
        return $this->dao->consulta($sql);
    }
}
