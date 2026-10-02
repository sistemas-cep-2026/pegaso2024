<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos_matricula_temp.php';
class bo_cap_eventos_matricula_temp
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos_matricula_temp();
    }

    public function insertar(cap_eventos_matricula_temp $obj)
    {
        return $this->dao->insertar($obj);
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function eliminarPorEvento(cap_eventos_matricula_temp $obj)
    {
        return $this->dao->eliminarPorEvento($obj);
    }

    public function procesar($cc_evento, $usuario)
    {
        return $this->dao->procesar($cc_evento, $usuario);
    }

    public function listarComparativo(?cap_eventos_matricula_temp $obj = null)
    {
        $sql = "SELECT
            t.cc_evento_mattemp,
            t.cep,
            t.num_documento,
            t.nombre,
            t.asistente,
            t.ponente,
            t.organizador,
            p.c_persona AS c_persona_encontrado,
            CASE WHEN p.c_persona IS NOT NULL THEN 'SI' ELSE 'NO' END AS coincide
        FROM cap_eventos_matricula_temp t
        LEFT JOIN personas p
            ON (t.cep IS NOT NULL AND p.c_cmp = t.cep)
            OR (t.num_documento IS NOT NULL AND p.num_documento = t.num_documento)
        WHERE t.cc_evento = {$obj->getCc_evento()}
        ORDER BY t.cc_evento_mattemp";
        return $this->dao->consulta($sql);
    }
}
