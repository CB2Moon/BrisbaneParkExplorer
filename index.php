<?php 
// ToroPHP: Anand, K.(2015)ToroPHP(Version 2.0.1)[Source code] https://github.com/anandkunal/ToroPHP
set_time_limit(300);
ini_set('max_execution_time', '300');
require_once('handlers/home_handler.php');
require_once('handlers/aboutus_handler.php');
require_once('handlers/park_handler.php');
require_once('handlers/activity_handler.php');
require_once('handlers/all_parks_handler.php');
require_once('handlers/all_activities_handler.php');
require_once('handlers/all_posts_handler.php');
require_once('handlers/post-popup_handler.php');
require_once('handlers/search_handler.php');
require_once('handlers/search_map_handler.php');
require_once('handlers/search_park_handler.php');
require_once('handlers/search_activity_handler.php');
require_once('handlers/search_facility_handler.php');
require_once('handlers/search-result_handler.php');
require_once('lib/private.php');
require_once('lib/mysql.php');
require_once('lib/queries.php');
require_once('lib/util.php');
require_once('lib/Toro.php');

ToroHook::add("404", function () {
    header("HTTP/1.0 404 Not Found");
    echo "Page does not exist";
    exit;
});

Toro::serve(array(
    "/"  => "HomeHandler",
    "/aboutus"  => "AboutUsHandler",
    "/allParks"  => "AllParksHandler",
    "/allActivities"  => "AllActivitiesHandler",
    "/park/:alpha"  => "ParkHandler",
    "/activity/:alpha"  => "ActivityHandler",
    
    "/allPosts"  => "AllPostsHandler",

    // Private page: generate the HTML for a post detail
    "/post-popup/:alpha"  => "PostPopupHandler",

    // search main page, display all results
    "/search"  => "SearchHandler",

    // retrieve json for search main page to display markers 
    "/search/map/:alpha"  => "SearchMapHandler",

    // Private page: generate the HTML for the right hand side information section
    // all linked to search-info-display.php
    "/search/park/:alpha"  => "SearchParkHandler",
    "/search/activity/:alpha"  => "SearchActivityHandler",
    "/search/facility/:alpha"  => "SearchFacilityHandler",

    // Private page: generate the HTML for the search bar
    "/search-result/:alpha"  => "SearchResultHandler"
));
?>