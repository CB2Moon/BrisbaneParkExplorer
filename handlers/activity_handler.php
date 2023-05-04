<?php

class ActivityHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    function get($activity_id) {
        $is_activity = true;
        visitactivityAdd($activity_id);
        $results = getActivityId($activity_id);
        foreach ($results as $result) {
            $activity_name = $result['name'];
            $activity_address = $result['address'];
            $meet_point = $result['meet_point'];
            $event_type1 = $result['event_type1'];
            $activity_type = $result['activity_type'];
            $age_range = $result['age_range'];
            $start_time = $result['start_time'];
            $end_time = $result['end_time'];
            $description = $result['description'];
            $requirement = $result['requirement'];
            $image_url = $result['image_url'];
        }
        include "views/activity-park-detail.php";
    }
}

?>