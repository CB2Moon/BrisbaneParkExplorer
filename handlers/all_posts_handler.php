<?php

class AllPostsHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    function get() {
        include "views/allPosts.php";
    }
}

?>