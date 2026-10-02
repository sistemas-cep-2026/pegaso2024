<?php
require_once dirname(__DIR__) . '/entidad/tram_actividad_sustento_detalle.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_actividad_sustento_detalle
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

    public function insertar(tram_actividad_sustento_detalle $obj)
    {
        $sql = "insert into dbo.tram_actividad_sustento_detalle(
        cc_sustento,
        obs,
        horaini,
        horafin
        )VALUES(
        '".$obj->getCc_sustento()."',
        '".$obj->getObs()."',
        '".$obj->getHoraini()."',
        '".$obj->getHorafin()."'
    )";
    //echo $sql;
    return $this->conecta->sql_query($sql);
}

public function modificar(tram_actividad_sustento_detalle $obj)
{
    $sql = "";
    return $this->conecta->sql_query($sql);
}

public function eliminar(tram_actividad_sustento_detalle $obj)
{
    $sql = "delete from tram_actividad_sustento_detalle
    where cc_sustento_det='".$obj->getCc_sustento_det()."'";
    return $this->conecta->sql_query($sql);
}

}