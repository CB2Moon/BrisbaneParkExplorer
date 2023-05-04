<?php

class AllActivitiesHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    // $slug is passed in by the :alpha from the URL -- /truck/:alpha
    function get() {
        $is_activity = true;
        include "views/activity-park-all.php";
    }
}

?>