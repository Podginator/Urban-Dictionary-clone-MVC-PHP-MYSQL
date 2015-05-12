<div class="container">
	<div class = "register form box">
    	<div class="formdiv">
    		<h2>Register to Civic Glossary:</h2>

			<h2 class="Err"></h2>


    		<?php if($error){ ?>
    			<h2><?php echo $error ?></h2>
			<?php } ?>

	        <form id="regform" action="<?php echo URL; ?>Register/AddUser" method="post"">
	            
	            <br/>
    	            <label>Username</label>
    	            <input id="uname" type="text" name="username" placeholder="Username">
    	            <br/>
    	            <label>Email</label>
    	            <input id="email" type="text" name="email" placeholder="Email">
    	            <br/>
    	            <label>Password</label>
    	            <input id="password" type="password" name="password" placeholder="Password">
    	            <br/>
    	            <label>Confirm Password</label>
    	            <input id="Confirm" type="password" name="confirm"  placeholder="Password">
    	            <br/><br/>
	            <input type="submit" value="Submit"/>
	        </form>
    </div>
	</div>
</div>