<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_entidad_pagadora extends Parse
{
    private $c_entidad_pagadora;
    private $c_sector_entidad_pagadora;
    private $c_local;
    private $nombre;
    private $telefono;
    private $direccion;
    private $tipo_via;
    private $distrito;
    private $nota;
    private $flag_habilidad;

    function __construct()
    {
        $this->c_entidad_pagadora = '';
        $this->c_sector_entidad_pagadora = '';
        $this->c_local = '';
        $this->nombre = '';
        $this->telefono = '';
        $this->direccion = '';
        $this->tipo_via = '';
        $this->distrito = '';
        $this->nota = '';
        $this->flag_habilidad = '';
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

    public function setC_sector_entidad_pagadora($c_sector_entidad_pagadora)
    {
        if (empty($c_sector_entidad_pagadora)) return;
        $this->c_sector_entidad_pagadora = self::Clean($c_sector_entidad_pagadora);
    }

    public function getC_sector_entidad_pagadora()
    {
        return $this->c_sector_entidad_pagadora;
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

    public function setNombre($nombre)
    {
        if (empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setTelefono($telefono)
    {
        if (empty($telefono)) return;
        $this->telefono = self::Clean($telefono);
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setDireccion($direccion)
    {
        if (empty($direccion)) return;
        $this->direccion = self::Clean($direccion);
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setTipo_via($tipo_via)
    {
        if (empty($tipo_via)) return;
        $this->tipo_via = self::Clean($tipo_via);
    }

    public function getTipo_via()
    {
        return $this->tipo_via;
    }

    public function setDistrito($distrito)
    {
        if (empty($distrito)) return;
        $this->distrito = self::Clean($distrito);
    }

    public function getDistrito()
    {
        return $this->distrito;
    }

    public function setNota($nota)
    {
        if (empty($nota)) return;
        $this->nota = self::Clean($nota);
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function setFlag_habilidad($flag_habilidad)
    {
        if (empty($flag_habilidad)) return;
        $this->flag_habilidad = self::Clean($flag_habilidad);
    }

    public function getFlag_habilidad()
    {
        return $this->flag_habilidad;
    }
}
