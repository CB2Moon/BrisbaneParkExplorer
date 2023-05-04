<?php
// set_time_limit(1000);
class HomeHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            checkForUpdates();
        });
    }

    function get() {
        include "views/home.php";
    }
}

?>