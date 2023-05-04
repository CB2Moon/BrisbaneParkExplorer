<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All <?php echo $is_activity ? 'Activities' : 'Parks';?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery-3.6.1.min.js"></script>
</head>

<body>
<p style="position: fixed; width: 100%; bottom: 0; left: 0; background-color: white; font-size: 0.7rem; border: 1px solid grey; margin: 0; z-index: 10000;">
    <b>Plugins & APIs used in this page: </b>
    Flickr: <i>SmugMug(2004)Flickr.https://www.flickr.com/services/api/</i> <b>|</b> 
    jQuery: <i>jQuery(2006)jQuery(Version 3.6.1)[Source code] https://github.com/jquery</i> <b>|</b> 
    ToroPHP: <i>Anand, K.(2015)ToroPHP(Version 2.0.1)[Source code] https://github.com/anandkunal/ToroPHP</i>
</p>
    <?php include "navigator.php" ?>
    <main>
        <div class="colored-header <?php if($is_activity) echo 'activity-header'; ?>">
            <h1>All <?php echo $is_activity ? 'Activities' : 'Parks';?> in Brisbane</h1>
        </div>
		<div class="share-to-friends">
			<h4>Share To Friends</h4>
			<div class="share-icon">
				<img src="../images/twitter2.png"/><img src="../images/facebook2.png"/><img src="../images/ins2.png"/>
			</div>
		</div>

        <section class="body">
            <article id="hot-parks" class="grid-article">
                <header class="section-header">
                    <h2>🔥The Hottest <?php echo $is_activity ? 'Activities' : 'Parks';?>🔥</h2>
                    <p class="park-brief-intro"><i>This is the hottest <?php echo $is_activity ? 'activities' : 'parks';?> in Brisbane!</i></p>
                </header>

                <div class="three-col-grid">
                    <?php 
                    if ($is_activity) {
                        $results = getRecentActivitiesOf(3, 'all');
                        foreach ($results as $result) {
                            $id = $result['id'];
                            $name = $result['name'];
                            $address = $result['address'];
                            $type = $result['event_type1'];
                            $meet = $result['meet_point'];
                            $image = $result['image_url'];
                    ?>
                            <div>
                                <div class="card">
                                    <div class="card-img-block">
                                        <img src="<?php echo $image;?>" alt="<?php echo $name;?>">
                                    </div>
                                
                                    <h3><?php echo $name; ?></h3>
                                    <p><?php echo $name; ?> is a <?php echo $type; ?> activity located in <?php echo $address; ?>. 
                                    People who wants to attend <?php echo $name; ?>, please come meet us at <?php echo $meet; ?> </p>
                                    <a href="/activity/<?php echo $id; ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                                </div>
                            </div>
                        <?php } ?> 
                    <?php } else {
                        $results = getTopParksOf(3, 'all');
                        foreach ($results as $result) {
                            $park_id = $result['park_id'];
                            $park_name = $result['park_name'];
                            $address = $result['address'];
                            $area = $result['area'];
                    ?> 
                        <div>
                            <div class="card">
                                <div class="card-img-block">
                                    <img src="<?php echo searchImg($park_name);?>" alt="<?php echo $park_name;?>">
                                </div>
                            
                                <h3><?php echo $park_name; ?></h3>
                                <p><?php echo $park_name; ?>, located in <?php echo $area; ?> area,
                                 is a very beautiful park. People living near <?php echo $address; ?> love going there. 
                                 This park have many types of facility, such as <?php echo resultToStr(getFacilitiesOfPark($park_id, 3)); ?> 
                                 In addition, many interesting activities are held here, for instance <?php echo resultToStr(getActivitiesOfPark($park_id, 3)); ?></p>
                                <a href="/park/<?php echo $park_id; ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </article>

            <?php if ($is_activity) {
                $distinct_activity_types = getDistinctActivityType();
                foreach ($distinct_activity_types as $distinct_activity_type) {
                    $distinct_activity_type = $distinct_activity_type['activity_type'];
                    $activities = getActivitiesOfType($distinct_activity_type);                
            ?>
                    <article class="grid-article">
                        <header class="section-header">
                            <h2>Activities of Type: <?php echo $distinct_activity_type == 'NULL' ? 'Random' : $distinct_activity_type; ?></h2>
                            <p class="park-brief-intro"><i>Browse for more activity descriptions.</i></p>
                        </header>
                        <div class="three-col-grid">
                        <?php
                            foreach ($activities as $ac) {
                                $id = $ac['id'];
                                $name = $ac['name'];
                                $address = $ac['address'];;
                                $type = $ac['activity_type'];
                                $meet = $ac['meet_point'];;
                                $image = $ac['image_url'];
                        ?>
                                <div>
                                    <div class="card">
                                        <div class="card-img-block">
                                            <img src="<?php echo $image;?>" alt="<?php echo $name;?>">
                                        </div>
                                    
                                        <h3><?php echo $name; ?></h3>
                                        <p><?php echo $name; ?> is a <?php echo $type; ?> activity located in <?php echo $address; ?>. 
                                        People who wants to attend <?php echo $name; ?>, please come meet us at <?php echo $meet; ?> </p>
                                        <a href="/activity/<?php echo $id; ?>" class="card-learn-more decoless">Learn&nbsp;More</a>
                                    </div>
                                </div>
                        <?php } ?>
                        </div>
                    </article>
                <?php } ?>
            <?php } else { 
                $distinct_park_areas = getDistinctParkArea();
            ?>
            <script>const isPark = true; var distinctParkAreas = <?php echo json_encode($distinct_park_areas);?>;</script>
            <?php } ?>

        </section>
    </main>
    <?php include "footer.php" ?>
    <script>
        function loadParks(areas, toLoad) {
            $.ajax({
                url: './views/allParks-load.php',
                type: 'post',
                data: {'areas': areas.slice(toLoad, toLoad+2)},
                cache: false,
                async: false,
                success: function (html) { 
                    $('section.body').append(html);
                    if(toLoad != 0) $('#loadmorebtn').remove();
                    $('section.body').append('<a id="loadmorebtn" style="margin: 5rem auto; display: block; width: 12rem; cursor: pointer;" class="view-more decoless">Load&nbsp;More&nbsp;Parks (3s)</a>');
                }
            });
        }
        if (isPark) {
            let toLoad = 0;
            var areas = [];
            distinctParkAreas.forEach(distinctParkArea => areas.push(distinctParkArea['area']));
            loadParks(areas, toLoad);
            $(document).on('click', '#loadmorebtn', (e) => {
                toLoad += 2;
                e.preventDefault();
                $('#loadmorebtn').text("Please wait...");
                loadParks(areas, toLoad);
            });
        }
    </script>
</body>
</html>