

<div class ="footer">
    <div style="float:left; color:white; font-size:10px; margin-left:15px;">I didn't know what to put here, pretend it's copyright info.</div>
    <?php if(UserModel::ValidateUser($this->database)){ ?>
        <div style="float:right; margin-right:15px"><a href="<?php echo URL . '/Login/Logout' ?>">LogOut</a></div>
    <?php } ?>

</div>
<!-- Add Jquery and JS at the bottom to speed up page loading -->
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo URL; ?>js/application.js"></script>
</body>
</html>
