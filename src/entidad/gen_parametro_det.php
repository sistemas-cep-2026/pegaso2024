<?php 
class gen_parametro_det { 
	 private $cc_par_det; 
	 private $cc_parametro; 
	 private $cc_codigo; 
	 private $ct_par_det; 
	 private $ct_par_det_corto; 
	 private $nn_orden; 
	 private $flag;	
 function __construct(){
		$this->cc_par_det= ""; 
		 $this->cc_parametro= "";
		 $this->cc_codigo= ""; 
		 $this->ct_par_det= ""; 
		 $this->ct_par_det_corto= ""; 
		 $this->nn_orden= 0;
		 $this->flag= 0;
	}
	function __destruct() {
	}
	public function  getCc_par_det() {
			return $this->cc_par_det;
	}
	public function  setCc_par_det($cc_par_det) {
       		$this->cc_par_det = $cc_par_det; 
	}
	public function  getCc_parametro() {
			return $this->cc_parametro;
	}
	public function  setCc_parametro($cc_parametro) {
       		$this->cc_parametro = $cc_parametro; 
	}
	public function  getCc_codigo() {
			return $this->cc_codigo;
	}
	public function  setCc_codigo($cc_codigo) {
       		$this->cc_codigo = $cc_codigo; 
	}
	public function  getCt_par_det() {
			return $this->ct_par_det;
	}
	public function  setCt_par_det($ct_par_det) {
       		$this->ct_par_det = $ct_par_det; 
	}
	public function  getCt_par_det_corto() {
			return $this->ct_par_det_corto;
	}
	public function  setCt_par_det_corto($ct_par_det_corto) {
       		$this->ct_par_det_corto = $ct_par_det_corto; 
	}
	public function  getNn_orden() {
			return $this->nn_orden;
	}
	public function  setNn_orden($nn_orden) {
       		$this->nn_orden = $nn_orden; 
	}
	public function  getFlag() {
			return $this->flag;
	}
	public function  setFlag($flag) {
       		$this->flag = $flag; 
	}
}
?>