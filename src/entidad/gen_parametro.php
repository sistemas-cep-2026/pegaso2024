<?php 
class gen_parametro { 
	private $cc_parametro;
	private $ct_parametro; 
	private $ct_descripcion; 
	private $flag;
	function __construct(){
		$this->cc_parametro= 0;
		$this->ct_parametro= "";
		$this->ct_descripcion= "";
		$this->flag= "";
	}
	function __destruct() {
	}
	public function  getCc_parametro() {
			return $this->cc_parametro;
	}
	public function  setCc_parametro($cc_parametro) {
       		$this->cc_parametro = $cc_parametro; 
	}
	public function  getCt_parametro() {
			return $this->ct_parametro;
	}
	public function  setCt_parametro($ct_parametro) {
       		$this->ct_parametro = $ct_parametro; 
	}
	public function  getCt_descripcion() {
			return $this->ct_descripcion;
	}
	public function  setCt_descripcion($ct_descripcion) {
       		$this->ct_descripcion = $ct_descripcion; 
	}
	public function  getFlag() {
			return $this->flag;
	}
	public function  setFlag($flag) {
       		$this->flag = $flag; 
	}
}
?>