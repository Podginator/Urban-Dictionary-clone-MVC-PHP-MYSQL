<div class="container">
	<div class = "box user">
		<div class="boxcontainer">
			<h2> User Information: </h2>
	    	<label> User: </label><p> <?php echo $user->username; ?> </p>
	    	<label> Last Login: </label> <p><?php echo $user->last_login ? $user->last_login : "Never"; ?></p>
	    	<label> Bio: </label> <p class="Biograpy"><?php echo htmlentities($user->bio); ?>
				<?php if(isset($_SESSION["user"]) && $user->username === $_SESSION["user"] && UserModel::ValidateUser($this->database)){ ?>
					<a href="#" class="editForm">Edit</a>
				<?php } ?>
			</p>
			<?php if(isset($_SESSION["user"]) && $user->username == $_SESSION["user"] && UserModeL::ValidateUser($this->database)){ ?>
		    	<form class="BioForm" action="<?php echo URL; ?>User/AddBio" method="post" style="display:none;">
					<textarea rows="4" cols="50" name="Biograpy"></textarea>
		            <input  type="submit" value="Submit"/>
		        </form>
		    <?php }?>
	    </div>
	</div>



	<?php
		$entryCount = count($entries);
		if($entryCount > 0){
			$output = "<div class = 'box entries expandable'>";
			$output .= "\n\t<h2>User Entries ({$entryCount}): </h2>";
			$output .= $entryCount > 3 ? "Placeholder plus button" : "";
			$output .= "</div>";
			echo $output;
		}

		echo $entryCount > 3 ? "<div class='hidden entries'>" : "";

		foreach($entries as $post){
			require MVC."View/Posts/Post.php";
		} ?>

		<?php
		echo $entryCount > 3 ? "</div><br/>" : "<br/>";

		$replyCount = count($replies);
		$output = "";
		if($replyCount > 0){
			$output = "<div class = 'box replies expandable'>";
			$output .= "\n\t<h2>User Replies ({$replyCount}): </h2>";
			$output .= $replyCount > 3 ? "Placeholder plus button" : "";
			$output .= "</div>";
			echo $output;
		}

		echo $replyCount > 3 ? "<div class='hidden replies'>" : "";

		foreach($replies as $post){
			require MVC."View/Posts/Post.php";
		}
		echo $replyCount > 3 ? "</div>" : "";
	?>



</div>