<?php
// require_once dirname(__DIR__) . '/entidad/cont_asistencia.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cont_rhcontrol
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


}