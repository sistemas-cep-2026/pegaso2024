<?php
require_once(u_src() . "dao/_conexa_.php");

/** Consultas de solo lectura del dashboard de almacén (parametrizadas). */
class dao_alm_dashboard
{
    private $conecta;

    function __construct()
    {
        $this->conecta = new Conecta();
    }

    public function consultaParams($sql, $params)
    {
        return $this->conecta->ArrayListaParams($sql, $params);
    }

    public function errores()
    {
        return $this->conecta->errores();
    }
}
