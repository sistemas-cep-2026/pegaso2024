<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_puntos_de_venta extends Parse
{
    private $c_punto_de_venta;
    private $nombre;
    private $fc_ult_numero;
    private $bc_ult_numero;
    private $na_ult_numero;
    private $nc_ult_numero;
    private $ri_ult_numero;
    private $c_local;
    private $flag_recibo_reg_vta;
    private $flag_centralizado;
    private $flag_sucursal;
    private $bc_ult_numero_fin;
    private $flag_activo;
    private $fc_flag;
    private $bc_flag;
    private $ri_flag;
    private $nc_fe_ult_numero;
    private $nc_be_ult_numero;

    function __construct()
    {
        $this->c_punto_de_venta = '';
        $this->nombre = '';
        $this->fc_ult_numero = '';
        $this->bc_ult_numero = '';
        $this->na_ult_numero = '';
        $this->nc_ult_numero = '';
        $this->ri_ult_numero = '';
        $this->c_local = '';
        $this->flag_recibo_reg_vta = '';
        $this->flag_centralizado = '';
        $this->flag_sucursal = '';
        $this->bc_ult_numero_fin = '';
        $this->flag_activo = '';
        $this->fc_flag = '';
        $this->bc_flag = '';
        $this->ri_flag = '';
        $this->nc_fe_ult_numero = '';
        $this->nc_be_ult_numero = '';
    }

    public function setC_punto_de_venta($c_punto_de_venta)
    {
        if(empty($c_punto_de_venta)) return;
        $this->c_punto_de_venta = self::Clean($c_punto_de_venta);
    }

    public function getC_punto_de_venta()
    {
        return $this->c_punto_de_venta;
    }

    public function setNombre($nombre)
    {
        if(empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setFc_ult_numero($fc_ult_numero)
    {
        if(empty($fc_ult_numero)) return;
        $this->fc_ult_numero = self::Clean($fc_ult_numero);
    }

    public function getFc_ult_numero()
    {
        return $this->fc_ult_numero;
    }

    public function setBc_ult_numero($bc_ult_numero)
    {
        if(empty($bc_ult_numero)) return;
        $this->bc_ult_numero = self::Clean($bc_ult_numero);
    }

    public function getBc_ult_numero()
    {
        return $this->bc_ult_numero;
    }

    public function setNa_ult_numero($na_ult_numero)
    {
        if(empty($na_ult_numero)) return;
        $this->na_ult_numero = self::Clean($na_ult_numero);
    }

    public function getNa_ult_numero()
    {
        return $this->na_ult_numero;
    }

    public function setNc_ult_numero($nc_ult_numero)
    {
        if(empty($nc_ult_numero)) return;
        $this->nc_ult_numero = self::Clean($nc_ult_numero);
    }

    public function getNc_ult_numero()
    {
        return $this->nc_ult_numero;
    }

    public function setRi_ult_numero($ri_ult_numero)
    {
        if(empty($ri_ult_numero)) return;
        $this->ri_ult_numero = self::Clean($ri_ult_numero);
    }

    public function getRi_ult_numero()
    {
        return $this->ri_ult_numero;
    }

    public function setC_local($c_local)
    {
        if(empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setFlag_recibo_reg_vta($flag_recibo_reg_vta)
    {
        if(empty($flag_recibo_reg_vta)) return;
        $this->flag_recibo_reg_vta = self::Clean($flag_recibo_reg_vta);
    }

    public function getFlag_recibo_reg_vta()
    {
        return $this->flag_recibo_reg_vta;
    }

    public function setFlag_centralizado($flag_centralizado)
    {
        if(empty($flag_centralizado)) return;
        $this->flag_centralizado = self::Clean($flag_centralizado);
    }

    public function getFlag_centralizado()
    {
        return $this->flag_centralizado;
    }

    public function setFlag_sucursal($flag_sucursal)
    {
        if(empty($flag_sucursal)) return;
        $this->flag_sucursal = self::Clean($flag_sucursal);
    }

    public function getFlag_sucursal()
    {
        return $this->flag_sucursal;
    }

    public function setBc_ult_numero_fin($bc_ult_numero_fin)
    {
        if(empty($bc_ult_numero_fin)) return;
        $this->bc_ult_numero_fin = self::Clean($bc_ult_numero_fin);
    }

    public function getBc_ult_numero_fin()
    {
        return $this->bc_ult_numero_fin;
    }

    public function setFlag_activo($flag_activo)
    {
        if(empty($flag_activo)) return;
        $this->flag_activo = self::Clean($flag_activo);
    }

    public function getFlag_activo()
    {
        return $this->flag_activo;
    }

    public function setFc_flag($fc_flag)
    {
        if(empty($fc_flag)) return;
        $this->fc_flag = self::Clean($fc_flag);
    }

    public function getFc_flag()
    {
        return $this->fc_flag;
    }

    public function setBc_flag($bc_flag)
    {
        if(empty($bc_flag)) return;
        $this->bc_flag = self::Clean($bc_flag);
    }

    public function getBc_flag()
    {
        return $this->bc_flag;
    }

    public function setRi_flag($ri_flag)
    {
        if(empty($ri_flag)) return;
        $this->ri_flag = self::Clean($ri_flag);
    }

    public function getRi_flag()
    {
        return $this->ri_flag;
    }

    public function setNc_fe_ult_numero($nc_fe_ult_numero)
    {
        if(empty($nc_fe_ult_numero)) return;
        $this->nc_fe_ult_numero = self::Clean($nc_fe_ult_numero);
    }

    public function getNc_fe_ult_numero()
    {
        return $this->nc_fe_ult_numero;
    }

    public function setNc_be_ult_numero($nc_be_ult_numero)
    {
        if(empty($nc_be_ult_numero)) return;
        $this->nc_be_ult_numero = self::Clean($nc_be_ult_numero);
    }

    public function getNc_be_ult_numero()
    {
        return $this->nc_be_ult_numero;
    }

}