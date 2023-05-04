<?php

class SearchResultHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    function get($to_search) {
        include "views/search-result.php";
    }
}

?>