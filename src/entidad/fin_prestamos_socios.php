<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_prestamos_socios extends Parse
{
    private $cc_fraccionamiento;
    private $c_persona;
    private $c_ano;
    private $numero;
    private $fecha;
    private $capital;
    private $num_cuotas;
    private $valor_cuota;
    private $c_usuario;
    private $c_local;
    private $flag;
    private $flag_cancelado;
    private $flag_centralizado;
    private $c_usuario_anula;
    private $fecha_anula;
    private $porc_interes;
    private $c_tipo_interes;

    function __construct()
    {
        $this->cc_fraccionamiento = 0;
        $this->c_persona = '';
        $this->c_ano = '';
        $this->numero = '';
        $this->fecha = '';
        $this->capital = 0;
        $this->num_cuotas = 0;
        $this->valor_cuota = 0;
        $this->c_usuario = '';
        $this->c_local = '';
        $this->flag = '';
        $this->flag_cancelado = '';
        $this->flag_centralizado = '';
        $this->c_usuario_anula = '';
        $this->fecha_anula = '';
        $this->porc_interes = 0;
        $this->c_tipo_interes = '';
    }

    public function setCc_fraccionamiento($cc_fraccionamiento)
    {
        if (empty($cc_fraccionamiento)) return;
        $this->cc_fraccionamiento = self::Clean($cc_fraccionamiento);
    }

    public function getCc_fraccionamiento()
    {
        return $this->cc_fraccionamiento;
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

    public function setC_ano($c_ano)
    {
        if (empty($c_ano)) return;
        $this->c_ano = self::Clean($c_ano);
    }

    public function getC_ano()
    {
        return $this->c_ano;
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

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setCapital($capital)
    {
        if (empty($capital)) return;
        $this->capital = self::Clean($capital);
    }

    public function getCapital()
    {
        return $this->capital;
    }

    public function setNum_cuotas($num_cuotas)
    {
        if (empty($num_cuotas)) return;
        $this->num_cuotas = self::Clean($num_cuotas);
    }

    public function getNum_cuotas()
    {
        return $this->num_cuotas;
    }

    public function setValor_cuota($valor_cuota)
    {
        if (empty($valor_cuota)) return;
        $this->valor_cuota = self::Clean($valor_cuota);
    }

    public function getValor_cuota()
    {
        return $this->valor_cuota;
    }

    public function setC_usuario($c_usuario)
    {
        if (empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
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

    public function setFlag($flag)
    {
        if (empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function setFlag_cancelado($flag_cancelado)
    {
        if (empty($flag_cancelado)) return;
        $this->flag_cancelado = self::Clean($flag_cancelado);
    }

    public function getFlag_cancelado()
    {
        return $this->flag_cancelado;
    }

    public function setFlag_centralizado($flag_centralizado)
    {
        if (empty($flag_centralizado)) return;
        $this->flag_centralizado = self::Clean($flag_centralizado);
    }

    public function getFlag_centralizado()
    {
        return $this->flag_centralizado;
    }

    public function setC_usuario_anula($c_usuario_anula)
    {
        if (empty($c_usuario_anula)) return;
        $this->c_usuario_anula = self::Clean($c_usuario_anula);
    }

    public function getC_usuario_anula()
    {
        return $this->c_usuario_anula;
    }

    public function setFecha_anula($fecha_anula)
    {
        if (empty($fecha_anula)) return;
        $this->fecha_anula = self::Clean($fecha_anula);
    }

    public function getFecha_anula()
    {
        return $this->fecha_anula;
    }

    public function setPorc_interes($porc_interes)
    {
        if (empty($porc_interes)) return;
        $this->porc_interes = self::Clean($porc_interes);
    }

    public function getPorc_interes()
    {
        return $this->porc_interes;
    }

    public function setC_tipo_interes($c_tipo_interes)
    {
        if (empty($c_tipo_interes)) return;
        $this->c_tipo_interes = self::Clean($c_tipo_interes);
    }

    public function getC_tipo_interes()
    {
        return $this->c_tipo_interes;
    }
}
