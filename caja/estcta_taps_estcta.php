<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_fin_estado_de_cuenta.php");
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_general.php");


$bo_general = new bo_general();
$bo_est_cta = new bo_fin_estado_de_cuenta();
$bo_personas = new bo_gen_personas();

$c_persona = s_crypt($_REQUEST['cc_persona'], 'out');

$data_es_cta = $bo_est_cta->ListarID($c_persona);
$data_es_cta_total = $bo_est_cta->ListarID_total($c_persona);

?>

<div class="table-responsive">
    <table class="table table-striped table-sm-pequena">
        <thead>
            <tr>
                <th class="text-center" style="border: 1px solid #999999;">AÑO</th>
                <th class="text-center" style="border: 1px solid #999999;">ENE</th>
                <th class="text-center" style="border: 1px solid #999999;">FEB</th>
                <th class="text-center" style="border: 1px solid #999999;">MAR</th>
                <th class="text-center" style="border: 1px solid #999999;">ABR</th>
                <th class="text-center" style="border: 1px solid #999999;">MAY</th>
                <th class="text-center" style="border: 1px solid #999999;">JUN</th>
                <th class="text-center" style="border: 1px solid #999999;">JUL</th>
                <th class="text-center" style="border: 1px solid #999999;">AGO</th>
                <th class="text-center" style="border: 1px solid #999999;">SET</th>
                <th class="text-center" style="border: 1px solid #999999;">OCT</th>
                <th class="text-center" style="border: 1px solid #999999;">NOV</th>
                <th class="text-center" style="border: 1px solid #999999;">DIC</th>
                <th class="text-center" style="border: 1px solid #999999;">SALDO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($data_es_cta as $row) {
                $abono = $row["m1"] + $row["m2"] + $row["m3"] + $row["m4"] + $row["m5"] + $row["m6"] + $row["m7"] + $row["m8"] + $row["m9"] + $row["m10"] + $row["m11"] + $row["m12"];
                $cargo = $row["c1"] + $row["c2"] + $row["c3"] + $row["c4"] + $row["c5"] + $row["c6"] + $row["c7"] + $row["c8"] + $row["c9"] + $row["c10"] + $row["c11"] + $row["c12"];


                $total_ano = $cargo - $abono;
                $total += $total_ano;
            ?>
                <tr>
                    <td class="align-middle text-center"><?php echo $row["ano"] ?></td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM1 = decimal($row["m1"] * -1, 2);
                        if ($decimalM1 == 0.00 && $row["c1"] <> 0.00) {
                            echo "<u>{$row['c1']}</u>";
                        } elseif ($decimalM1 != 0.00) {
                            $enero = decimal($row["m1"], 2) . $row["p1"];
                            echo ($row["c1"] != $row["m1"]) ? "<u>{$enero}</u>" : $enero;
                        }


                        if (($row["aportoen1"] != $row["debea1"]) || ($row["c1"] != $row["m1"])) {

                            echo
                            '</br>  ' . $row["debea1"] .
                                ' | ' .
                                $row["aportoen1"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM2 = decimal($row["m2"] * -1, 2);
                        if ($decimalM2 == 0.00 && $row["c2"] <> 0.00) {
                            echo "<u>{$row['c2']}</u>";
                        } elseif ($decimalM2 != 0.00) {
                            $feb = decimal($row["m2"], 2) . $row["p2"];
                            echo ($row["c2"] != $row["m2"]) ? "<u>{$feb}</u>" : $feb;
                        }


                        if (($row["aportoen2"] != $row["debea2"]) || ($row["c2"] != $row["m2"])) {

                            echo
                            '</br>' . $row["debea2"] .
                                ' | ' .
                                $row["aportoen2"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM3 = decimal($row["m3"] * -1, 2);
                        if ($decimalM3 == 0.00 && $row["c3"] <> 0.00) {
                            echo "<u>{$row['c3']}</u>";
                        } elseif ($decimalM3 != 0.00) {
                            $marz = decimal($row["m3"], 2) . $row["p3"];
                            echo ($row["c3"] != $row["m3"]) ? "<u>{$marz}</u>" : $marz;
                        }
                        if (($row["aportoen3"] != $row["debea3"]) || ($row["c3"] != $row["m3"])) {

                            echo
                            '</br>' . $row["debea3"] .
                                ' | ' .
                                $row["aportoen3"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM4 = decimal($row["m4"] * -1, 2);
                        if ($decimalM4 == 0.00 && $row["c4"] <> 0.00) {
                            echo "<u>{$row['c4']}</u>";
                        } elseif ($decimalM4 != 0.00) {
                            $abril = decimal($row["m4"], 2) . $row["p4"];
                            echo ($row["c4"] != $row["m4"]) ? "<u>{$abril}</u>" : $abril;
                        }
                        if (($row["aportoen4"] != $row["debea4"]) || ($row["c4"] != $row["m4"])) {

                            echo
                            '</br>' . $row["debea4"] .
                                ' | ' .
                                $row["aportoen4"];
                        }

                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM5 = decimal($row["m5"] * -1, 2);
                        if ($decimalM5 == 0.00 && $row["c5"] <> 0.00) {
                            echo "<u>{$row['c5']}</u>";
                        } elseif ($decimalM5 != 0.00) {
                            $mayo = decimal($row["m5"], 2) . $row["p5"];
                            echo ($row["c5"] != $row["m5"]) ? "<u>{$mayo}</u>" : $mayo;
                        }
                        if (($row["aportoen5"] != $row["debea5"]) || ($row["c5"] != $row["m5"])) {

                            echo
                            '</br>' . $row["debea5"] .
                                ' | ' .
                                $row["aportoen5"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM6 = decimal($row["m6"] * -1, 2);
                        if ($decimalM6 == 0.00 && $row["c6"] <> 0.00) {
                            echo "<u>{$row['c6']}</u>";
                        } elseif ($decimalM6 != 0.00) {
                            $junio = decimal($row["m6"], 2) . $row["p6"];
                            echo ($row["c6"] != $row["m6"]) ? "<u>{$junio}</u>" : $junio;
                        }
                        if (($row["aportoen6"] != $row["debea6"]) || ($row["c6"] != $row["m6"])) {

                            echo
                            '</br>' . $row["debea6"] .
                                ' | ' .
                                $row["aportoen6"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM7 = decimal($row["m7"] * -1, 2);
                        if ($decimalM7 == 0.00 && $row["c7"] <> 0.00) {
                            echo "<u>{$row['c7']}</u>";
                        } elseif ($decimalM7 != 0.00) {
                            $julio = decimal($row["m7"], 2) . $row["p7"];
                            echo ($row["c7"] != $row["m7"]) ? "<u>{$julio}</u>" : $julio;
                        }
                        if (($row["aportoen7"] != $row["debea7"]) || ($row["c7"] != $row["m7"])) {

                            echo
                            '</br>' . $row["debea7"] .
                                ' | ' .
                                $row["aportoen7"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM8 = decimal($row["m8"] * -1, 2);
                        if ($decimalM8 == 0.00 && $row["c8"] <> 0.00) {
                            echo "<u>{$row['c8']}</u>";
                        } elseif ($decimalM8 != 0.00) {
                            $agos = decimal($row["m8"], 2) . $row["p8"];
                            echo ($row["c8"] != $row["m8"]) ? "<u>{$agos}</u>" : $agos;
                        }
                        if (($row["aportoen8"] != $row["debea8"]) || ($row["c8"] != $row["m8"])) {

                            echo
                            '</br>' . $row["debea8"] .
                                ' | ' .
                                $row["aportoen8"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM9 = decimal($row["m9"] * -1, 2);
                        if ($decimalM9 == 0.00 && $row["c9"] <> 0.00) {
                            echo "<u>{$row['c9']}</u>";
                        } elseif ($decimalM9 != 0.00) {
                            $sept = decimal($row["m9"], 2) . $row["p9"];
                            echo ($row["c9"] != $row["m9"]) ? "<u>{$sept}</u>" : $sept;
                        }
                        if (($row["aportoen9"] != $row["debea9"]) || ($row["c9"] != $row["m9"])) {

                            echo
                            '</br>' . $row["debea9"] .
                                ' | ' .
                                $row["aportoen9"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM10 = decimal($row["m10"] * -1, 2);
                        if ($decimalM10 == 0.00 && $row["c10"] <> 0.00) {
                            echo "<u>{$row['c10']}</u>";
                        } elseif ($decimalM10 != 0.00) {
                            $oct = decimal($row["m10"], 2) . $row["p10"];
                            echo ($row["c10"] != $row["m10"]) ? "<u>{$oct}</u>" : $oct;
                        }
                        if (($row["aportoen10"] != $row["debea10"]) || ($row["c10"] != $row["m10"])) {

                            echo
                            '</br>' . $row["debea10"] .
                                ' | ' .
                                $row["aportoen10"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM11 = decimal($row["m11"] * -1, 2);
                        if ($decimalM11 == 0.00 && $row["c11"] <> 0.00) {
                            echo "<u>{$row['c11']}</u>";
                        } elseif ($decimalM11 != 0.00) {
                            $nov = decimal($row["m11"], 2) . $row["p11"];
                            echo ($row["c11"] != $row["m11"]) ? "<u>{$nov}</u>" : $nov;
                        }
                        if (($row["aportoen11"] != $row["debea11"]) || ($row["c11"] != $row["m11"])) {

                            echo
                            '</br>' . $row["debea11"] .
                                ' | ' .
                                $row["aportoen11"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center">
                        <?php
                        $decimalM12 = decimal($row["m12"] * -1, 2);
                        if ($decimalM12 == 0.00 && $row["c12"] <> 0.00) {
                            echo "<u>{$row['c12']}</u>";
                        } elseif ($decimalM12 != 0.00) {
                            $dic = decimal($row["m12"], 2) . $row["p12"];
                            echo ($row["c12"] != $row["m12"]) ? "<u>{$dic}</u>" : $dic;
                        }
                        if (($row["aportoen12"] != $row["debea12"]) || ($row["c12"] != $row["m12"])) {

                            echo
                            '</br>' . $row["debea12"] .
                                ' | ' .
                                $row["aportoen12"];
                        }
                        ?>
                    </td>
                    <td class="align-middle text-center"><?php echo decimal($total_ano, 2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <table class="table table-striped table-sm-pequena">
        <thead>
            <tr>
                <th class="text-center" style="border: 1px solid #999999;">CONSEJO REGIONAL</th>
                <th class="text-center" style="border: 1px solid #999999;">TOTAL DEUDA </th>
                <th class="text-center" style="border: 1px solid #999999;">TOTAL ABONO </th>
                <th class="text-center" style="border: 1px solid #999999;">SALDO</th>

            </tr>
        </thead>
        <tbody>
 <?php
            $total = 0;
            foreach ($data_es_cta_total as $row) {
             
            ?>
                <tr>
                    <td class="align-middle text-center"><?php echo $row["c_local"] ?></td>
                     <td class="align-middle text-center"><?php echo decimal($row["deuda"],2); ?></td>
                      <td class="align-middle text-center"><?php echo  decimal($row["abono"],2); ?></td>
                       <td class="align-middle text-center"><?php echo  decimal($row["saldo"],2); ?></td>
                    <?php } ?>
        </tbody>
</div>