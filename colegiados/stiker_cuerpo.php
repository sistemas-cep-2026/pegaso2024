 <?php
  $dato_personales = $bo_personas->resolucion_data($tipo, $c_tipo, digitos($cep,'6'));
  foreach ($dato_personales as $rowdetalle) {
    $nombre_completo_detalle = $rowdetalle["nombre"];
    $fecha = $rowdetalle["fecha"];
    $num_documento = $rowdetalle["num_documento"];
    $sexo = $rowdetalle["cod_sexo"];
    $nombre1 = $rowdetalle["nombre1"];
    $c_year = $rowdetalle["c_year"];
    $res = $rowdetalle["N_RESOLUCION_cole"];
    $libro = $rowdetalle["n_libro_cole"];
    $folio = $rowdetalle["n_folio_cole"];
    $residentado = $rowdetalle["residentado"];
    $c_persona = $rowdetalle["c_persona"];
    $apellido_paterno = $rowdetalle["apellido_paterno"];
    $apellido_materno = $rowdetalle["apellido_materno"];
    $nombre1 = $rowdetalle["na"];
    $nombre2 = $rowdetalle["nb"];
  }
  ?>

 <table width="100%" align="center">
   <tr>
     <td align="center"><span class="firma01"><strong>
           <?php
            if ($tipo == 'C') {
              echo "LICENCIATURA";
            }
            if ($tipo == 'E') {
              echo "ESPECIALIDAD";
            }
            if ($tipo == 'M') {
              echo "MAESTRIA";
            }
            if ($tipo == 'D') {
              echo "DOCTORADO";
            }
            if ($tipo == 'A') {
              echo "AUDITORIA";
            } ?>
           . </strong>Por Resoluci&oacute;n N&deg;
         <?php
          if ($tipo == 'C') {
            echo $res . "-CEP/CN.";
          }
          if ($tipo == 'E') {
            echo "025-00-CEP/CN.";
          }
          if ($tipo == 'M') {
            echo "208-02-CEP/CN.";
          }
          if ($tipo == 'D') {
            echo "141-08-CEP/CN.";
          }
          if ($tipo == 'A') {
            echo "236-19-CEP/CN.";
          } ?>
         El T&iacute;tulo de
         <?php if ($sexo == 'M') {
            echo "Don";
          } else {
            echo "Do&ntilde;a";
          } ?>
         :</span></td>
     <td rowspan="3" align="center" valign="middle"><span class="firma0111"></span></td>
   </tr>
   <tr align="center">
     <td><span class="titulo01"><strong><?php echo $apellido_paterno . ' ' . $apellido_materno; ?></span><strong> </td>
   </tr>
   <tr align="center">
     <td><span class="titulo01"><strong><?php echo $nombre1 . ' ' . $nombre2; ?></strong></span></td>
   </tr>
   <tr align="center">
     <td colspan="2"><span class="firma01">Ha sido registrado en el Libro
         <?php if ($tipo == 'C') {
            echo " de Inscripci&oacute;n de T&iacute;tulos";
          }
          if ($tipo == 'E') {
            echo " de T&iacute;tulos de Especialidad";
            if ($residentado == '*') {
              echo " - Con Residentado -";
            }
          }
          if ($tipo == 'M') {
            echo " de T&iacute;tulos de Maestr&iacute;a";
          }
          if ($tipo == 'D') {
            echo " de T&iacute;tulos de Doctorado";
          }
          if ($tipo == 'A') {
            echo " de Auditores";
          } ?>
         &nbsp;del Colegio de Enfermeros del Per&uacute;.</span></td>
   </tr>
   <tr align="center">
     <td colspan="2"><strong>
         <?php
          if ($tipo == 'C') {
            echo "COLEGIACION";
          }
          if ($tipo == 'E') {
            echo "ESPECIALIDAD";
            if ($residentado == '*') {
              echo " - Con Residentado -";
            }
          }
          if ($tipo == 'M') {
            echo "MAESTRIA";
          }
          if ($tipo == 'D') {
            echo "DOCTORADO";
          }
          if ($tipo == 'A') {
            echo "AUDITORIA";
          } ?>
         <?php echo " N&deg; " . digitos($cep, 6); ?>.<span class="firma01"> Libro N&deg;<strong><?php echo $libro; ?></strong>, F&deg;<strong><?php echo $folio; ?>&nbsp;<strong> Lima, <?php echo fechatexto($fecha) ?>.</strong></span></td>
   </tr>
 </table>