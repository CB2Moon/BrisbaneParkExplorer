<?php

class SearchMapHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    function get($want) {
        include "views/map-search.php";
    }
}

?>