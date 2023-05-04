<?php
// Brisbane City Council, 2020, "Park — Locations", Brisbane City Council. [Online]. https://www.data.brisbane.qld.gov.au/data/dataset/park-locations
// Brisbane City Council, 2014, "Park Facilities and Assets locations", Brisbane City Council. [Online]. https://www.data.brisbane.qld.gov.au/data/dataset/park-facilities-and-assets
// Brisbane City Council, 2015, "Events — Brisbane parks", Brisbane City Council. [Online]. https://www.data.brisbane.qld.gov.au/data/dataset/brisbane-parks-events
// Use Flickr API to search & load images - Flickr: SmugMug(2004)Flickr.https://www.flickr.com/services/api/
function checkForUpdates() {
    date_default_timezone_set('Australia/Brisbane');
    $now = date('Y-m-d H:i:s', time());
    $diff = strtotime($now) - strtotime(getLastUpdate()['updated']);
    $diff /= 86400;
    if ($diff > 10) {
        setLastUpdated($now);
        clearActivities();
        loadActivities();
    }
}

function loadParks() {
    $parks_url = "https://www.data.brisbane.qld.gov.au/data/api/3/action/datastore_search?resource_id=2c8d124c-81c6-409d-bffb-5761d10299fe&limit=2200";
    $data = file_get_contents($parks_url);
    $data = json_decode($data, true);

    foreach ($data['result']['records'] as $_ => $recordValue) {
        $park_id = $recordValue['PARK_NUMBER'];
        $park_name = $recordValue['PARK_NAME'];
        $address = $recordValue['STREET_ADDRESS'];
        $area = $recordValue['SUBURB'];
        $long = $recordValue['LONG'];
        $lat = $recordValue['LAT'];
        insertParks($park_id, $park_name, $address, $area, $long, $lat);
    }
}

function loadFacilities() {
    // $facility_url = "https://www.data.brisbane.qld.gov.au/data/api/3/action/datastore_search?resource_id=66b3c6ce-4731-4b19-bddd-8736e3111f7e&limit=1000&offset=" . $offset;
    // $facility_url = "66b3c6ce-4731-4b19-bddd-8736e3111f7e.json";
    $facility_url = "faci_test.csv";
    if (($open = fopen($facility_url, "r")) !== FALSE) {
        // discard column header
        $data = fgetcsv($open, 1000, ",");

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            $park_id = $data[0];
            $node_use = $data[1];
            $item_type = $data[2];
            
            insertFacilities($park_id, $node_use, $item_type);
        }
    }
    fclose($open);
}

function loadActivities() {
    $activity_url = "http://www.trumba.com/calendars/brisbane-events-rss.rss?filterview=parks";
    $data = file_get_contents($activity_url);
 
    // Instantiate XML element
    $xml = new SimpleXMLElement($data);
    
    foreach($xml->channel->item as $item) {
        $xcal = $item->children('xCal', true);
        $xtrumba = $item->children('x-trumba', true);
        
        // if cost is free
        if ($item->xpath(".//*[@id='22177']")[0] == 'Free') {
            $name = $xcal->summary;
            $park = strtoupper(explode(',', $xcal->location)[0]);
            $park_id = getParkID($park);
            if (is_null($park_id)) { // park not recorded in the DB
                continue;
            }

            $description = $xcal->description;
        
            $start_time = str_replace("T", " ", $xtrumba->localstart);
            $end_time = str_replace("T", " ", $xtrumba->localend);
        
            $address = $item->xpath(".//*[@id='22505']")[0];
            
            // use age_range first, then age, then All
            $age_range = $item->xpath(".//*[@id='21858']");
            if (count($age_range)) { // check if age_range exists
                $age_range = $age_range[0];
            } else {
                $age_range = $item->xpath(".//*[@id='23562']");
                if (count($age_range)) { // check if age exists
                    $age_range = $age_range[0];
                } else {
                    $age_range = "All ages";
                }
            }

            $meet_point = $item->xpath(".//*[@id='23560']")[0];
            $image_url = $item->xpath(".//*[@id='40']")[0];

            $requirement = $item->xpath(".//*[@id='23561']");
            if(count($requirement)) {
                $requirement = $requirement[0];
            } else {
                $requirement = "No requirements for this Activity";
            }

            $event_type1 = $item->xpath(".//*[@id='21']")[0];
            $event_type2 = $item->xpath(".//*[@id='21859']");
            if(count($event_type2)) {
                $event_type2 = $event_type2[0];
            } else {
                $event_type2 = "NULL";
            }
            
            $activity_type = $item->xpath(".//*[@id='23294']");
            if(count($activity_type)) {
                $activity_type = $activity_type[0];
            } else {
                $activity_type = "NULL";
            }
        
            insertActivities($name, $park_id, $address, $meet_point, $event_type1, $event_type2,
            $activity_type, $age_range, $start_time, $end_time, $description, $requirement, $image_url);
        }
    }
}

function searchImg($search_for, $size='small') {
    switch ($size) {
        case 'medium':
            $size = 'z.jpg';
            break;
        case 'large':
            $size = 'b.jpg';
            break;        
        default:
            $size = 'w.jpg';
            break;
    }
    $search_for = str_replace(' ', '+', $search_for);
    $flickr_url = "https://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=22afeb742e2f626f77a2b8166914db19&text=".$search_for."&accuracy=1&per_page=20&bbox=113.338953078%2C+-43.6345972634%2C+153.569469029%2C+-10.6681857235&sort=relevance&media=photos&format=json&nojsoncallback=1";
    $data = file_get_contents($flickr_url);
    $data = json_decode($data, true);
    $img_urls = [];
    if ($data['photos']['total'] > 0) {
        foreach ($data['photos']['photo'] as $recordValue) {
            $server_id = $recordValue['server'];
            $secret = $recordValue['secret'];
            $id = $recordValue['id'];
            $img_urls[] = 'https://live.staticflickr.com/'.$server_id.'/'.$id.'_'.$secret.'_'.$size;
        }
    }
    if (sizeof($img_urls) == 0) {
        return searchImg("Brisbane Park", $size);
    }
    return $img_urls[rand(0, sizeof($img_urls) - 1)];
}

function resultToStr($arr) {
    $func = function($someArr) {return array_values($someArr)[0];};
    $arr = array_map($func, $arr);
    if(count($arr) < 2) {
        return end($arr) . '.';
    }
    return join(', ', array_slice($arr, 0, count($arr) - 1)). ', and ' . end($arr) . '.';
}
?>