<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php if($is_activity) {echo getActivityId($activity_id)[0]['name'];} else {echo getPark($park_id)[0]['park_name'];} ?></title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	
	</head>
	<body>
        <?php include "navigator.php" ?>
		<header class="picture-box"> 
			<h1><?php if($is_activity) {echo getActivityId($activity_id)[0]['name'];} else {echo getPark($park_id)[0]['park_name'];} ?></h1>
            <?php if($is_activity){
                ?>
                <img src="<?php echo $image_url;?>" alt="<?php echo $activity_name;?>">
            <?php } else { 
                ?>
                <img src="<?php echo searchImg($park_name,"large");?>" alt="<?php echo $park_name;?>"> 
            <?php } ?>   
		</header>
        <?php 
            if ($is_activity) {
            ?>
                <div class="detail-introduce">
			        <p> <?php echo $description;?></p>
		        </div>
            <?php } else {
                ?> 
                <div class="detail-introduce">
			        <P> This ia <?php echo $park_name;?> ,located in <?php echo $park_address;?> ,which is in <?php echo $area;?>.
                    <?php echo $park_name;?> has plenty of facilities. It can provide huge of activities for the Brisbane people.
                    </P>
		        </div>
        <?php } ?>
		<div class="share-to-friends">
			<h4>Share To Friends</h4>
			<div class="share-icon">
            <img src="../images/twitter2.png"/><img src="../images/facebook2.png"/><img src="../images/ins2.png"/>
			</div>
		</div>
		<main class="park-details">
			<article class="more-img">
            <?php 
                    if ($is_activity) {
                    ?>
                        <div class="img-word">
                            <p>Beautiful<br>Sence Of<br><?php echo $activity_name;?></p>
                        </div>
                        <div class="more-pictures">
                        <img src="<?php echo searchImg($activity_name,"medium");?>" alt="<?php echo $activity_name;?>">
                        </div>
                    <?php } else {
                    ?> 
                        <div class="img-word">
                            <p>Beautiful<br>Sence Of<br><?php echo $park_name;?></p>
                        </div>
                        <div class="more-pictures">
                            <img src="<?php echo searchImg($park_name,"medium");?>" alt="<?php echo $park_name;?>">
                        </div>
            <?php } ?>
			</article>
			<article class="park-facility">
                <?php
                    if ($is_activity){
                ?>
                <?php } else {
                    ?>
                    <?php
                        $results = getFacilitiesOfPark($park_id, 1);
                        foreach ($results as $result) {
                            $facility_name = $result['item_type'];
                    ?>
                        <div class="facility-image">
                            <img src="<?php echo searchImg($facility_name);?>" alt="<?php echo $facility_name;?>">
                        </div>
                        <div class="facility-image">
                            <img src="<?php echo searchImg($facility_name);?>" alt="<?php echo $facility_name;?>">
                        </div>
                        <div class="facility-word">
                            <h2>Complete <br>Public <br>Facilities</h2>
                            <p><?php echo $park_name; ?> has <?php echo $facility_name; ?>, which are on the far left of the park. 
                                At the same time, the metal mesh fence around the basketball court adopts the removable fence of JIAOSHI brand. 
                                The product adopts the free combination structure of sheet packaging, 
                                the design of the built-in fence pre tightening device, the protective layer used for the frame pipe, 
                                and the high-temperature spraying process, all of which are rust resistant, reliable and durable. </p>
                            <!--<a href="#" class="card-learn-more decoless">Learn&nbsp;More</a>-->
                        </div>
                    <?php } ?>
                <?php } ?>    
			</article>

			<article class="park-activity">
            <?php
                    if ($is_activity){
                    ?>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($activity_type);?>" alt="<?php echo $activity_type;?>">
                        </div>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($activity_type);?>" alt="<?php echo $activity_type;?>">
                        </div>
                        <div class="activity-word">
                        <h2>Activity<br>Type:<br><?php echo $activity_type;?></h2>
                        <p>you should first introduce the juniors to the elders, the lower status to the high-status people, and the men to the ladies.
                            Introducers should use honorifics when making introductions. For example, "Miss Wang, allow me to introduce you..." 
                            or more casually, "Mr. Zhang, let me introduce you, this is.....".
                            out his palm and face the partyWhlm and face the partyWhen a person is introduced, 
                            he should stretch out his palm and face the party.</p>
                        <!--<a href="/activity/<?php echo getActivityIdFromNameAndPark($park_id, $activity_name); ?>" class="card-learn-more decoless">Learn&nbsp;More</a>-->
                    </div>
                <?php } else {
                    ?>
                    <?php
                        $results = getActivitiesOfPark($park_id, 1);
                        foreach ($results as $result) {
                            $activity_name = $result['name'];
                    ?>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($activity_name);?>" alt="<?php echo $activity_name;?>">
                        </div>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($activity_name);?>" alt="<?php echo $activity_name;?>">
                        </div>
                        <div class="activity-word">
                        <h2>Interesting<br>Activities:<br><?php echo $activity_name;?></h2>
                        <p>you should first introduce the juniors to the elders, the lower status to the high-status people, and the men to the ladies.
                            Introducers should use honorifics when making introductions. For example, "Miss Wang, allow me to introduce you..." 
                            or more casually, "Mr. Zhang, let me introduce you, this is.....".
                            out his palm and face the partyWhlm and face the partyWhen a person is introduced, 
                            he should stretch out his palm and face the party.</p>
                        <a href="/activity/<?php echo getActivityIdFromNameAndPark($park_id, $activity_name); ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                    </div>
                    <?php } ?>
                <?php } ?> 
			</article>

			<article class="park-activity">
            <?php
                    if ($is_activity){
                    ?>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($event_type1);?>" alt="<?php echo $event_type1;?>">
                        </div>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($event_type1);?>" alt="<?php echo $event_type1;?>">
                        </div>
                        <div class="activity-word">
                        <h2>Activity<br>Type:<br><?php echo $event_type1;?></h2>
                        <p>you should first introduce the juniors to the elders, the lower status to the high-status people, and the men to the ladies.
                            Introducers should use honorifics when making introductions. For example, "Miss Wang, allow me to introduce you..." 
                            or more casually, "Mr. Zhang, let me introduce you, this is.....".
                            out his palm and face the partyWhlm and face the partyWhen a person is introduced, 
                            he should stretch out his palm and face the party.</p>
                        <!--<a href="/activity/<?php echo getActivityIdFromNameAndPark($park_id, $activity_name); ?>" class="card-learn-more decoless">Learn&nbsp;More</a>-->
                    </div>
                <?php } else {
                    ?>
                    <?php
                        $results = getActivitiesOfPark($park_id, 1);
                        foreach ($results as $result) {
                            $activity_name = $result['name'];
                    ?>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($activity_name);?>" alt="<?php echo $activity_name;?>">
                        </div>
                        <div class="activity-image">
                            <img src="<?php echo searchImg($activity_name);?>" alt="<?php echo $activity_name;?>">
                        </div>
                        <div class="activity-word">
                        <h2>Interesting<br>Activities:<br><?php echo $activity_name;?></h2>
                        <p>you should first introduce the juniors to the elders, the lower status to the high-status people, and the men to the ladies.
                            Introducers should use honorifics when making introductions. For example, "Miss Wang, allow me to introduce you..." 
                            or more casually, "Mr. Zhang, let me introduce you, this is.....".
                            out his palm and face the partyWhlm and face the partyWhen a person is introduced, 
                            he should stretch out his palm and face the party.</p>
                        <a href="/activity/<?php echo getActivityIdFromNameAndPark($park_id, $activity_name); ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                    </div>
                    <?php } ?>
                <?php } ?> 
			</article>

		</main>
        <section id="post-detail">
        </section>
        <article class="park-details-post">
            <header class="section-header">
                <h2>Posts</h2>
                <p class="park-brief-intro"><i>The hottest discussion is here</i></p>
            </header>
            
            <section class="post-grid">
                <div id="all-post-grid" class="two-col-grid-container">
                    <?php 
                        $posts = getPosts(5);
                        foreach ($posts as $post ) {
                            $sender = $post['sender'];
                            $post_time = $post['post_time'];
                            $post_img = $post['post_img'];
                            $title = $post['title'];
                            $words = $post['words'];
                            $likes = $post['likes'];
                            $post_id = $post['post_id'];
                            $is_post_activity = $post['is_activity'];
                            $comment_count = postCommentCount($post_id);
                    ?>
                    <div class="post <?php echo $is_post_activity ? 'activity-post' : '';?>">
                        <div class="post-info">
                            <div  class="post-user-avatar">
                                <img src="https://avatars.dicebear.com/api/avataaars/<?php echo str_replace(' ','',$sender);?>.svg?b=%23e0ffeb&size=35" alt="<?php echo $sender;?>">
                            </div>
                            <span class="post-user-name"><?php echo $sender;?></span>
                            <span class="post-time"><?php echo $post_time;?></span>
                        </div>
                        <h2 class="post-title"><?php echo $title;?><?php echo $is_post_activity ? '<strong style="color: rgba(213, 1, 0, 0.8); font-weight: bold;"> - Activity🔥</strong>' : '';?></h2>
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
            <a href="/allPosts" class="view-more decoless">View&nbsp;All&nbsp;Posts</a>
        </article>
        
        
                <?php  if (!$is_activity){
                    ?>
                    <article id="hot-parks" class="grid-article">
                        <header class="section-header">
                        <h2>Nearby parks</h2>
                        <p class="park-brief-intro"><i>Intorduction of the parks around <?php echo $park_name;?></i></p>
                        </header>
                    <div class="three-col-grid">
                    <?php
                        $results = getTopParksOf(3, $area);
                        foreach ($results as $pk) {
                            $id = $pk['park_id'];
                            $name = $pk['park_name'];
                            $address = $pk['address'];
                            $area = $pk['area'];
                        ?>
                            <div>
                                <div class="card">
                                    <div class="card-img-block">
                                        <img src="<?php echo searchImg($name);?>" alt="<?php echo $name;?>">
                                    </div>
                                
                                    <h3><?php echo $name; ?></h3>
                                    <p><?php echo $name; ?>, located in <?php echo $area; ?> area,
                                    is a very beautiful park. People living near <?php echo $address; ?> love going there. 
                                    This park have ”item-type” and” Recent activities name”</p>
                                    <a href="/park/<?php echo $id; ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                                </div>
                            </div>
                        <?php } ?>  
                    </div>
                    </article>    
                <?php } ?>    
	

    <?php include "footer.php" ?>
	</body>
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/post.js"></script>
    <script src="../js/newPost.js"></script>
</html>