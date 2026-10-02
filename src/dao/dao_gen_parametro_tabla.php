<?php
require_once(u_src()."dao/_conexa_.php");
require_once(u_src()."entidad/gen_parametro_tabla.php");

class dao_gen_parametro_tabla {
	private $conecta;
	public function __construct(){
		$this->conecta = new Conecta(); 
	}
	public function consulta($sql){
		return $this->conecta->ArrayLista($sql);
	}

	public function insertar(gen_parametro_tabla $obj){
		$sql="INSERT INTO parametro_tabla(
			par_id,
			pta_tabla,
			pta_campo,
			pta_estado
			)VALUES(
			'".$obj->getPar_id()."',
			'".$obj->getPta_tabla()."',
			'".$obj->getPta_campo()."',
			'1'
		)";
		$rs=$this->conecta->sql_query($sql);
		
		return $rs;
	}
	public function modificar(gen_parametro_tabla $obj){
		
		$sql = "UPDATE gen_parametro_tabla SET 
		pta_estado='".$obj->getPta_estado()."'
		WHERE par_id='".$obj->getPar_id()."' 
		AND pta_tabla='".$obj->getPta_tabla()."'
		AND pta_campo='".$obj->getPta_campo()."' ";			
		$rs=$this->conecta->sql_query($sql);
		return $rs;
	}
	public function eliminar(gen_parametro_tabla $obj){
		$sql="DELETE FROM gen_parametro_tabla 
		WHERE par_id='".$obj->getPar_id()."'
		AND pta_tabla='".$obj->getPta_tabla()."'
		AND pta_campo='".$obj->getPta_campo()."' ";
		$rs=$this->conecta->sql_query($sql);
		
		return $rs;
	}

}
?>
