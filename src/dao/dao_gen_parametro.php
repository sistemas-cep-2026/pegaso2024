<?php
require_once(u_src()."dao/_conexa_.php");
require_once(u_src()."entidad/gen_parametro.php");

class dao_gen_parametro {
	private $conecta;
	public function __construct(){
		$this->conecta = new Conecta(); 
	}
	public function consulta($sql){
		return $this->conecta->ArrayLista($sql);
	}
	public function total_pagina(){
		return $this->conecta->total_pagina();
	}
	public function insertar(gen_parametro $obj){
		$sql="INSERT INTO gen_parametro(
			cc_parametro, 
			ct_parametro, 
			ct_descripcion, 
			flag
			)VALUES(
			'".s_cod_id()."',
			'".utf8_decode($obj->getCt_parametro())."',
			'".utf8_decode($obj->getCt_descripcion())."',
			'1'
		)";
						//echo $sql;
		$rs=$this->conecta->sql_query($sql);
		
		return $rs;
	}
	public function modificar(gen_parametro $obj){
		
		$sql = "UPDATE gen_parametro SET 
		ct_parametro='".utf8_decode($obj->getCt_parametro())."',
		ct_descripcion='".utf8_decode($obj->getCt_descripcion())."',
		flag='".$obj->getFlag()."'
		WHERE cc_parametro='".$obj->getCc_parametro()."' ";	
				//echo $rs;	
		$rs=$this->conecta->sql_query($sql);
		return $rs;
	}
	public function eliminar($cc_parametro){
		$sql="DELETE FROM gen_parametro 
		WHERE cc_parametro='".$cc_parametro."'";
		$rs=$this->conecta->sql_query($sql);
		
		return $rs;
	}

}
?>