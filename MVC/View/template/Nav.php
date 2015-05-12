<!-- The necessary Nav File to get to each page. -->
<header>
	<div class="container header">
		<div class="logo">
			<a href="<?php echo URL; ?>/"><img src="<?php echo URL; ?>/img/logo.png" /></a>
		</div>

		<div class="search">
			<form class="searchForm" action="<?php echo URL; ?>/search" accept-charset="UTF-8" method="post">
					<input autocapitalize="off" autocomplete="off" autocorrect="off" class="autocomplete form-control" id="term" name="term" placeholder="Type any word here..." spellcheck="false" tabindex="1" type="text">
					<button class="searchButton" type="submit">Search</button>
			</form>
		</div>

		<div class="buttons">
			<div class="btctner">
				<a href="<?php echo URL; ?>Posts/Add"><div class="circle button add"> </div></a>
				<a href="<?php echo URL; ?>Posts/GetRandom"><div class="circle button shuffle"> </div></a>
				<a href="<?php echo URL; ?>User"><div class="circle button user"> </div></a>
			</div>
		</div>
	</div>
</header>
<!-- This is ugly, it's all on one line because of the way the css property works. Whitespace = gaps. It's very annoying -->
<nav>
    <a href="<?php echo URL; ?>Home">Home</a><a href="<?php echo URL; ?>Posts">Posts</a><a href="<?php echo URL; ?>Posts/Add">Add Post</a><a href="<?php echo URL; ?>User">User Page</a><?php if(UserModel::ValidateUser($this->database) && $_SESSION["admin"]){?><a href="<?php echo URL; ?>Admin">Admin Page</a><?php } ?>
</nav>