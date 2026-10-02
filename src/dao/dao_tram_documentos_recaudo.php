<?php
require_once dirname(__DIR__) . '/entidad/tram_documentos_recaudo.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_documentos_recaudo
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

    public function insertar(tram_documentos_recaudo $obj)
    {
        $sql = "INSERT INTO tram_documentos_recaudo
                (c_expediente,
                c_persona,
                fecha_registro,
                id_recaudo_bbva,
                banco,
                operacion,
                fecha_op,
                monto,
                cod_tram_recaudo,
                obs,
                c_usuario_ingreso,
                fecha_ingreso) VALUES(
                '{$obj->getC_expediente()}',
                '{$obj->getC_persona()}',
                GETDATE(),
                dbo.fc_es_vacio('{$obj->getId_recaudo_bbva()}'),
                dbo.fc_es_vacio('{$obj->getBanco()}'),
                dbo.fc_es_vacio('{$obj->getOperacion()}'),
                dbo.fc_es_vacio('{$obj->getFecha_op()}'),
                dbo.fc_es_vacio('{$obj->getMonto()}'),
                dbo.fc_es_vacio('{$obj->getCod_tram_recaudo()}'),
                dbo.fc_es_vacio('{$obj->getObs()}'),
                '{$obj->getC_usuario_ingreso()}',
                GETDATE())";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(tram_documentos_recaudo $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(tram_documentos_recaudo $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
