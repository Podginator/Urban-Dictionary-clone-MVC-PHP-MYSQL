<div class="container">   
    <?php  if(isset($exception)){ ?>
    	<h2>
    		An Exception: <?php echo $exception->getMessage(); ?> was triggered. 
    	</h2>
    <?php }else{?>
    	<h2>An Error was encountered. Don't panic. Make sure you have your towel.</h2>
    <?php } ?>

</div>