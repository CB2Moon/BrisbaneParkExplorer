<?php
$to_search = strtoupper($to_search);
$id = 1;
if($to_search == 'NULL') {
    $parks = getTopParksOf(5, 'all');
    $activities = getRecentActivitiesOf(5, 'all');
    $facilities = getFacilitiesOf(5, 'all');
} else {
    $parks = searchPark($to_search);
    $activities = searchActivity($to_search);
    $facilities = searchFacility($to_search);
}
?>
<li>
    <p class="suggestion-category">Default</p>
    <p class="suggestion-options">
        <span data-tagtype="all" id="span0" class="suggestion-option all-type type-deco">Show All Parks, Activities, and Facilities</span>
    </p>
</li>
<li>
    <p class="suggestion-category">HOT PARKS</p>
    <p class="suggestion-options">
        <?php foreach($parks as $park) { ?>
        <span data-tagtype="park" data-name="<?php echo $park['park_id'];?>" id="<?php echo 'span'.$id?>" class="suggestion-option park-type type-deco">
            <?php echo $park['park_name'];?>
        </span>
        <?php $id++;}?>
    </p>
</li>
<li>
    <p class="suggestion-category">HOT ACTIVITIES</p>
    <p class="suggestion-options">
        <?php foreach($activities as $activity) { ?>
        <span data-tagtype="activity" data-name="<?php echo $activity['name'];?>" id="<?php echo 'span'.$id?>" class="suggestion-option activity-type type-deco">
            <?php echo $activity['name'];?>
        </span>
        <?php $id++;}?>
    </p>
</li>
<li>
    <p class="suggestion-category">HOT FACILITIES</p>
    <p class="suggestion-options">
        <?php foreach($facilities as $facility) { ?>
        <span data-tagtype="facility" data-name="<?php echo $facility['item_type'];?>" id="<?php echo 'span'.$id?>" class="suggestion-option facility-type type-deco">
            <?php echo $facility['item_type'];?>
        </span>
        <?php $id++;}?>
    </p>
</li>