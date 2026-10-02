<?php
require_once dirname(__DIR__) . '/entidad/web_tram_colegiacion_control.php';
require_once __DIR__ . '/_conexa_.php';
class dao_web_tram_colegiacion_control
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

    public function insertar(web_tram_colegiacion_control $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(web_tram_colegiacion_control $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(web_tram_colegiacion_control $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function procesarControl_CL(web_tram_colegiacion_control $obj)
    {
        $sql = "exec sp_web_tram_colegiacion_control  
        '" . $obj->getC_persona() . "',
        '" . $obj->getCodigo() . "',
        '" . $obj->getDetalle() . "',
        '" . $obj->getEstado() . "',
        '" . $obj->getCc_usuario() . "'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
