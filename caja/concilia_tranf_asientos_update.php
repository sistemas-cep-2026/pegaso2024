 <?php

   require_once(dirname(__DIR__) . "/util/seguridad.php");
   require_once(dirname(__DIR__) . "/util/util.php");
   s_validar_pagina();
   require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
   require_once(u_src() . "bo/bo_general.php");

   $bo_general = new bo_general();
   $bo_teso_conc = new bo_teso_conciliacion_mensual();

   $ent_teso_conc = new teso_conciliacion_mensual();


   try {


      $cc_local = s_crypt($_REQUEST["cc_local"], 'out');
      $cod_anho = s_crypt($_REQUEST["cod_anho"], 'out');
      $cod_mes = s_crypt($_REQUEST["cod_mes"], 'out');
      $c_usuario = s_crypt($_REQUEST["c_usuario"], 'out');


      $ent_teso_conc->setCc_local($cc_local);
      $ent_teso_conc->setCod_anho($cod_anho);
      $ent_teso_conc->setCod_mes($cod_mes);
      $ent_teso_conc->setAsiento_usuario($c_usuario);


      $val = $bo_teso_conc->procesar_asiento($ent_teso_conc);
      if (!$val) {
         throw new Exception($bo_teso_conc->errores());
      }
    echo '0';

} catch (Exception $e) {
    echo $e->getMessage();
}