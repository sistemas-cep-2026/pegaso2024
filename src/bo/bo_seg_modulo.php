<?php
require_once(u_src() . "dao/dao_seg_modulo.php");

class bo_seg_modulo
{
	private $dao;

	public function __construct()
	{
		$this->dao = new dao_seg_modulo();
	}
	public function control(seg_modulo $obj, $opc)
	{
		if ($opc == "I") {
			return $this->dao->insertar($obj);
		} else {
			return $this->dao->modificar($obj);
		}
	}

	public function lista_tablas() 
	{
		return $this->dao->lista_tablas();
	}

	public function lista_campo($tabla) 
	{
		return $this->dao->lista_campo($tabla);
	}


	public function moduloId($cc_modulo)
	{
		/***** ok *****/
		$sql = "select rtrim(cc_modulo) as cc_modulo,
		mod_nombre, 
		mod_nivel, 
		mod_carpeta,
		mod_carpeta+mod_url as url,
		mod_carpeta+'js/'+mod_js as js, 
		mod_url, 
		mod_js, 
		mod_estado,
		mod_orden, 
		mod_ico, 
		mod_vista
		FROM seg_modulo
		where cc_modulo='" . $cc_modulo . "' ";
		//echo $sql;
		return $this->dao->consulta($sql);
	}

	public function mod_usuario($usuario)
	{
		$sql = "select u.cc_perfil,
		m.cc_modulo as cc_modulo,
		w.mod_nombre,
		w.mod_ico
		from  seg_usuarios u 
		inner join seg_modulo_perfil m
		on m.cc_perfil=u.cc_perfil
		inner join seg_modulo w on w.cc_modulo=m.cc_modulo
		where u.usuario='" . $usuario . "'
		and w.mod_nivel='1'
		and w.mod_estado='1'
		group by u.usuario,u.cc_perfil,m.cc_modulo ,w.mod_nombre,w.mod_ico";
		//echo $sql;
		return $this->dao->consulta($sql);
	}


	public function listarPadre()
	{
		$sql = "select cc_modulo,
		mod_nombre,
		mod_nivel, mod_carpeta,
		mod_url, mod_js,
		mod_estado,
		mod_orden,
		mod_ico, flag, mod_vista
		from seg_modulo
		where mod_nivel='1'
		and mod_estado='1'
		order by mod_orden";
		//echo $sql;
		return $this->dao->consulta($sql);
	}

	public function listarSubmenu($cc_modulo, $cc_perfil, $mod_vista)
	{
		$sql = "select a.cc_modulo,
		a.mod_nombre, 
		a.mod_nivel, 
		a.mod_carpeta, 
		a.mod_url, 
		a.mod_js, 
		a.mod_estado, 
		a.mod_orden, 
		a.mod_ico, 
		(SELECT COUNT(b.cc_modulo) FROM seg_modulo_perfil b WHERE a.cc_modulo =b.cc_modulo AND b.cc_perfil='" . $cc_perfil . "') AS n
		FROM seg_modulo a 
		WHERE SUBSTRING(CAST(a.cc_modulo AS VARCHAR), 1, 3) = SUBSTRING('" . $cc_modulo . "', 1, 3)
		and a.mod_vista='" . $mod_vista . "'
		and a.mod_estado = '1'
		ORDER by a.mod_orden";
		//echo $sql;
		return $this->dao->consulta($sql);
	}



	/************** fin ************/
	/*
	public function mod_usuario_hijo($usuario, $cc_modulo, $tipo='')
	{
		$sql="select u.cc_perfil,
		m.cc_modulo as cc_modulo,
		w.mod_nombre,
		w.mod_url,
		w.mod_js,
		w.mod_ico,
		w.mod_orden
		from  seg_usuarios u 
		inner join seg_modulo_perfil m
		on m.cc_perfil=u.cc_perfil
		inner join seg_modulo w on w.cc_modulo=m.cc_modulo
		where u.usuario='".$usuario."'
		 and w.mod_nivel='2'
		 and left(cast(cc_modulo as char(6)),3)='".$cc_modulo."'
		 and w.mod_vista='".$tipo."'
		 group by u.cc_perfil,
		m.cc_modulo,
		w.mod_nombre,
		w.mod_url,
		w.mod_js,
		w.mod_ico,
		w.mod_orden
		order by w.mod_orden";
		//echo $sql;
		return $this->dao->consulta($sql);
	}

	
	public function linkModuloID($cc_modulo='')
	{
		$sql="select rtrim(cc_modulo) as cc_modulo,
		mod_nombre 
		FROM seg_modulo
		where cc_modulo like SUBSTRING('".$cc_modulo."',1,3)+'%'
		and mod_nivel='1'";
		//echo $sql;
		return $this->dao->consulta($sql);
	}


	public function asignado_pagina($sec){
		$sql="select 
		c.cc_modulo,
		b.cc_pagina,
		b.ct_pagina,
		c.mod_carpeta+b.ct_url as url,
		c.mod_carpeta+'js/'+b.ct_js as js
		FROM seg_pagina b inner join seg_modulo c 
		on b.cc_modulo=c.cc_modulo
		where b.cc_pagina='".$sec."'
		and b.cfl_vigencia='1'";

		return $this->dao->consulta($sql);
	}

	public function listarModuloPadre($cc_modulo)
	{
		$sql="select rtrim(cc_modulo) as cc_modulo,
		mod_nombre, 
		mod_nivel, 
		mod_carpeta,
		mod_carpeta+mod_url as url,
		mod_carpeta+'js/'+mod_js as js, 
		mod_url, 
		mod_js, 
		mod_estado,
		mod_orden, 
		mod_ico, 
		mod_vista
		FROM seg_modulo
		where left(cast(cc_modulo as char(6)),3)='".$cc_modulo."'
		and mod_vista in('P','R')";

		return $this->dao->consulta($sql);
	}*/
}
