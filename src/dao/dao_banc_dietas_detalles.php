<?php
require_once dirname(__DIR__) . '/entidad/banc_dietas_detalles.php';
require_once __DIR__ . '/_conexa_.php';
class dao_banc_dietas_detalles
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

    public function insertar(banc_dietas_detalles $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(banc_dietas_detalles $obj)
    {
        $sql = "update banc_dietas_detalles set retencion={$obj->getRetencion()},renta_bruta={$obj->getRenta_bruta()},neto={$obj->getRenta_bruta()}-({$obj->getRenta_bruta()}*{$obj->getRetencion()}) where cc_dietas_detalles={$obj->getCc_dietas_detalles()}";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(banc_dietas_detalles $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}