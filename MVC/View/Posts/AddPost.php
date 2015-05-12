<div class="container">
	<div class = "addpost box">
    	<div class="formdiv">
	    	Add a Post:
        </div>
	</div>

	<div class = "addpost form box">
		<form id="addPostForm" action="<?php echo URL; ?>Posts/AddPost" method="post">
	        <br/>
	            <label>Post Title:</label>
	            <input type="text" id="postTitle" name="Title" placeholder="Post Title" value="<?php echo $postTitle ?>">
	            <br/>

				<?php if ($postTitle == ""){ ?>
					<label>Post Category:</label>
					<select name="category">
						<?php
						foreach( $categories as $cat)
							echo "<option value=\"{$cat["category"]}\">{$cat["category"]}</option>";
						?>
					</select>
					<br/>
				<?php } ?>

	            <label>Post Content:</label>
	            <textarea name="Content" placeholder="Post content..."></textarea>
	        <input type="submit" value="Submit"/>
	    </form>
    </div>
</div>