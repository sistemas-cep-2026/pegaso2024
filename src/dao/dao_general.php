<?php
//require_once(u_src()."entidad/gen_ano.php");
require_once(u_src() . "dao/_conexa_.php");
class dao_general
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

	/** Consulta parametrizada (marcadores ?). */
	public function consultaParams($sql, $params)
	{
		return $this->conecta->ArrayListaParams($sql, $params);
	}

}
