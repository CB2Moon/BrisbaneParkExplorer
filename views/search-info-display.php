<?php
// API used: Flickr: SmugMug(2004)Flickr.https://www.flickr.com/services/api/
if ($search == 'park') {
    $park = getPark($park_id)[0];
    $park_name = $park['park_name'];
    $address = $park['address'];
    $area = $park['area'];
    $item_types = getFacilitiesOfPark($park_id);
    $activities = getActivitiesOfPark($park_id);
?>
<div class="scroll-bar">
    <h2><?php echo $park_name;?></h2>
    <div class="post-img-proportion"><img class="search-page-img" src="<?php echo searchImg($park_name);?>" alt="<?php echo $park_name;?>"></div>
    <p><b>Location: </b>
        <?php echo $address;?>, <?php echo $area;?>
    </p>
    <p><b>Description: Beautiful park!</b>

    </p>
    <p><b>Facilities: </b>
        <?php foreach ($item_types as $item_type) { ?>
            <span class="type-deco facility-type"><?php echo $item_type['item_type'];?></span>
        <?php } ?>
    </p>
    <p><b>Activities: </b>
        <?php foreach ($activities as $activity) { ?>
            <span class="type-deco activity-type"><?php echo $activity['name'];?></span>
        <?php } ?>
    </p>
</div>
<a href="/park/<?php echo $park_id;?>" class="card-learn-more decoless">Learn&nbsp;More</a>

<?php
} elseif ($search == 'activity') {
    $activity = getActivity($park_id, $activity_name)[0];
    $activity_id = $activity['id'];
    $address = $activity['address'];
    $meet_point = $activity['meet_point'];
    $event_type1 = $activity['event_type1'];
    $event_type2 = $activity['event_type2'];
    $activity_type = $activity['activity_type'];
    $age_range = $activity['age_range'];
    $start_time = $activity['start_time'];
    $end_time = $activity['end_time'];
    $description = $activity['description'];
    $requirement = $activity['requirement'];
    $image_url = $activity['image_url'];
?>
<div class="scroll-bar">
    <h2><?php echo $activity_name;?></h2>
    <div class="post-img-proportion"><img class="search-page-img" src="<?php echo $image_url;?>" alt="<?php echo $activity_name;?>"></div>
    <p><b>Meet Point: </b>
        <?php echo $meet_point. ', ' .$address;?>
    </p>
    <p><b>Activity Type: </b>
        <?php echo $event_type1. ', ' .$event_type2. ', ' .$activity_type;?> for <?php echo '<b>'.$age_range.'</b>';?>
    </p>
    <p><b>Description: </b>
        <?php echo $description;?>
    </p>
    <p><b>Time: </b>
        <?php echo $start_time. ' -- ' .$end_time;?>
    </p>
    <p><b>Requirement: </b>
        <?php echo $requirement;?>
    </p>
</div>
<a href="/activity/<?php echo $activity_id;?>" class="card-learn-more decoless">Learn&nbsp;More</a>

<?php
} elseif ($search == 'facility') {
    $park = getPark($park_id)[0];
    $park_name = $park['park_name'];
    $address = $park['address'];
    $area = $park['area'];
    $moreParks = getFacility($park_id);
?>
<div class="scroll-bar">
    <h2><?php echo $facility_type;?></h2>
    <div class="post-img-proportion"><img class="search-page-img" src="<?php echo searchImg($facility_type);?>" alt="<?php echo $facility_type;?>"></div>
    <p><b>Description: </b>
        This facility is in <?php echo $park_name;?>
    </p>
    <p><b>Location: </b>
        <?php echo $address;?>, <?php echo $area;?>
    </p>
    <p><b>More parks that have : <?php echo $facility_type;?></b>
        <?php foreach($moreParks as $morePark) { ?>
            <span class="park-type type-deco"><?php echo $morePark['park_name'];?></span>
        <?php } ?>
    </p>

</div>
<a href="/facility/<?php echo $park_id_facility_type;?>" class="card-learn-more decoless">Learn&nbsp;More</a>
<?php } ?>