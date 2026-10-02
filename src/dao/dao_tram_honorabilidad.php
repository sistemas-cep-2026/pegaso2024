<?php
require_once dirname(__DIR__) . '/entidad/tram_honorabilidad.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_honorabilidad
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

    public function insertar(tram_honorabilidad $obj)
    {
        $sql = "EXEC dbo.sp_v1_tram_honorabilidad
            " . $obj->getCc_honorab() . ",
            '" . $obj->getCc_persona() . "',
            '" . $obj->getFecha_text() . "',
            '" . $obj->getImg_fondo() . "',
            '" . $obj->getAutoridad() . "',
            '" . $obj->getCargo() . "',
            '" . $obj->getUser_crea() . "',
            " . $obj->getRecaudo_id() . ",
            '" . $obj->getNombre_anho() . "',
            '" . $obj->getOpc() . "'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(tram_honorabilidad $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function anular(tram_honorabilidad $obj)
    {
        $sql = "update tram_honorabilidad set flag='A'
        where cc_honorab='" . $obj->getCc_honorab() . "'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
