<?php
require_once(u_src() . "entidad/gen_personas.php");
require_once(u_src() . "dao/_conexa_.php");
class dao_gen_personas
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

    public function insertar_cap(gen_personas $obj)
    {
        $sql = "insert into personas(
        c_persona,
        grado,
        num_documento,
        nombre,
        flag_activo,cod_tipo
        )values(
        '{$obj->getC_persona()}',
        '{$obj->getGrado()}',
        '{$obj->getNum_documento()}',
        '{$obj->getNombre()}',
        'A','CP')";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
 public function insertar_ruc(gen_personas $obj)
    {
        $sql = "exec sp_v1_rucnuevo '{$obj->getRuc()}', '{$obj->getNombre()}', '{$obj->getCelular1()}', '{$obj->getEmail1()}', '{$obj->getUsuario()}','{$obj->getNum_documento()}';";
        // echo $sql;
        return $this->conecta->sql_query($sql);
    }


    public function modificar_ruc(gen_personas $obj)
    {
        $sql = "update  personas set celular1='{$obj->getCelular1()}' ,email1='{$obj->getEmail1()}' , usuario='{$obj->getUsuario()}'
        where c_persona='{$obj->getC_persona()}'";
       //  echo $sql;
        return $this->conecta->sql_query($sql);
    }
    public function modificar_cap(gen_personas $obj)
    {
        $sql = "update personas SET grado='{$obj->getGrado()}',
            nombre='{$obj->getNombre()}',
            num_documento='{$obj->getNum_documento()}'
            WHERE c_persona='{$obj->getC_persona()}'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    /*public function insertarNuevoResumen(gen_personas $obj)
    {
        $sql = "insert into gen_personas(
        num_documento,
        ruc,
        nombre
        )values(
        '" . $obj->getNum_documento() . "',
        '" . $obj->getRuc() . "',
        '" . $obj->getNombre() . "'
        ";
        return $this->conecta->sql_query($sql);
    }*/

    public function deuda_c_persona($c_persona)
    {
        $sql = "exec sp_estado_habilidad '" . $c_persona . "'";
        return $this->conecta->sql_query($sql);
    }

    public function modificar_colegiacion(gen_personas $obj)
    {
        $sql = "EXEC sp_actualizar_persona_cloud
                '" . $obj->getCc_persona() . "',
                '" . $obj->getFlag_activo() . "',	
                '" . $obj->getC_local_colegiacion() . "',
                '" . $obj->getC_local() . "',    
                '" . $obj->getC_entidad_pagadora() . "',
                '" . $obj->getApellido_Materno() . "',
                '" . $obj->getApellido_paterno() . "',
                '" . $obj->getNombre1() . "',
                '" . $obj->getNombre2() . "',
                '" . $obj->getNombre() . "',
                '" . $obj->getCod_sexo() . "',
                '" . $obj->getPais_nacimiento() . "',
                '" . $obj->getCod_documento() . "',
                '" . $obj->getNum_documento() . "',
                '" . $obj->getCelular1() . "',
                '" . $obj->getEmail1() . "',
                '" . $obj->getGrupo_sanguineo() . "',
                '" . $obj->getFactor_sanguineo() . "',
                '" . $obj->getUbigeonac() . "',
                '" . $obj->getUbigeodirec() . "',                                
                '" . $obj->getC_e_civil() . "',
                '" . $obj->getC_universidad() . "',
                '" . $obj->getFecha_promocion() . "',
                '" . $obj->getC_univ_licenciatura() . "',
                '" . $obj->getFecha_licenciatura() . "',
                '" . $obj->getFecha_de_nacimiento() . "',
                '" . $obj->getTipo_direccion() . "',
                '" . $obj->getDdirecto() . "',
                '" . $obj->getUsuario() . "'; ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function insertarNuevoCEP(gen_personas $obj)
    {
        $sql = "EXEC sp_v1_cepnuevo '{$obj->getC_persona()}', '{$obj->getC_cmp()}', '{$obj->getFecha_de_inicio()}', {$obj->getRegularizado()};";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function EjcutarFotosColegiacion($cep, $cepinicio, $cepfinal, $tipo)
	{
		$sql = "exec sp_print_fotos '" . $cep . "',
								'" . $cepinicio . "', 
								'" . $cepfinal . "', 
								'" . $tipo . "'";
		//echo $sql; 
		return $this->conecta->sql_query($sql);
	}

    public function printFotosColegiacion_limpiar()
	{
		$sql = "TRUNCATE TABLE PERSONAS_CARNE";
		return $this->conecta->sql_query($sql);
	}

       public function Actualiza_deuda($c_persona)
    {
        $sql = "exec sp_estado_habilidad '" . $c_persona . "'";
        return $this->conecta->sql_query($sql);
    }
}
