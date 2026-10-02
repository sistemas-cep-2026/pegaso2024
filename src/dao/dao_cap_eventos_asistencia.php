<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos_asistencia.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos_asistencia
{
    private $conecta;

    function __construct()
    {
        $this->conecta = new Conecta();
    }

    public function consulta($sql)
    {
        return $this->conecta->ArrayLista($sql);
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    public function insertar(cap_eventos_asistencia $obj)
    {
        $sql = "INSERT INTO cap_eventos_asistencia (
            cc_evento,
            c_persona,
            fech_crea,
            user_crea,
            flag )
        VALUES (
            {$obj->getCc_evento()},
            '{$obj->getC_persona()}',
            '{$obj->getFech_crea()}',
            '{$obj->getUser_crea()}',
            '*')";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(cap_eventos_asistencia $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(cap_eventos_asistencia $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
