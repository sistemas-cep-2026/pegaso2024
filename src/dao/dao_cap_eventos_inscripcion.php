<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos_inscripcion.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos_inscripcion
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

    public function Descaga_voucher_nube(cap_eventos_inscripcion $obj)
    {
        $sql = "EXEC sp_v1_bajarVoucheEventos '{$obj->getCodigo()}'";
        //echo $sql;
       return $this->conecta->sql_query($sql);
    }


    public function insertar(cap_eventos_inscripcion $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(cap_eventos_inscripcion $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(cap_eventos_inscripcion $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}