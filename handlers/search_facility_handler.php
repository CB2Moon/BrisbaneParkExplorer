<?php

class SearchFacilityHandler {
    function __construct() 
    {
        ToroHook::add("before_handler", function() {
            // checkForUpdates();
        });
    }

    function get($park_id_facility_type) {
        $search = 'facility';
        $park_id = substr($park_id_facility_type, 0, 5);       
        $facility_type = substr($park_id_facility_type, 5);
        $facility_type = preg_replace('/_{3}/', '/', $facility_type);
        $facility_type = preg_replace('/_/', ' ', $facility_type);
        include "views/search-info-display.php";
    }
}

?>