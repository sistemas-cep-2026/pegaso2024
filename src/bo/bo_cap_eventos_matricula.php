<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos_matricula.php';
class bo_cap_eventos_matricula
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos_matricula();
    }

    public function control(cap_eventos_matricula $obj, $opc)
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
    public function validar(?cap_eventos_matricula $obj = null)
    {
        $sql = "select c_persona 
        from cap_eventos_matricula nolock
        where c_persona='{$obj->getC_persona()}'
        and cc_evento='{$obj->getCc_evento()}'";
        return $this->dao->consulta($sql);
    }

    /**
     * Resumen liviano por rol (asistentes, ponentes, organizadores) para un
     * evento — mismo criterio que ya usa matric_lista.php (asistente==1,
     * ponente==1, organizador==1).
     */
    public function resumenRoles($cc_evento)
    {
        $sql = "select
            SUM(CASE WHEN asistente = 1 THEN 1 ELSE 0 END) as asistentes,
            SUM(CASE WHEN ponente = 1 THEN 1 ELSE 0 END) as ponentes,
            SUM(CASE WHEN organizador = 1 THEN 1 ELSE 0 END) as organizadores
        from cap_eventos_matricula
        where cc_evento = '{$cc_evento}'";
        return $this->dao->consulta($sql);
    }
    public function listarParticipante(?cap_eventos_matricula $obj = null)
    {
        $sql = "select m.cc_evento_mat,
        rtrim(p.c_persona) c_persona,
        rtrim(m.cc_evento) cc_evento,
        p.c_cmp,
        p.num_documento,
        RTRIM(p.nombre) AS nombre_completo,
        m.asistente,
        m.ponente,
        m.organizador,
        e.print_documento
        FROM cap_eventos_matricula m (nolock) INNER JOIN Personas p (nolock)
        ON m.c_persona=p.c_persona
        left join cap_eventos e (nolock)
		on e.cc_evento=m.cc_evento
        WHERE m.cc_evento='{$obj->getCc_evento()}'
        ORDER BY p.nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?cap_eventos_matricula $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function buscarPersonaImport($tipo, $codigo)
    {
        if ($tipo == 'C') {
            $sql = "SELECT TOP 1 c_persona, RTRIM(nombre) AS nombre_completo
            FROM personas
            WHERE ISNUMERIC(c_cmp) = 1
              AND c_cmp = '{$codigo}'
              AND flag_activo IN ('B','V','A','C')";
        } else {
            $sql = "SELECT TOP 1 c_persona, RTRIM(nombre) AS nombre_completo
            FROM personas
            WHERE num_documento = '{$codigo}'
              AND ISNULL(flag_activo,'') <> 'F'";
        }
        return $this->dao->consulta($sql);
    }
}
