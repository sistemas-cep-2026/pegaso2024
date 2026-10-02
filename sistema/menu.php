<li class="menu-title"><span>Procesos</span></li>
<?php
$data_proceso = $bo_mod_perfil->menu(s_perfil(), $codigo, 'P');
foreach ($data_proceso as $row) {
    if ($id == $row["cc_modulo"]) {
        $active = " active";
    } ?>
    <li class="nav-item">
        <!--active-->
        <a class="<?php echo $active ?> nav-link menu-link" href="?id=<?php echo s_crypt($row["cc_modulo"], 'in') ?>">
            <!--<i data-feather="<?php //echo $row["mod_ico"] 
        ?>"></i>-->
        <i class='fas <?php echo $row["mod_ico"] ?>'></i>
        <span><?php echo $row["mod_nombre"] ?></span>
    </a>
</li>
<?php $active = "";
} ?>
<li class="menu-title"><span>Reportes</span></li>
<?php
$data_reporte = $bo_mod_perfil->menu(s_perfil(), $codigo, 'R');
foreach ($data_reporte as $rep) {
    if ($id == $rep["cc_modulo"]) {
        $active = " active";
    }
    ?>
    <li class="nav-item">
        <a class="<?php echo $active ?> nav-link menu-link" href="?id=<?php echo s_crypt($rep["cc_modulo"], 'in') ?>">
            <i class='fas <?php echo $rep["mod_ico"] ?>'></i>
            <span><?php echo $rep["mod_nombre"] ?></span>
        </a>
    </li>
    <?php $active = "";
}
