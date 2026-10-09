<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos
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
    public function creaeventos(?cap_eventos $obj)
    {
        $sql = "exec sp_v1_crear_curso
                '" . $obj->getOpc() . "',
                '" . $obj->getCc_evento() . "',
                '" . $obj->getNombre() . "',
                '" . $obj->getCc_local() . "',
                '" . $obj->getTipo() . "',
                '" . $obj->getFecha_ini() . "',
                '" . $obj->getFecha_fin() . "',
                '" . $obj->getFecha_evento_text() . "',
                '" . $obj->getDetalle() . "',
                '" . $obj->getDetalle_ponente() . "',
                '" . $obj->getPrint_documento() . "',
                '" . $obj->getText_documento() . "',
                '" . $obj->getUser_crea() . "'";
        //echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            //echo $sql;
            return $this->conecta->sql_query($sql);
        }
    }

    public function actualizarArchivo(cap_eventos $obj, $campo = 'img_asistente')
    {
        // Lista blanca: nunca interpolar el nombre de columna directo desde afuera.
        $columna = ($campo === 'img_ponente') ? 'img_ponente' : 'img_asistente';
        $valor   = ($campo === 'img_ponente') ? $obj->getImg_ponente() : $obj->getImg_asistente();
        $sql = "UPDATE cap_eventos SET {$columna} = '{$valor}'
        WHERE cc_evento = {$obj->getCc_evento()}";
        return $this->conecta->sql_query($sql);
    }

    public function eliminarArchivo(cap_eventos $obj, $campo = 'img_asistente')
    {
        $columna = ($campo === 'img_ponente') ? 'img_ponente' : 'img_asistente';
        $sql = "update cap_eventos SET {$columna} = NULL
        WHERE cc_evento = {$obj->getCc_evento()}";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
    public function PublicarEvento(?cap_eventos $obj)
    {
        $sql = "update cap_eventos SET flag = 'PU'
        WHERE cc_evento = {$obj->getCc_evento()}";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
