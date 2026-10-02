<?php
require_once dirname(__DIR__) . '/entidad/comp_items_documentos_de_compra_cue.php';
require_once __DIR__ . '/_conexa_.php';
class dao_comp_items_documentos_de_compra_cue
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

	public function procesar_detalle(comp_items_documentos_de_compra_cue $obj)
	{
		$sql = "exec sp_v1_documentosCompras_detalle
		'".$obj->getCc_compra_det()."',
		'".$obj->getCc_compra()."',  
		'".$obj->getC_cuenta()."',
		'".$obj->getDebe()."',   
		'".$obj->gethaber()."',          
		'".$obj->getOpcd()."'
		";
    	// echo $sql;
		return $this->conecta->sql_query($sql);
	}

}

