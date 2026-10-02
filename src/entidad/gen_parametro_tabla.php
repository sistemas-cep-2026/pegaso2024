<?php 
class gen_parametro_tabla { 
	private $par_id;
	private $pta_tabla;
	private $pta_campo;
	private $pta_estado;
	function __construct(){
		$this->par_id= 0;
		$this->pta_tabla= "";
		$this->pta_campo= "";
		$this->pta_estado= "";
	}
	function __destruct() {
	}
	public function  getPar_id() {
			return $this->par_id;
	}
	public function  setPar_id($val) {
       		$this->par_id = $val; 
	}
	public function  getPta_tabla() {
			return $this->pta_tabla;
	}
	public function  setPta_tabla($val) {
       		$this->pta_tabla = $val; 
	}
	public function  getPta_campo() {
			return $this->pta_campo;
	}
	public function  setPta_campo($val) {
       		$this->pta_campo = $val; 
	}
	public function  getPta_estado() {
			return $this->pta_estado;
	}
	public function  setPta_estado($val) {
       		$this->pta_estado = $val; 
	}
}
?>