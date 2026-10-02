<?php
require_once dirname(__DIR__) . '/entidad/banc_items_comprobantes_de_caja.php';
require_once __DIR__ . '/_conexa_.php';
class dao_banc_items_comprobantes_de_caja
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
    public function procesar_detalle(banc_items_comprobantes_de_caja $obj)
	{
		$sql = "exec sp_v1_gestionar_comprobante_caja_detalle
        '".$obj->getCc_documento_det()."',
        '".$obj->getCc_documento()."',
        '".$obj->getC_persona()."',
        '".$obj->getCod_documento()."',
        '".$obj->getNum_documento()."',
        '".$obj->getMonto()."',
        '".$obj->getC_cuenta ()."',
        '".$obj->getCc_compra ()."',
        '".$obj->getOpcd()."'";
    	//echo $sql;
		return $this->conecta->sql_query($sql);
	}
 

}