<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_personas extends Parse
{
    private $c_persona;
    private $c_cmp;
    private $apellido_materno;
    private $apellido_paterno;
    private $nombre1;
    private $nombre2;
    private $nombre;
    private $flag_activo;
    private $cod_documento;
    private $num_documento;
    private $c_local;
    private $cod_sexo;
    private $celular1;
    private $grupo_sanguineo;
    private $fecha_de_nacimiento;
    private $email1;
    private $flag_habil;
    private $fecha_fallecido;
    private $c_entidad_pagadora;
    private $c_e_civil;
    private $factor_sanguineo;
    private $n_folio_cole;
    private $n_libro_cole;
    private $n_resolucion_cole;
    private $c_universidad;
    private $c_univ_licenciatura;
    private $fecha_licenciatura;
    private $n_titulo_licenciatura;
    private $cc_persona;
    private $ubigeonac;
    private $ubigeodirec;
    private $pais_nacimiento;
    private $tipo_direccion;
    private $c_local_colegiacion;
    private $fecha_de_inicio;
    private $fecha_promocion;

    private $ruc;
    private $regularizado;
    private $grado;
    private $DDIRECTO;
    private $usuario;

    private $opc;

    private $desde;
    private $hasta;

    private $recaudo;

    function __construct()
    {
        $this->c_persona = '';
        $this->c_cmp = '';
        $this->apellido_materno = '';
        $this->apellido_paterno = '';
        $this->nombre1 = '';
        $this->nombre2 = '';
        $this->nombre = '';
        $this->flag_activo = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->c_local = '';
        $this->cod_sexo = '';
        $this->celular1 = '';
        $this->grupo_sanguineo = '';
        $this->fecha_de_nacimiento = null;
        $this->email1 = '';
        $this->flag_habil = null;
        $this->fecha_fallecido = null;
        $this->c_entidad_pagadora = '';
        $this->c_e_civil = '';
        $this->factor_sanguineo = '';
        $this->n_folio_cole = '';
        $this->n_libro_cole = '';
        $this->n_resolucion_cole = '';
        $this->c_universidad = '';
        $this->c_univ_licenciatura = '';
        $this->fecha_licenciatura = null;
        $this->n_titulo_licenciatura = '';
        $this->cc_persona = '';
        $this->ubigeonac = '000000';
        $this->ubigeodirec = '';
        $this->pais_nacimiento = '';
        $this->tipo_direccion = '';
        $this->c_local_colegiacion = '';
        $this->fecha_de_inicio = '';
        $this->fecha_promocion = '';
        $this->ruc = '';
        $this->regularizado = '';
        $this->grado = '';
        $this->DDIRECTO = '';
        $this->usuario = '';

        $this->opc = '';

        $this->desde = '';
        $this->hasta = '';

        $this->recaudo = '';
    }


    public function setC_persona($c_persona)
    {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

    public function setC_cmp($c_cmp)
    {
        if (empty($c_cmp)) return;
        $this->c_cmp = self::Clean($c_cmp);
    }

    public function getC_cmp()
    {
        return $this->c_cmp;
    }

    public function setApellido_materno($apellido_materno)
    {
        if (empty($apellido_materno)) return;
        $this->apellido_materno = self::Clean($apellido_materno);
    }

    public function getApellido_materno()
    {
        return $this->apellido_materno;
    }

    public function setApellido_paterno($apellido_paterno)
    {
        if (empty($apellido_paterno)) return;
        $this->apellido_paterno = self::Clean($apellido_paterno);
    }

    public function getApellido_paterno()
    {
        return $this->apellido_paterno;
    }

    public function setNombre1($nombre1)
    {
        if (empty($nombre1)) return;
        $this->nombre1 = self::Clean($nombre1);
    }

    public function getNombre1()
    {
        return $this->nombre1;
    }

    public function setNombre2($nombre2)
    {
        if (empty($nombre2)) return;
        $this->nombre2 = self::Clean($nombre2);
    }

    public function getNombre2()
    {
        return $this->nombre2;
    }

    public function setNombre($nombre)
    {
        if (empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setFlag_activo($flag_activo)
    {
        if (empty($flag_activo)) return;
        $this->flag_activo = self::Clean($flag_activo);
    }

    public function getFlag_activo()
    {
        return $this->flag_activo;
    }

    public function setCod_documento($cod_documento)
    {
        if (empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento()
    {
        return $this->cod_documento;
    }

    public function setNum_documento($num_documento)
    {
        if (empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
    }

    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setCod_sexo($cod_sexo)
    {
        if (empty($cod_sexo)) return;
        $this->cod_sexo = self::Clean($cod_sexo);
    }

    public function getCod_sexo()
    {
        return $this->cod_sexo;
    }

    public function setCelular1($celular1)
    {
        if (empty($celular1)) return;
        $this->celular1 = self::Clean($celular1);
    }

    public function getCelular1()
    {
        return $this->celular1;
    }

    public function setGrupo_sanguineo($grupo_sanguineo)
    {
        if (empty($grupo_sanguineo)) return;
        $this->grupo_sanguineo = self::Clean($grupo_sanguineo);
    }

    public function getGrupo_sanguineo()
    {
        return $this->grupo_sanguineo;
    }

    public function setFecha_de_nacimiento($fecha_de_nacimiento)
    {
        $this->fecha_de_nacimiento = $fecha_de_nacimiento;
    }

    public function getFecha_de_nacimiento()
    {
        return $this->fecha_de_nacimiento;
    }

    public function setEmail1($email1)
    {
        if (empty($email1)) return;
        $this->email1 = self::Clean($email1);
    }

    public function getEmail1()
    {
        return $this->email1;
    }

    public function setFlag_habil($flag_habil)
    {
        if (empty($flag_habil)) return;
        $this->flag_habil = self::Clean($flag_habil);
        //$this->flag_habil = (bool)$flag_habil;
    }

    public function getFlag_habil()
    {
        return $this->flag_habil;
    }

    public function setFecha_fallecido($fecha_fallecido)
    {
        $this->fecha_fallecido = $fecha_fallecido;
    }

    public function getFecha_fallecido()
    {
        return $this->fecha_fallecido;
    }

    public function setC_entidad_pagadora($c_entidad_pagadora)
    {
        if (empty($c_entidad_pagadora)) return;
        $this->c_entidad_pagadora = self::Clean($c_entidad_pagadora);
    }

    public function getC_entidad_pagadora()
    {
        return $this->c_entidad_pagadora;
    }

    public function setC_e_civil($c_e_civil)
    {
        if (empty($c_e_civil)) return;
        $this->c_e_civil = self::Clean($c_e_civil);
    }

    public function getC_e_civil()
    {
        return $this->c_e_civil;
    }

    public function setFactor_sanguineo($factor_sanguineo)
    {
        if (empty($factor_sanguineo)) return;
        $this->factor_sanguineo = self::Clean($factor_sanguineo);
    }

    public function getFactor_sanguineo()
    {
        return $this->factor_sanguineo;
    }

    public function setN_folio_cole($n_folio_cole)
    {
        if (empty($n_folio_cole)) return;
        $this->n_folio_cole = self::Clean($n_folio_cole);
    }

    public function getN_folio_cole()
    {
        return $this->n_folio_cole;
    }

    public function setN_libro_cole($n_libro_cole)
    {
        if (empty($n_libro_cole)) return;
        $this->n_libro_cole = self::Clean($n_libro_cole);
    }

    public function getN_libro_cole()
    {
        return $this->n_libro_cole;
    }

    public function setN_resolucion_cole($n_resolucion_cole)
    {
        if (empty($n_resolucion_cole)) return;
        $this->n_resolucion_cole = self::Clean($n_resolucion_cole);
    }

    public function getN_resolucion_cole()
    {
        return $this->n_resolucion_cole;
    }
    public function setC_universidad($c_universidad)
    {
        if (empty($c_universidad)) return;
        $this->c_universidad = self::Clean($c_universidad);
    }

    public function getC_universidad()
    {
        return $this->c_universidad;
    }
    public function setFecha_promocion($fecha_promocion)
    {
        if (empty($fecha_promocion)) return;
        $this->fecha_promocion = self::Clean($fecha_promocion);
    }

    public function getFecha_promocion()
    {
        return $this->fecha_promocion;
    }
    public function setC_univ_licenciatura($c_univ_licenciatura)
    {
        if (empty($c_univ_licenciatura)) return;
        $this->c_univ_licenciatura = self::Clean($c_univ_licenciatura);
    }

    public function getC_univ_licenciatura()
    {
        return $this->c_univ_licenciatura;
    }

    public function setFecha_licenciatura($fecha_licenciatura)
    {
        $this->fecha_licenciatura = $fecha_licenciatura;
    }

    public function getFecha_licenciatura()
    {
        return $this->fecha_licenciatura;
    }

    public function setN_titulo_licenciatura($n_titulo_licenciatura)
    {
        if (empty($n_titulo_licenciatura)) return;
        $this->n_titulo_licenciatura = self::Clean($n_titulo_licenciatura);
    }

    public function getN_titulo_licenciatura()
    {
        return $this->n_titulo_licenciatura;
    }

    public function setCc_persona($cc_persona)
    {
        if (empty($cc_persona)) return;
        $this->cc_persona = self::Clean($cc_persona);
    }

    public function getCc_persona()
    {
        return $this->cc_persona;
    }

    public function setUbigeonac($ubigeonac)
    {
        if (empty($ubigeonac)) return;
        $this->ubigeonac = self::Clean($ubigeonac);
    }

    public function getUbigeonac()
    {
        return $this->ubigeonac;
    }

    public function setUbigeodirec($ubigeodirec)
    {
        if (empty($ubigeodirec)) return;
        $this->ubigeodirec = self::Clean($ubigeodirec);
    }

    public function getUbigeodirec()
    {
        return $this->ubigeodirec;
    }

    public function setPais_nacimiento($pais_nacimiento)
    {
        if (empty($pais_nacimiento)) return;
        $this->pais_nacimiento = self::Clean($pais_nacimiento);
    }

    public function getPais_nacimiento()
    {
        return $this->pais_nacimiento;
    }
    public function setTipo_direccion($tipo_direccion)
    {
        if (empty($tipo_direccion)) return;
        $this->tipo_direccion = self::Clean($tipo_direccion);
    }

    public function getTipo_direccion()
    {
        return $this->tipo_direccion;
    }
    public function setC_local_colegiacion($c_local_colegiacion)
    {
        if (empty($c_local_colegiacion)) return;
        $this->c_local_colegiacion = self::Clean($c_local_colegiacion);
    }

    public function getC_local_colegiacion()
    {
        return $this->c_local_colegiacion;
    }
    public function setFecha_de_inicio($fecha_de_inicio)
    {
        if (empty($fecha_de_inicio)) return;
        $this->fecha_de_inicio = self::Clean($fecha_de_inicio);
    }

    public function getFecha_de_inicio()
    {
        return $this->fecha_de_inicio;
    }

    public function setRuc($ruc)
    {
        if (empty($ruc)) return;
        $this->ruc = self::Clean($ruc);
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function setRegularizado($regularizado)
    {
        if (empty($regularizado)) return;
        $this->regularizado = self::Clean($regularizado);
    }

    public function getRegularizado()
    {
        return $this->regularizado;
    }

    public function setGrado($grado)
    {
        if (empty($grado)) return;
        $this->grado = self::Clean($grado);
    }

    public function getGrado()
    {
        return $this->grado;
    }

    public function setDDIRECTO($DDIRECTO)
    {
        if (empty($DDIRECTO)) return;
        $this->DDIRECTO = self::Clean($DDIRECTO);
    }

    public function getDDIRECTO()
    {
        return $this->DDIRECTO;
    }


    public function setUsuario($usuario)
    {
        if (empty($usuario)) return;
        $this->usuario = self::Clean($usuario);
    }

    public function getUsuario()
    {
        return $this->usuario;
    }


    public function setOpc($opc)
    {
        if (empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }


    public function setDesde($desde)
    {
        if (empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function setHasta($hasta)
    {
        if (empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta()
    {
        return $this->hasta;
    }

    public function setRecaudo($recaudo)
    {
        if (empty($recaudo)) return;
        $this->recaudo = self::Clean($recaudo);
    }

    public function getRecaudo()
    {
        return $this->recaudo;
    }
}
