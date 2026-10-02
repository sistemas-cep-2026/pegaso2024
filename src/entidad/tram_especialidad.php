<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_especialidad extends Parse
{

    private $tipo;
    private $grupo;
    private $c_especialidad;
    private $nombre;
    private $numero;
    private $flag_rec;
    private $nombreprint;
    private $resolucion;
    private $super;


    function __construct()
    {

        $this->tipo = '';
        $this->grupo = '';
        $this->c_especialidad = '';
        $this->nombre = '';
        $this->numero = '';
        $this->flag_rec = '';
        $this->nombreprint = '';
        $this->resolucion = '';
        $this->super = '';
    }

    public function setTipo($tipo)
    {
        if (empty($tipo)) return;
        $this->tipo = self::Clean($tipo);
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setGrupo($grupo)
    {
        if (empty($grupo)) return;
        $this->grupo = self::Clean($grupo);
    }

    public function getGrupo()
    {
        return $this->grupo;
    }

    public function setC_especialidad($c_especialidad)
    {
        if (empty($c_especialidad)) return;
        $this->c_especialidad = self::Clean($c_especialidad);
    }

    public function getC_especialidad()
    {
        return $this->c_especialidad;
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

    public function setNumero($numero)
    {
        if (empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setFlag_rec($flag_rec)
    {
        if (empty($flag_rec)) return;
        $this->flag_rec = self::Clean($flag_rec);
    }

    public function getFlag_rec()
    {
        return $this->flag_rec;
    }

    public function setNombreprint($nombreprint)
    {
        if (empty($nombreprint)) return;
        $this->nombreprint = self::Clean($nombreprint);
    }

    public function getNombreprint()
    {
        return $this->nombreprint;
    }

    public function setResolucion($resolucion)
    {
        if (empty($resolucion)) return;
        $this->resolucion = self::Clean($resolucion);
    }

    public function getResolucion()
    {
        return $this->resolucion;
    }

    public function setSuper($super)
    {
        if (empty($super)) return;
        $this->super = self::Clean($super);
    }

    public function getSuper()
    {
        return $this->super;
    }
}
