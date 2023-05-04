<?php

class SearchActivityHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    // $park_id is passed in by the :alpha from the URL -- /park/:alpha
    function get($park_id_activity_name) {
        $search = 'activity';
        $park_id = substr($park_id_activity_name, 0, 5);       
        $activity_name = substr($park_id_activity_name, 5);
        $activity_name = preg_replace('/_/', ' ', $activity_name);
        
        include "views/search-info-display.php";
    }
}

?>