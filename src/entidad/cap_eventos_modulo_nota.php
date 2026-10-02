<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos_modulo_nota extends Parse
{
    private $cc_modnota;
    private $cc_capmod;
    private $cc_evento_mat;
    private $nota;

    function __construct()
    {
        $this->cc_modnota = 0;
        $this->cc_capmod = 0;
        $this->cc_evento_mat = 0;
        $this->nota = null;
    }

    public function setCc_modnota($cc_modnota)
    {
        if (empty($cc_modnota)) return;
        $this->cc_modnota = self::Clean($cc_modnota);
    }

    public function getCc_modnota()
    {
        return $this->cc_modnota;
    }

    public function setCc_capmod($cc_capmod)
    {
        if (empty($cc_capmod)) return;
        $this->cc_capmod = self::Clean($cc_capmod);
    }

    public function getCc_capmod()
    {
        return $this->cc_capmod;
    }

    public function setCc_evento_mat($cc_evento_mat)
    {
        if (empty($cc_evento_mat)) return;
        $this->cc_evento_mat = self::Clean($cc_evento_mat);
    }

    public function getCc_evento_mat()
    {
        return $this->cc_evento_mat;
    }

    public function setNota($nota)
    {
        // nota puede ser 0 (desaprobado), no usar empty()
        if ($nota === null || $nota === '') {
            $this->nota = null;
            return;
        }
        $this->nota = self::Clean($nota);
    }

    public function getNota()
    {
        return $this->nota;
    }
}
