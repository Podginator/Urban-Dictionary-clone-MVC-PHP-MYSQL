<div class="container">
	<div class="box organize">
		<h2> Categories: </h2>
		<a href="<?php echo URL."Posts" ?>"> All </a>
		<?php foreach($categories as $category){ ?>
			<a href="<?php echo URL."Posts?category=".$category["category"] ?>"><?php echo htmlentities($category["category"]) ?></a>
		<?php } ?>
	</div>
</div>