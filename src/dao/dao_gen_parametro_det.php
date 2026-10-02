<?php
require_once '_conexa_.php';
require_once dirname(__DIR__). '/entidad/gen_parametro_det.php';

class dao_gen_parametro_det
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

	public function insertar(gen_parametro_det $obj)
	{
		$sql = "INSERT INTO gen_parametro_det(
			cc_par_det, 
			cc_parametro, 
			cc_codigo, 
			ct_par_det, 
			ct_par_det_corto, 
			nn_orden, 
			flag
			)VALUES(
			'" . s_cod_id() . "',
			'" . $obj->getCc_parametro() . "',
			'" . $obj->getCc_codigo() . "',
			'" . utf8_decode($obj->getCt_par_det()) . "',
			'" . utf8_decode($obj->getCt_par_det_corto()) . "',
			'" . utf8_decode($obj->getNn_orden()) . "',
			'1'
		)";
		$rs = $this->conecta->sql_query($sql);
		//echo $rs;
		return $rs;
	}
	public function modificar(gen_parametro_det $obj)
	{

		$sql = "";
		$rs = $this->conecta->sql_query($sql);
		return $rs;
	}
	public function eliminar($par_id, $pde_id)
	{
		$sql = "";
		$rs = $this->conecta->sql_query($sql);

		return $rs;
	}

}
