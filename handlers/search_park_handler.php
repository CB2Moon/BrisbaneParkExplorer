<?php

class SearchParkHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    // $park_id is passed in by the :alpha from the URL -- /park/:alpha
    function get($park_id) {
        $search = 'park';
        include "views/search-info-display.php";
    }
}

?>