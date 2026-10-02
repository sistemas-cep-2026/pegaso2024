<?php
require_once dirname(__DIR__) . '/dao/dao_tram_actividad_sustento.php';
class bo_tram_actividad_sustento
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_actividad_sustento();
    }

    public function control(tram_actividad_sustento $obj, $opc)
    {
        switch($opc){
            case "I":
            return $this->dao->insertar($obj);
            break;
            case "U":
            return $this->dao->modificar($obj);
            break;
            case "E":
            return $this->dao->eliminar($obj);
            break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }
    
    public function listarIDMax(){
        $sql = "select max(cc_sustento) as maximo
        from tram_actividad_sustento";
        return $this->dao->consulta($sql);
    }
    public function listarAnhos()
    {
        $sql = "select DISTINCT YEAR(fecha) AS anho
        FROM dbo.tram_actividad_sustento
        ORDER BY anho desc";
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_actividad_sustento $obj = null)
    {
        $sql = "select cc_sustento,
        usuario,
        cc_area_adm,
        fecha_registro,
        dbo.fc_fecha_from(fecha) fecha,
        obs,
        rtrim(dia) as dia,
        cc_local,
        flag
        FROM dbo.tram_actividad_sustento
        WHERE cc_sustento='".$obj->getCc_sustento()."'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ahnousuario(tram_actividad_sustento $obj = null){
        $sql="select year(fecha) as anho from tram_actividad_sustento
        where usuario='".$obj->getUsuario()."'
        group by year(fecha)
        order by year(fecha) desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarUsuariosActividades(tram_actividad_sustento $obj = null){

        $sql="select u.usuario, p.nombre
        from tram_actividad_sustento s inner join seg_usuarios u (nolock)
        on rtrim(s.usuario)=rtrim(u.usuario)
        inner join gen_personas p (nolock)
        on u.cc_persona=p.cc_persona
        where year(s.fecha)='".$obj->getAnho()."' 
        and s.cc_local='".$obj->getCc_local()."' 
        and month(s.fecha)='".$obj->getPeriodo()."'
        group by u.usuario, p.nombre
        order by rtrim(p.nombre) asc";
        return $this->dao->consulta($sql);
    }

    /*************Repor al usuario********/

    public function ListarActiDia(tram_actividad_sustento $obj = null) /*para sacar el dia semana, sabado o feriado*/
    {
        $sql="select dia,
        dbo.fc_v1_parametro_valor('tram_actividad_sustento','dia',dia) as dia_text
        from tram_actividad_sustento
        where year(fecha)='".$obj->getAnho()."'
        and cc_local='".$obj->getcc_local()."'
        and month(fecha)='".$obj->getPeriodo()."'";

        if (strlen($obj->getUsuario()) >0) {
            $sql .= " and usuario= '".$obj->getUsuario()."'";
        }
        $sql.=" group by dia";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarActiMensual(tram_actividad_sustento $obj = null)
    {
        $sql="select s.cc_sustento,
        dbo.fc_fecha_texto(s.fecha) as fecha,
        dbo.fc_fecha_from(s.fecha) as fecha_from,
        dbo.fc_v1_parametro_valor('tram_actividad_sustento','dia',s.dia) as dia_text,
        a.nombre as area,
        d.cc_sustento_det,
        cast(d.horaini as varchar(5)) as horaini,
        CAST(d.horafin as varchar(5)) as horafin,
        DATEDIFF(minute,d.horaini,d.horafin) as minutos,
        d.obs
        FROM tram_actividad_sustento s left join  tram_actividad_sustento_detalle d
        on s.cc_sustento=d.cc_sustento
        inner join gen_area_adm a
        on s.cc_area_adm=a.cc_area_adm
        where year(s.fecha)='".$obj->getAnho()."'
        and s.cc_local='".$obj->getCc_local()."'
        and month(s.fecha)='".$obj->getPeriodo()."'";

        if (strlen($obj->getUsuario()) >0) {
            $sql .= " and s.usuario= '".$obj->getUsuario()."'";
        }
        if (strlen($obj->getDia()) >0) {
            $sql .= " and s.dia= '".$obj->getDia()."'";
        }
        if (strlen($obj->getFlag()) >0) {
            $sql .= " and s.flag= '".$obj->getFlag()."'";
        }
        $sql.=" order by s.fecha";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function totalhoras(tram_actividad_sustento $obj = null){
        $sql="select  dbo.fc_v1_parametro_valor('tram_actividad_sustento','dia',ac.dia) as dia ,
        SUM( DATEDIFF(MINUTE,d.horaini,d.horafin)/60)+(SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))/60) 
        AS horas,
        SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))-((SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))/60) *60) AS minutos,
        REPLICATE('0',2-LEN(RTRIM(SUM( DATEDIFF(MINUTE,d.horaini,d.horafin)/60)+(SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))/60) )))
        +
        RTRIM(SUM( DATEDIFF(MINUTE,d.horaini,d.horafin)/60)+(SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))/60))+':'+
        REPLICATE('0',2-LEN(RTRIM(SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))-((SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))/60) *60))))+RTRIM(SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))-((SUM(DATEDIFF(MINUTE,DATEADD(HH,(DATEDIFF(MINUTE,d.horaini,d.horafin)/60),d.horaini),d.horafin))/60) *60))
        +':00' as total
        from tram_actividad_sustento ac inner join tram_actividad_sustento_detalle d
        on ac.cc_sustento=d.cc_sustento
        where year(ac.fecha)='".$obj->getAnho()."'
        and ac.cc_local='".$obj->getCc_local()."'
        and month(ac.fecha)='".$obj->getPeriodo()."'";
        if (strlen($obj->getUsuario()) >0) {
            $sql .= " and ac.usuario='".$obj->getUsuario()."'";
        }

        $sql .= " GROUP BY  dbo.fc_v1_parametro_valor('tram_actividad_sustento','dia',ac.dia)";
        return $this->dao->consulta($sql);
    }

    /** Dashboard */
    public function cantidadPorLocal($cc_local, $anho)
    {
        $filtro_local = !empty($cc_local) ? " AND cc_local = '{$cc_local}'" : "";
        $sql = "SELECT COUNT(*) AS cantidad
        FROM tram_actividad_sustento
        WHERE YEAR(fecha) = '{$anho}'{$filtro_local}";
        return $this->dao->consulta($sql);
    }

}