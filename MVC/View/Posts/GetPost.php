<div class="reply container">
        <?php require MVC.'View/Posts/Post.php'; ?>

        <div class="replycontainer">
            <div class="box"><h2> Replies:: </h2></div>
            <?php foreach($replies as $post){ ?>
                <?php require MVC.'View/Posts/Post.php'; ?>
            <?php } ?>
        </div>

        <?php if (UserModel::ValidateUser($this->database)){ ?>
            <div class = "addpost form box">
                <form action="<?php echo URL; ?>Posts/AddPost" method="post">
                    <input type="text" name="Title" placeholder="Post Title" style="display:none;" value="<?php echo $post->title ?>">
                    <br/>
                    <label>Add Reply:</label>
                    <textarea name="Content" placeholder="Post content..."></textarea>
                    <input type="submit" value="Submit"/>
                </form>
            </div>
        <?php }?>


</div>