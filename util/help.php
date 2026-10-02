/**colorear menu en el js*//
$(".list-group-item").click(function() {
	var listItems = $(".list-group-item");
	for (let i = 0; i < listItems.length; i++) {
		listItems[i].classList.remove("active");
	}
	this.classList.add("active");
});

<div class="list-group">
		<a href="javascript:fn_controleje('<?php echo $row["cc_ejeestrategico"] ?>');" class="list-group-item list-group-item-action">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1">Eje estratégico <?php echo "0".$i ?></h5>
				<small class="text-secondary"><?php echo $row["fecha"] ?></small>
			</div>
			<p class="card-text">
				<?php echo $row["nombre"] ?>
			</p>
			<small class="text-secondary">Gestión <?php echo $row["gestion"] ?></small>
		</a>
	</div>

<!--==============icono---->
<i class="ficon" data-feather="delete"></i>
https://fontawesome.com/v5/icons/calendar-minus?s=solid

