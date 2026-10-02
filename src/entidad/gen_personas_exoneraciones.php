<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_personas_exoneraciones extends Parse
{
    private $c_persona;
    private $linea;
    private $pais;
    private $motivo;
    private $empresa_nombre;
    private $nombre_inst;
    private $funcion_laboral;
    private $fecha;
    private $mes_salida;
    private $year_salida;
    private $mes_retorno;
    private $year_retorno;
    private $usuario;
    private $sustento;
    private $flag_no_retorno;
    private $cc_exoneracion;

    function __construct()
    {
        $this->c_persona = '';
        $this->linea = 0;
        $this->pais = '';
        $this->motivo = '';
        $this->empresa_nombre = '';
        $this->nombre_inst = '';
        $this->funcion_laboral = '';
        $this->fecha = '';
        $this->mes_salida = '';
        $this->year_salida = 0;
        $this->mes_retorno = '';
        $this->year_retorno = 0;
        $this->usuario = '';
        $this->sustento = '';
        $this->flag_no_retorno = '';
        $this->cc_exoneracion = 0;
    }

    public function setC_persona($c_persona)
    {
        if(empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

    public function setLinea($linea)
    {
        if(empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
    }

    public function setPais($pais)
    {
        if(empty($pais)) return;
        $this->pais = self::Clean($pais);
    }

    public function getPais()
    {
        return $this->pais;
    }

    public function setMotivo($motivo)
    {
        if(empty($motivo)) return;
        $this->motivo = self::Clean($motivo);
    }

    public function getMotivo()
    {
        return $this->motivo;
    }

    public function setEmpresa_nombre($empresa_nombre)
    {
        if(empty($empresa_nombre)) return;
        $this->empresa_nombre = self::Clean($empresa_nombre);
    }

    public function getEmpresa_nombre()
    {
        return $this->empresa_nombre;
    }

    public function setNombre_inst($nombre_inst)
    {
        if(empty($nombre_inst)) return;
        $this->nombre_inst = self::Clean($nombre_inst);
    }

    public function getNombre_inst()
    {
        return $this->nombre_inst;
    }

    public function setFuncion_laboral($funcion_laboral)
    {
        if(empty($funcion_laboral)) return;
        $this->funcion_laboral = self::Clean($funcion_laboral);
    }

    public function getFuncion_laboral()
    {
        return $this->funcion_laboral;
    }

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setMes_salida($mes_salida)
    {
        if(empty($mes_salida)) return;
        $this->mes_salida = self::Clean($mes_salida);
    }

    public function getMes_salida()
    {
        return $this->mes_salida;
    }

    public function setYear_salida($year_salida)
    {
        if(empty($year_salida)) return;
        $this->year_salida = self::Clean($year_salida);
    }

    public function getYear_salida()
    {
        return $this->year_salida;
    }

    public function setMes_retorno($mes_retorno)
    {
        if(empty($mes_retorno)) return;
        $this->mes_retorno = self::Clean($mes_retorno);
    }

    public function getMes_retorno()
    {
        return $this->mes_retorno;
    }

    public function setYear_retorno($year_retorno)
    {
        if(empty($year_retorno)) return;
        $this->year_retorno = self::Clean($year_retorno);
    }

    public function getYear_retorno()
    {
        return $this->year_retorno;
    }

    public function setUsuario($usuario)
    {
        if(empty($usuario)) return;
        $this->usuario = self::Clean($usuario);
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setSustento($sustento)
    {
        if(empty($sustento)) return;
        $this->sustento = self::Clean($sustento);
    }

    public function getSustento()
    {
        return $this->sustento;
    }

    public function setFlag_no_retorno($flag_no_retorno)
    {
        if(empty($flag_no_retorno)) return;
        $this->flag_no_retorno = self::Clean($flag_no_retorno);
    }

    public function getFlag_no_retorno()
    {
        return $this->flag_no_retorno;
    }

    public function setCc_exoneracion($cc_exoneracion)
    {
        if(empty($cc_exoneracion)) return;
        $this->cc_exoneracion = self::Clean($cc_exoneracion);
    }

    public function getCc_exoneracion()
    {
        return $this->cc_exoneracion;
    }

}