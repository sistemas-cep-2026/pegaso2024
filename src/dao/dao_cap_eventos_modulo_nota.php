<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos_modulo_nota.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos_modulo_nota
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

    public function insertar(cap_eventos_modulo_nota $obj)
    {
        $sql = "INSERT INTO cap_eventos_modulo_nota (
            cc_capmod,
            cc_evento_mat,
            nota )
        VALUES (
            {$obj->getCc_capmod()},
            {$obj->getCc_evento_mat()},
            {$obj->getNota()})";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(cap_eventos_modulo_nota $obj)
    {
        $sql = "UPDATE cap_eventos_modulo_nota SET
            cc_capmod = {$obj->getCc_capmod()},
            nota = {$obj->getNota()}
        WHERE cc_modnota = {$obj->getCc_modnota()}";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(cap_eventos_modulo_nota $obj)
    {
        $sql = "DELETE FROM cap_eventos_modulo_nota
        WHERE cc_modnota = {$obj->getCc_modnota()}";
        return $this->conecta->sql_query($sql);
    }
}
