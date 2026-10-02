<?php
require_once dirname(__DIR__) . '/entidad/banc_dietas.php';
require_once __DIR__ . '/_conexa_.php';
class dao_banc_dietas
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

    public function procesarDietas(banc_dietas $obj)
    {
        $sql = "exec sp_v1_banc_dietas
       '" . $obj->getOpc() . "', 
        '" . $obj->getCc_dietas() . "', 
        '" . $obj->getFecha() . "', 
        '" . $obj->getCc_local() . "', 
        '" . $obj->getCc_persona() . "', 
        '" . $obj->getReferencia() . "', 
        '" . $obj->getCc_usuario() . "', 
        '" . $obj->getC_area_adm() . "', 
        '" . $obj->getCod_ano() . "', 
        '" . $obj->getCod_mes() . "'";
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
             //echo $sql;
            return $this->conecta->sql_query($sql);
        }
    }

    /*public function abrir(banc_dietas $obj)
    {
        $sql = "update banc_dietas set flag='&' where cc_dietas='" . $obj->getCc_dietas() . "'; ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function procesar(banc_dietas $obj)
    {
        $sql = "update banc_dietas set flag='*' where cc_dietas='" . $obj->getCc_dietas() . "'; ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
    public function eliminar(banc_dietas $obj)
    {
        $sql = "update banc_dietas set flag='A' where cc_dietas='" . $obj->getCc_dietas() . "'; ";
        return $this->conecta->sql_query($sql);
    }*/
}
