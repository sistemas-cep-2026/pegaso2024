<?php
require_once dirname(__DIR__) . '/entidad/banc_beneficiofam.php';
require_once __DIR__ . '/_conexa_.php';
class dao_banc_beneficiofam
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

    public function insertar(banc_beneficiofam $obj)
    {
        $sql = "insert into banc_beneficiofam(fecha,
        cc_local, 
        cc_persona, 
        referencia,
        c_banco, 
        fecha_operacion, 
        monto, 
        operacion, 
        cod_tipo,
        flag,
        user_crea,
        fecha_crea
        )values(
        '{$obj->getFecha()}',
        '{$obj->getCc_local()}',
        '{$obj->getCc_persona()}',
        '{$obj->getReferencia()}',
        '{$obj->getC_banco()}',
        '{$obj->getFecha_operacion()}',
        '{$obj->getMonto()}',
        '{$obj->getOperacion()}',
        '{$obj->getCod_tipo()}',
        'P',
        '{$obj->getUser_crea()}',
        GETDATE()
        )";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(banc_beneficiofam $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(banc_beneficiofam $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
