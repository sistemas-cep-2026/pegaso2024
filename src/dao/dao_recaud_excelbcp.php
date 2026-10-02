<?php
require_once dirname(__DIR__) . '/entidad/recaud_excelbcp.php';
require_once __DIR__ . '/_conexa_.php';
class dao_recaud_excelbcp
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


    public function subirRecaudadorabcp(recaud_excelbcp $obj)
    {
        $sql = "insert INTO recaud_excelbcp (codigo_depositante,
        dato_adicional,
        fecha,
        fecha_vencimiento,
        monto,
        mora,
        total,
        sucursal,
        numero_operacion,
        referencia,
        terminal,
        medio,
        hora,
        cheque,
        codigo_banco,
        cargo,
        extorno,
        documento_pago,
        operacion_db,
        operacion_canal
        
        ) VALUES (
        '" . $obj->getCodigo_depositante() . "',
        '" . $obj->getDato_adicional() . "',
        '" . $obj->getFecha() . "',
        '" . $obj->getFecha_vencimiento() . "',
        '" . $obj->getMonto() . "',
        '" . $obj->getMora() . "',
        '" . $obj->getTotal() . "',
        '" . $obj->getSucursal() . "',
        '" . $obj->getNumero_operacion() . "',
        '" . $obj->getReferencia() . "',
        '" . $obj->getTerminal() . "',
        '" . $obj->getMedio() . "',
        '" . $obj->getHora() . "',
        '" . $obj->getCheque() . "',
        '" . $obj->getCodigo_banco() . "',
        '" . $obj->getCargo() . "',
        '" . $obj->getExtorno() . "',
        '" . $obj->getDocumento_pago() . "',
        '" . $obj->getOperacion_db() . "',
        '" . $obj->getOperacion_canal() . "')";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function procesarRecaudadorabcp(recaud_excelbcp $obj)
    {
        $sql = "exec sp_v1_proceso_recaudadora_BCP";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
