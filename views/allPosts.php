<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>All Posts</title>
</head>

<body class="scroll-bar">
    <?php include "navigator.php" ?>
        <p style="position: fixed; width: 100%; bottom: 0; left: 0; background-color: white; font-size: 0.7rem; border: 1px solid grey; margin: 0; z-index: 10000;">
            <b>Plugins & APIs used in this page: </b>
            Flickr: <i>SmugMug(2004)Flickr.https://www.flickr.com/services/api/</i> <b>|</b> 
            jQuery: <i>jQuery(2006)jQuery(Version 3.6.1)[Source code] https://github.com/jquery</i> <b>|</b> 
            dicebear: <i>dicebear(2020)dicebear(Version 4.10.0)[Source code] https://github.com/dicebear/dicebear/actions</i> <b>|</b> 
            drag-and-drop-preview-images: <i>Kumar, A.(2022)drag-and-drop-preview-images[Source code] https://github.com/wtricks/drag-and-drop-preview-images</i> <b>|</b> 
            ToroPHP: <i>Anand, K.(2015)ToroPHP(Version 2.0.1)[Source code] https://github.com/anandkunal/ToroPHP</i>
        </p>
    <button id="newPostBtn">📝</button>
    <section id="post-detail">
    </section>
    <section id="newPost">
        <button id="cancelPostBtn">✖️</button>
        <article>
            <div class="post-detail-img post-upload">
                <div id="drag-area">
                    <span class="visible">
                        Drag & drop image here or
                        <span id="browseBtn" role="button">Browse</span>
                    </span>
                    <span class="on-drop">Drop images here</span>
                    <input name="file" type="file" class="file" multiple />
                </div>
        
                <div id="preview-img"></div>
            </div>

            <div class="new-post-info">
                <div class="post-info">
                    <p>New Post</p>
                    <input id="sendBtn" type="submit" value="Send">
                </div>

                <div id="post-detail-text" class="scroll-bar">
                    <h2 class="post-title">
                        <input type="text" placeholder="Title">
                    </h2>
                    <input id="sender" type="text" placeholder="your name">
                    <hr id="new-post-hr">
                    <textarea id="new-post-text" rows="20" cols="55" placeholder="paragraph"></textarea>
                </div>
                
                <div class="to-activity scroll-bar">
                    <div id="activity-checkbox">
                        <label for="post-as-activity">Also Post as Activity</label>
                        <input type="checkbox" id="post-as-activity">
                    </div>
                </div>
            </div>
        </article>

    </section>

    <main>
        <header class="colored-header">
            <h1>All Posts</h1>
        </header>
        <section class="post-grid">
            <div id="all-post-grid" class="two-col-grid-container">
                <?php 
                    $posts = getPosts();
                    foreach ($posts as $post ) {
                        $sender = $post['sender'];
                        $post_time = $post['post_time'];
                        $post_img = $post['post_img'];
                        $title = $post['title'];
                        $words = $post['words'];
                        $likes = $post['likes'];
                        $post_id = $post['post_id'];
                        $is_activity = $post['is_activity'];
                        $comment_count = postCommentCount($post_id);
                ?>
                <div class="post <?php echo $is_activity ? 'activity-post' : '';?>">
                    <div class="post-info">
                        <div  class="post-user-avatar">
                            <img src="https://avatars.dicebear.com/api/avataaars/<?php echo str_replace(' ','',$sender);?>.svg?b=%23e0ffeb&size=35" alt="<?php echo $sender;?>">
                        </div>
                        <span class="post-user-name"><?php echo $sender;?></span>
                        <span class="post-time"><?php echo $post_time;?></span>
                    </div>
                    <h2 class="post-title"><?php echo $title;?><?php echo $is_activity ? '<strong style="color: rgba(213, 1, 0, 0.8); font-weight: bold;"> - Activity🔥</strong>' : '';?></h2>
                    <?php if($post_img) {?>
                    <div class="post-img-proportion"><img src="<?php echo $post_img;?>" alt="<?php echo $title;?>"></div>
                    <?php }?>
                    <p class="post-description"><?php echo $words;?></p>
                    <div class="comment-like">
                        <span data-postid="<?php echo $post_id;?>" class="post-view-comment decoless comment-icon"> <?php echo $comment_count;?> Comment<?php if($comment_count != 1) {echo 's';}?></span>
                        <span class="post-like decoless nolike-icon"> <?php echo $likes;?> Like<?php if($likes != 1) {echo 's';}?></span>                
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
    </main>

    <?php include "footer.php" ?>
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/post.js"></script>
    <script src="../js/newPost.js"></script>
</body>

</html>