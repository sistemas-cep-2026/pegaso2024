<?php
require_once dirname(__DIR__) . '/entidad/gen_entidad_pagadora.php';
require_once __DIR__ . '/_conexa_.php';
class dao_gen_entidad_pagadora
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

    public function insertar(gen_entidad_pagadora $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_entidad_pagadora $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_entidad_pagadora $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
