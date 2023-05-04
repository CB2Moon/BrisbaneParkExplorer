<?php

class SearchHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    // $park_id is passed in by the :alpha from the URL -- /park/:alpha
    function get() {
        $hasSearched = false;
        include "views/search.php";
    }
}

?>