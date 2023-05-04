<?php

class AllParksHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    // $slug is passed in by the :alpha from the URL -- /truck/:alpha
    function get() {
        $is_activity = false;
        include "views/activity-park-all.php";
    }
}

?>