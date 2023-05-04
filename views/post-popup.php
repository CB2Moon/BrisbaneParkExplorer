<?php 
$post = getPost($post_id)[0];
$sender = $post['sender'];
$post_time = $post['post_time'];
$post_img = $post['post_img'];
$title = $post['title'];
$words = $post['words'];
$likes = $post['likes'];
$is_activity = $post['is_activity'];
$comments = getCommentsOf($post_id);
?>
<!-- Avatar API reference
  dicebear(2020)dicebear(Version 4.10.0)[Source code] https://github.com/dicebear/dicebear/actions
-->
<button id="closeBtn">✖️</button>
<article>
    <div class="post-detail-img">
        <?php if($post_img) {?>
            <img src="<?php echo $post_img;?>" alt="<?php echo $title;?>">
        <?php } else {?>
            <img src="<?php echo searchImg($title, 'medium');?>" alt="<?php echo $title;?>">
        <?php }?>
    </div>
    <div class="post-detail-info">
        <div class="post-info">
            <div class="post-user-avatar">
                <img src="https://avatars.dicebear.com/api/avataaars/<?php echo str_replace(' ','',$sender);?>.svg?b=%23e0ffeb&size=35" alt="<?php echo $sender;?>">
            </div>
            <span class="post-user-name"><?php echo $sender;?></span>
            <span class="post-time"><?php echo $post_time;?></span>
        </div>

        <div id="post-detail-text" class="scroll-bar">
            <h2 class="post-title">
                <?php echo $title;?>
                <span class="post-like decoless nolike-icon"> <?php echo $likes;?> Like<?php if($likes != 1) {echo 's';}?></span>
            </h2>
            <!-- PHP: if have image -->
            <p class="post-description"><?php echo $words;?></p>
            <hr>

            <!-- Comments down here -->
            <?php
                foreach ($comments as $comment) {
                    $comment_sender = $comment['sender'];
                    $comment_time = $comment['comment_time'];
                    $comment_words = $comment['words'];
            ?>
            <div class="comment-in-post-detail">
                <div class="post-user-avatar">
                    <img src="https://avatars.dicebear.com/api/avataaars/<?php echo str_replace(' ','',$comment_sender);?>.svg?b=%23e0ffeb&size=35" alt="<?php echo $comment_sender;?>">
                </div>
                <div class="comment-text">
                    <span class="post-user-name"><?php echo $comment_sender;?></span>
                    <span class="post-time"><?php echo $comment_time;?></span>
                    <p class="comment"><?php echo $comment_words;?></p>
                </div>
            </div>
            <?php }?>
        </div>

        <div class="reply">
            <textarea data-postid="<?php echo $post_id;?>" name="reply" id="reply" rows="20" cols="50" placeholder="Reply to @<?php echo $sender;?>"></textarea>
            <input name="replyBtn" id="replyBtn" type="submit" value="Reply">
        </div>
    </div>
</article>