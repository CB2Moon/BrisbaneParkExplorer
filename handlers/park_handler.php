<?php

class ParkHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    // $park_id is passed in by the :alpha from the URL -- /park/:alpha
    function get($park_id) {
        visitParkAdd($park_id);
        $is_activity = false;
        $results = getPark($park_id);
        foreach ($results as $result) {
            $park_name = $result['park_name'];
            $park_address = $result['address'];
            $area = $result['area'];
        }
        include "views/activity-park-detail.php";
    }

    

}

?>