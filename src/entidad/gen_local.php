<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_local extends Parse
{
    private $c_local;
    private $nombre;
    private $nombre_abv;
    private $c_local_ref;
    private $flag_administrativo;
    private $local_direc;
    private $local_tel;
    private $local_mail;
    private $sexo_decano;
    private $distrito;
    private $firma_decano;
    private $whatsapp;
    private $c_local_vinculado;
    private $adm;

    function __construct()
    {
        $this->c_local = '';
        $this->nombre = '';
        $this->nombre_abv = '';
        $this->c_local_ref = '';
        $this->flag_administrativo = '';
        $this->local_direc = '';
        $this->local_tel = '';
        $this->local_mail = '';
        $this->sexo_decano = '';
        $this->distrito = '';
        $this->firma_decano = '';
        $this->whatsapp = '';
        $this->c_local_vinculado = '';
        $this->adm = '';
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

    public function setNombre_abv($nombre_abv)
    {
        if (empty($nombre_abv)) return;
        $this->nombre_abv = self::Clean($nombre_abv);
    }

    public function getNombre_abv()
    {
        return $this->nombre_abv;
    }

    public function setC_local_ref($c_local_ref)
    {
        if (empty($c_local_ref)) return;
        $this->c_local_ref = self::Clean($c_local_ref);
    }

    public function getC_local_ref()
    {
        return $this->c_local_ref;
    }

    public function setFlag_administrativo($flag_administrativo)
    {
        if (empty($flag_administrativo)) return;
        $this->flag_administrativo = self::Clean($flag_administrativo);
    }

    public function getFlag_administrativo()
    {
        return $this->flag_administrativo;
    }

    public function setLocal_direc($local_direc)
    {
        if (empty($local_direc)) return;
        $this->local_direc = self::Clean($local_direc);
    }

    public function getLocal_direc()
    {
        return $this->local_direc;
    }

    public function setLocal_tel($local_tel)
    {
        if (empty($local_tel)) return;
        $this->local_tel = self::Clean($local_tel);
    }

    public function getLocal_tel()
    {
        return $this->local_tel;
    }

    public function setLocal_mail($local_mail)
    {
        if (empty($local_mail)) return;
        $this->local_mail = self::Clean($local_mail);
    }

    public function getLocal_mail()
    {
        return $this->local_mail;
    }

    public function setSexo_decano($sexo_decano)
    {
        if (empty($sexo_decano)) return;
        $this->sexo_decano = self::Clean($sexo_decano);
    }

    public function getSexo_decano()
    {
        return $this->sexo_decano;
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

    public function setFirma_decano($firma_decano)
    {
        if (empty($firma_decano)) return;
        $this->firma_decano = self::Clean($firma_decano);
    }

    public function getFirma_decano()
    {
        return $this->firma_decano;
    }

    public function setWhatsapp($whatsapp)
    {
        if (empty($whatsapp)) return;
        $this->whatsapp = self::Clean($whatsapp);
    }

    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    public function setC_local_vinculado($c_local_vinculado)
    {
        if (empty($c_local_vinculado)) return;
        $this->c_local_vinculado = self::Clean($c_local_vinculado);
    }

    public function getC_local_vinculado()
    {
        return $this->c_local_vinculado;
    }

    public function setAdm($adm)
    {
        if (empty($adm)) return;
        $this->adm = self::Clean($adm);
    }

    public function getAdm()
    {
        return $this->adm;
    }
}
