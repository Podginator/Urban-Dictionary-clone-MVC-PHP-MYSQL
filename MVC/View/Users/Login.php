<div class="container">
	<div class = "register form box">
    	<div class="formdiv">
    		

            <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]){ ?>
                <h2>Login to whatever.</h2>
    	        <form action="<?php echo URL; ?>Login/LogOn?redir=<?php echo $redir?>" method="post">
    	            <br/>
        	            <label>Username</label>
        	            <input type="text" name="username" placeholder="Username">
        	            <br/>
        	            <label>Password</label>
        	            <input type="password" name="password" placeholder="Password">
        	            <br/><br/>
    	            <input type="submit" value="Submit"/>
    	        </form>
            <?php }else{ ?>
                <h2> Already Logged In. <a href="<?php echo URL; ?>Login/LogOut">Log Out </a></h2>
            <?php } ?>

        </div>
	</div>

    <div class ="box">
        <p>Don't have an account? <a href="<?php echo URL; ?>/Register">Register</a> here! </p>
    </div>

</div>