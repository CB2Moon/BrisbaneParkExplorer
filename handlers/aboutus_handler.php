<?php
class AboutUsHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    function get() {
        include "views/aboutUs.php";
    }
}

?>