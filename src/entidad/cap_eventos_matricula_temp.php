<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos_matricula_temp extends Parse
{
    private $cc_evento_mattemp;
    private $cc_evento;
    private $cep;
    private $num_documento;
    private $nombre;
    private $asistente;
    private $ponente;
    private $organizador;

    function __construct()
    {
        $this->cc_evento_mattemp = 0;
        $this->cc_evento = 0;
        $this->cep = null;
        $this->num_documento = null;
        $this->nombre = '';
        $this->asistente = '0';
        $this->ponente = '0';
        $this->organizador = '0';
    }

    public function setCc_evento_mattemp($cc_evento_mattemp)
    {
        if (empty($cc_evento_mattemp)) return;
        $this->cc_evento_mattemp = self::Clean($cc_evento_mattemp);
    }

    public function getCc_evento_mattemp()
    {
        return $this->cc_evento_mattemp;
    }

    public function setCc_evento($cc_evento)
    {
        if (empty($cc_evento)) return;
        $this->cc_evento = self::Clean($cc_evento);
    }

    public function getCc_evento()
    {
        return $this->cc_evento;
    }

    public function setCep($cep)
    {
        if ($cep === null || trim($cep) === '') {
            $this->cep = null;
            return;
        }
        $this->cep = self::Clean($cep);
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setNum_documento($num_documento)
    {
        if ($num_documento === null || trim($num_documento) === '') {
            $this->num_documento = null;
            return;
        }
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
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

    public function setAsistente($asistente)
    {
        $this->asistente = ($asistente == '1') ? '1' : '0';
    }

    public function getAsistente()
    {
        return $this->asistente;
    }

    public function setPonente($ponente)
    {
        $this->ponente = ($ponente == '1') ? '1' : '0';
    }

    public function getPonente()
    {
        return $this->ponente;
    }

    public function setOrganizador($organizador)
    {
        $this->organizador = ($organizador == '1') ? '1' : '0';
    }

    public function getOrganizador()
    {
        return $this->organizador;
    }
}
