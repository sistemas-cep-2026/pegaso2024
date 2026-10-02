<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class web_tram_colegiacion extends Parse
{
    private $c_persona;
    private $c_region;
    private $nombre1;
    private $nombre2;
    private $apellido_Paterno;
    private $apellido_Materno;
    private $cod_documento;
    private $num_documento;
    private $c_pais;
    private $Email;
    private $celular;
    private $telefono;
    private $genero;
    private $fecha_de_nacimiento;
    private $ubigeonac;
    private $estado_civil;
    private $grupo_sanguineo;
    private $factor_sanguineo;
    private $ubigeodirec;
    private $direccion;
    private $prof_titulo;
    private $prof_fecha;
    private $prof_c_universidad;
    private $prof_c_pais;
    private $prof_sunedu;
    private $bach_c_universidad;
    private $bach_fecha;
    private $bach_c_pais;
    private $bach_forma;
    private $bach_nombre;
    private $DP_obs;
    private $col_fecha;
    private $cod_bancario;
    private $estado;
    private $foto;
    private $c_cmp;
    private $prof_modingreso;
    private $prof_sede;
    private $prof_duracion;
    private $prof_exa_suf;
    private $c_usuario;
    private $fecha_proceso;
    private $recaudo;
    private $id_data;

    function __construct()
    {
        $this->c_persona = '';
        $this->c_region = '';
        $this->nombre1 = '';
        $this->nombre2 = '';
        $this->apellido_Paterno = '';
        $this->apellido_Materno = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->c_pais = '';
        $this->Email = '';
        $this->celular = '';
        $this->telefono = '';
        $this->genero = '';
        $this->fecha_de_nacimiento = '';
        $this->ubigeonac = '';
        $this->estado_civil = '';
        $this->grupo_sanguineo = '';
        $this->factor_sanguineo = '';
        $this->ubigeodirec = '';
        $this->direccion = '';
        $this->prof_titulo = '';
        $this->prof_fecha = '';
        $this->prof_c_universidad = '';
        $this->prof_c_pais = '';
        $this->prof_sunedu = '';
        $this->bach_c_universidad = '';
        $this->bach_fecha = '';
        $this->bach_c_pais = '';
        $this->bach_forma = '';
        $this->bach_nombre = '';
        $this->DP_obs = '';
        $this->col_fecha = '';
        $this->cod_bancario = '';
        $this->estado = '';
        $this->foto = '';
        $this->c_cmp = '';
        $this->prof_modingreso = '';
        $this->prof_sede = '';
        $this->prof_duracion = '';
        $this->prof_exa_suf = '';
        $this->c_usuario = '';
        $this->fecha_proceso = '';
        $this->recaudo = '';
        $this->id_data = 0;
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

    public function setC_region($c_region)
    {
        if(empty($c_region)) return;
        $this->c_region = self::Clean($c_region);
    }

    public function getC_region()
    {
        return $this->c_region;
    }

    public function setNombre1($nombre1)
    {
        if(empty($nombre1)) return;
        $this->nombre1 = self::Clean($nombre1);
    }

    public function getNombre1()
    {
        return $this->nombre1;
    }

    public function setNombre2($nombre2)
    {
        if(empty($nombre2)) return;
        $this->nombre2 = self::Clean($nombre2);
    }

    public function getNombre2()
    {
        return $this->nombre2;
    }

    public function setApellido_Paterno($apellido_Paterno)
    {
        if(empty($apellido_Paterno)) return;
        $this->apellido_Paterno = self::Clean($apellido_Paterno);
    }

    public function getApellido_Paterno()
    {
        return $this->apellido_Paterno;
    }

    public function setApellido_Materno($apellido_Materno)
    {
        if(empty($apellido_Materno)) return;
        $this->apellido_Materno = self::Clean($apellido_Materno);
    }

    public function getApellido_Materno()
    {
        return $this->apellido_Materno;
    }

    public function setCod_documento($cod_documento)
    {
        if(empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento()
    {
        return $this->cod_documento;
    }

    public function setNum_documento($num_documento)
    {
        if(empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
    }

    public function setC_pais($c_pais)
    {
        if(empty($c_pais)) return;
        $this->c_pais = self::Clean($c_pais);
    }

    public function getC_pais()
    {
        return $this->c_pais;
    }

    public function setEmail($Email)
    {
        if(empty($Email)) return;
        $this->Email = self::Clean($Email);
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function setCelular($celular)
    {
        if(empty($celular)) return;
        $this->celular = self::Clean($celular);
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setTelefono($telefono)
    {
        if(empty($telefono)) return;
        $this->telefono = self::Clean($telefono);
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setGenero($genero)
    {
        if(empty($genero)) return;
        $this->genero = self::Clean($genero);
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setFecha_de_nacimiento($fecha_de_nacimiento)
    {
        if(empty($fecha_de_nacimiento)) return;
        $this->fecha_de_nacimiento = self::Clean($fecha_de_nacimiento);
    }

    public function getFecha_de_nacimiento()
    {
        return $this->fecha_de_nacimiento;
    }

    public function setUbigeonac($ubigeonac)
    {
        if(empty($ubigeonac)) return;
        $this->ubigeonac = self::Clean($ubigeonac);
    }

    public function getUbigeonac()
    {
        return $this->ubigeonac;
    }

    public function setEstado_civil($estado_civil)
    {
        if(empty($estado_civil)) return;
        $this->estado_civil = self::Clean($estado_civil);
    }

    public function getEstado_civil()
    {
        return $this->estado_civil;
    }

    public function setGrupo_sanguineo($grupo_sanguineo)
    {
        if(empty($grupo_sanguineo)) return;
        $this->grupo_sanguineo = self::Clean($grupo_sanguineo);
    }

    public function getGrupo_sanguineo()
    {
        return $this->grupo_sanguineo;
    }

    public function setFactor_sanguineo($factor_sanguineo)
    {
        if(empty($factor_sanguineo)) return;
        $this->factor_sanguineo = self::Clean($factor_sanguineo);
    }

    public function getFactor_sanguineo()
    {
        return $this->factor_sanguineo;
    }

    public function setUbigeodirec($ubigeodirec)
    {
        if(empty($ubigeodirec)) return;
        $this->ubigeodirec = self::Clean($ubigeodirec);
    }

    public function getUbigeodirec()
    {
        return $this->ubigeodirec;
    }

    public function setDireccion($direccion)
    {
        if(empty($direccion)) return;
        $this->direccion = self::Clean($direccion);
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setProf_titulo($prof_titulo)
    {
        if(empty($prof_titulo)) return;
        $this->prof_titulo = self::Clean($prof_titulo);
    }

    public function getProf_titulo()
    {
        return $this->prof_titulo;
    }

    public function setProf_fecha($prof_fecha)
    {
        if(empty($prof_fecha)) return;
        $this->prof_fecha = self::Clean($prof_fecha);
    }

    public function getProf_fecha()
    {
        return $this->prof_fecha;
    }

    public function setProf_c_universidad($prof_c_universidad)
    {
        if(empty($prof_c_universidad)) return;
        $this->prof_c_universidad = self::Clean($prof_c_universidad);
    }

    public function getProf_c_universidad()
    {
        return $this->prof_c_universidad;
    }

    public function setProf_c_pais($prof_c_pais)
    {
        if(empty($prof_c_pais)) return;
        $this->prof_c_pais = self::Clean($prof_c_pais);
    }

    public function getProf_c_pais()
    {
        return $this->prof_c_pais;
    }

    public function setProf_sunedu($prof_sunedu)
    {
        if(empty($prof_sunedu)) return;
        $this->prof_sunedu = self::Clean($prof_sunedu);
    }

    public function getProf_sunedu()
    {
        return $this->prof_sunedu;
    }

    public function setBach_c_universidad($bach_c_universidad)
    {
        if(empty($bach_c_universidad)) return;
        $this->bach_c_universidad = self::Clean($bach_c_universidad);
    }

    public function getBach_c_universidad()
    {
        return $this->bach_c_universidad;
    }

    public function setBach_fecha($bach_fecha)
    {
        if(empty($bach_fecha)) return;
        $this->bach_fecha = self::Clean($bach_fecha);
    }

    public function getBach_fecha()
    {
        return $this->bach_fecha;
    }

    public function setBach_c_pais($bach_c_pais)
    {
        if(empty($bach_c_pais)) return;
        $this->bach_c_pais = self::Clean($bach_c_pais);
    }

    public function getBach_c_pais()
    {
        return $this->bach_c_pais;
    }

    public function setBach_forma($bach_forma)
    {
        if(empty($bach_forma)) return;
        $this->bach_forma = self::Clean($bach_forma);
    }

    public function getBach_forma()
    {
        return $this->bach_forma;
    }

    public function setBach_nombre($bach_nombre)
    {
        if(empty($bach_nombre)) return;
        $this->bach_nombre = self::Clean($bach_nombre);
    }

    public function getBach_nombre()
    {
        return $this->bach_nombre;
    }

    public function setDP_obs($DP_obs)
    {
        if(empty($DP_obs)) return;
        $this->DP_obs = self::Clean($DP_obs);
    }

    public function getDP_obs()
    {
        return $this->DP_obs;
    }

    public function setCol_fecha($col_fecha)
    {
        if(empty($col_fecha)) return;
        $this->col_fecha = self::Clean($col_fecha);
    }

    public function getCol_fecha()
    {
        return $this->col_fecha;
    }

    public function setCod_bancario($cod_bancario)
    {
        if(empty($cod_bancario)) return;
        $this->cod_bancario = self::Clean($cod_bancario);
    }

    public function getCod_bancario()
    {
        return $this->cod_bancario;
    }

    public function setEstado($estado)
    {
        if(empty($estado)) return;
        $this->estado = self::Clean($estado);
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setFoto($foto)
    {
        if(empty($foto)) return;
        $this->foto = self::Clean($foto);
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setC_cmp($c_cmp)
    {
        if(empty($c_cmp)) return;
        $this->c_cmp = self::Clean($c_cmp);
    }

    public function getC_cmp()
    {
        return $this->c_cmp;
    }

    public function setProf_modingreso($prof_modingreso)
    {
        if(empty($prof_modingreso)) return;
        $this->prof_modingreso = self::Clean($prof_modingreso);
    }

    public function getProf_modingreso()
    {
        return $this->prof_modingreso;
    }

    public function setProf_sede($prof_sede)
    {
        if(empty($prof_sede)) return;
        $this->prof_sede = self::Clean($prof_sede);
    }

    public function getProf_sede()
    {
        return $this->prof_sede;
    }

    public function setProf_duracion($prof_duracion)
    {
        if(empty($prof_duracion)) return;
        $this->prof_duracion = self::Clean($prof_duracion);
    }

    public function getProf_duracion()
    {
        return $this->prof_duracion;
    }

    public function setProf_exa_suf($prof_exa_suf)
    {
        if(empty($prof_exa_suf)) return;
        $this->prof_exa_suf = self::Clean($prof_exa_suf);
    }

    public function getProf_exa_suf()
    {
        return $this->prof_exa_suf;
    }

    public function setC_usuario($c_usuario)
    {
        if(empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
    }

    public function setFecha_proceso($fecha_proceso)
    {
        if(empty($fecha_proceso)) return;
        $this->fecha_proceso = self::Clean($fecha_proceso);
    }

    public function getFecha_proceso()
    {
        return $this->fecha_proceso;
    }

    public function setRecaudo($recaudo)
    {
        if(empty($recaudo)) return;
        $this->recaudo = self::Clean($recaudo);
    }

    public function getRecaudo()
    {
        return $this->recaudo;
    }

    public function setId_data($id_data)
    {
        if(empty($id_data)) return;
        $this->id_data = self::Clean($id_data);
    }

    public function getId_data()
    {
        return $this->id_data;
    }

}