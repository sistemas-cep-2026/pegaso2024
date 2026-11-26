<?php
require_once dirname(__DIR__) . '/entidad/cont_asistencia.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cont_asistencia
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

    /** Consulta con parámetros (?). */
    public function consultaParams($sql, $params)
    {
        return $this->conecta->ArrayListaParams($sql, $params);
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    // Grabaciones con parámetros: ArrayListaParams corta con el error de SQL si algo falla.
    public function insertar(cont_asistencia $obj)
    {
        $sql = "INSERT INTO cont_asistencia (cc_persona, punch_time, flag, status) VALUES (?, ?, ?, ?)";
        $this->conecta->ArrayListaParams($sql, array(
            (string) $obj->getCc_persona(),
            (string) $obj->getPunch_time(),
            (string) $obj->getFlag(),
            (int) $obj->getStatus(),
        ));
        return true;
    }

    public function modificar(cont_asistencia $obj)
    {
        $sql = "UPDATE cont_asistencia SET punch_time = ?, flag = ?, status = ? WHERE id = ?";
        $this->conecta->ArrayListaParams($sql, array(
            (string) $obj->getPunch_time(),
            (string) $obj->getFlag(),
            (int) $obj->getStatus(),
            (int) $obj->getId(),
        ));
        return true;
    }
}
