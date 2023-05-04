<?php
if($want[0] == '0') {
    $want = substr($want, 1);
    if($want == 'allParks') {
        $res = getAllParks();
    } elseif($want == 'allActivities') {
        $res = getAllActivities();
    } elseif($want == 'allFacilities') {
        $res = getAllFacilities();
    }
} elseif($want[0] == '1') {
    // park
    $park_id = substr($want, 1);
    $res = getPark($park_id);
} elseif($want[0] == '2') {
    // activity
    $activity_name = preg_replace('/_/', ' ', substr($want, 1));
    $res = getActivities($activity_name);
} elseif($want[0] == '3') {
    // facility
    $item_type = substr($want, 1);
    $item_type = preg_replace('/_{3}/', '/', $item_type);
    $item_type = preg_replace('/_/', ' ', $item_type);
    $res = getFacilities($item_type);
}
$ans = [];
foreach ( $res as $row)  {
    $ans[] = $row;
}
echo json_encode($ans, JSON_PRETTY_PRINT);
?>