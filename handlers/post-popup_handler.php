<?php

class PostPopupHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    // $park_id is passed in by the :alpha from the URL -- /park/:alpha
    function get($post_id) {
        include "views/post-popup.php";
    }
}

?>