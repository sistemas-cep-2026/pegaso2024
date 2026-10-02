<?php
require_once dirname(__DIR__) . '/entidad/banc_excel_migrar.php';
require_once __DIR__ . '/_conexa_.php';

class dao_banc_excel_migrar
{
    private $conecta;

    public function __construct()
    {
        $this->conecta = new Conecta();
    }
    public function consulta($sql)
    {
        return $this->conecta->ArrayLista($sql);
    }
    public function insertar(banc_excel_migrar $obj)
    {
        $sql = "INSERT INTO banc_excel_migrar (
                    fecha, numero_operacion, monto, referencia01, 
                    referencia02, cuenta_contable, banco, 
                    cuenta_bancaria, c_banco, num_banco
                ) VALUES (
                    '" . $obj->getFecha() . "',
                    '" . $obj->getNumero_operacion() . "',
                    " . $obj->getMonto() . ",
                    '" . $obj->getReferencia01() . "',
                    '" . $obj->getReferencia02() . "',
                    '" . $obj->getCuenta_contable() . "',
                    '" . $obj->getBanco() . "',
                    '" . $obj->getCuenta_bancaria() . "',
                    '" . $obj->getC_banco() . "',
                    '" . $obj->getNum_banco() . "'
                )";

        return $this->conecta->sql_query($sql);
    }

    public function limpiar()
    {
        $sql = "DELETE FROM banc_excel_migrar";
        return $this->conecta->sql_query($sql);
    }




    public function procesar()
    {
        $sql = "EXEC sp_v1_migrar_ingresos";
        return $this->conecta->sql_query($sql);
    }


    public function errores()
    {
        return $this->conecta->errores();
    }
}
