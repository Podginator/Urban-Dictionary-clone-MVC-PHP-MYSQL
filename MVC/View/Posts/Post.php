<!--Tried to make this as abstract as possible, but unfortunatley it does lead to some weird syntax with the delete.-->
<div class ="box post">
    <div class="boxcontainer">
        <h2> <a href="<?php echo URL."Posts/".$post->id;?>"><?php echo htmlentities($post->title) ?> </a></h2>
        <p> <?php echo htmlentities($post->content)?></p>
        <div class="created">By <?php echo "<a href='".URL."user?user=".$post->user->username."'/>"; ?>  <?php echo $post->user->username; ?> </a> on <?php echo $post->date; ?> in category: <?php echo $post->category ?></div>

        <!-- This is the part where I decide whether a user can delete a post -->
        <?php if(UserModel::CanModifyPost($post, $this->database) && isset($post->id)){ ?>
            <div class="responses"> <a href="<?php echo isset($post->replyid) ? URL."Posts/Delete/Reply/".$post->replyid : URL."Posts/Delete/Entry/".$post->id; ?>">Delete</a> </div>
        <?php } ?>

        <!-- Reply Counts -->
        <div class="responses"><a href="<?php echo URL."Posts/Add?topic=".$post->title?>"> Reply </a></div>
        <?php if(isset( $post->countReplies)){ ?>
            <div class="responses">Responses: (<?php echo $post->countReplies; ?>)</div>
        <?php } ?>
    </div>
</div>