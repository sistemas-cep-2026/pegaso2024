<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos_modulo.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos_modulo
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

    public function insertar(cap_eventos_modulo $obj)
    {
        $sql = "INSERT INTO cap_eventos_modulo (
            cc_evento,
            ct_modulo,
            flag )
        VALUES (
            {$obj->getCc_evento()},
            '{$obj->getCt_modulo()}',
            '{$obj->getFlag()}')";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(cap_eventos_modulo $obj)
    {
        $sql = "UPDATE cap_eventos_modulo SET
            ct_modulo = '{$obj->getCt_modulo()}',
            flag = '{$obj->getFlag()}'
        WHERE cc_capmod = {$obj->getCc_capmod()}";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(cap_eventos_modulo $obj)
    {
        $sql = "UPDATE cap_eventos_modulo SET
            flag = 'A'
        WHERE cc_capmod = {$obj->getCc_capmod()}";
        return $this->conecta->sql_query($sql);
    }
}
