<?php
// set_time_limit(1000);
    function parseGeoloc($long, $lat) {
        return 'POINT(' . $long . ' ' . $lat . ')';
    }

    function getLastUpdate() {
        $query = MySQL::getInstance()->prepare(
            "SELECT * FROM status ORDER BY id DESC LIMIT 1"
        );
        $query->execute();
        return $query->fetch();
    }
    
    function setLastUpdated($now) {
        $query = MySQL::getInstance()->prepare(
                "INSERT INTO status (updated) VALUES (:currentTime)"
        );
        $query->bindValue(':currentTime', $now, PDO::PARAM_STR);
        $query->execute();
    }

    function insertParks($park_id, $park_name, $address, $area, $long, $lat) {
        $query = MySQL::getInstance()->prepare(
            "INSERT INTO parks (park_id, park_name, address, area, geolocation) 
            VALUES (:park_id, :park_name, :address, :area, GeomFromText(:geolocation))"
        );
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->bindValue(':park_name', $park_name, PDO::PARAM_STR);
        $query->bindValue(':address', $address, PDO::PARAM_STR);
        $query->bindValue(':area', $area, PDO::PARAM_STR);
        $query->bindValue(':geolocation', parseGeoloc($long, $lat), PDO::PARAM_STR);

        $query->execute();
    }

    function getParkID($park_name) {
        $query = MySQL::getInstance()->prepare(
            "SELECT park_id AS id
            FROM parks
            WHERE park_name = :park_name
            "
        );
        $query->bindValue(':park_name', $park_name, PDO::PARAM_STR);

        $query->execute();
        return ($query->fetch(PDO::FETCH_ASSOC))['id'];
    }

    function countParks() {
        $query = MySQL::getInstance()->prepare(
            "SELECT COUNT(*) AS cnt
            FROM parks"
        );
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function insertFacilities($park_id, $node_use, $item_type) {
        $query = MySQL::getInstance()->prepare(
            "INSERT IGNORE INTO facilities (park_id, node_use, item_type) 
            VALUES (:park_id, :node_use, :item_type)"
        );
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->bindValue(':node_use', $node_use, PDO::PARAM_STR);
        $query->bindValue(':item_type', $item_type, PDO::PARAM_STR);

        $query->execute();
    }

    function countFacilities() {
        $query = MySQL::getInstance()->prepare(
            "SELECT COUNT(*) AS cnt
            FROM facilities"
        );
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    function clearActivities() {
        $query = MySQL::getInstance()->prepare(
            "TRUNCATE TABLE activities"
        );
        $query->execute();
    }

    function insertActivities($name, $park_id, $address, $meet_point, $event_type1,
        $event_type2, $activity_type, $age_range, $start_time, $end_time, $description, $requirement, $image_url
    ) {
        $query = MySQL::getInstance()->prepare(
            "INSERT INTO activities (name, park_id, address, meet_point, event_type1, event_type2, activity_type, age_range, start_time, end_time, description, requirement, image_url) 
            VALUES (:name, :park_id, :address, :meet_point, :event_type1, :event_type2, :activity_type, :age_range, :start_time, :end_time, :description, :requirement, :image_url)"
        );
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->bindValue(':address', $address, PDO::PARAM_STR);
        $query->bindValue(':meet_point', $meet_point, PDO::PARAM_STR);
        $query->bindValue(':event_type1', $event_type1, PDO::PARAM_STR);
        $query->bindValue(':event_type2', $event_type2, PDO::PARAM_STR);
        $query->bindValue(':activity_type', $activity_type, PDO::PARAM_STR);
        $query->bindValue(':age_range', $age_range, PDO::PARAM_STR);
        $query->bindValue(':start_time', $start_time, PDO::PARAM_STR);
        $query->bindValue(':end_time', $end_time, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':requirement', $requirement, PDO::PARAM_STR);
        $query->bindValue(':image_url', $image_url, PDO::PARAM_STR);

        $query->execute();
    }

    function getTopParksOf($num, $area) {
        if($area == 'all') {
            $query = MySQL::getInstance()->prepare(
                "SELECT * FROM parks ORDER BY visit DESC LIMIT :num"
            );
        } else {
            $query = MySQL::getInstance()->prepare(
                "SELECT * FROM parks WHERE area = :area ORDER BY visit DESC LIMIT :num"
            );
            $query->bindValue(':area', $area, PDO::PARAM_STR);
        }
        $query->bindValue(':num', $num, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getRecentActivitiesOf($num, $event_type1) {
        if($event_type1 == 'all') {
            $query = MySQL::getInstance()->prepare(
                "SELECT * FROM activities WHERE start_time > NOW() ORDER BY start_time ASC LIMIT :num"
            );
        } else {
            $query = MySQL::getInstance()->prepare(
                "SELECT * FROM activities WHERE event_type1 = :event_type1 ORDER BY start_time ASC LIMIT :num"
            );
            $query->bindValue(':event_type1', $event_type1, PDO::PARAM_STR);
        }
        $query->bindValue(':num', $num, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getFacilitiesOf($num, $node_use) {
        if($node_use == 'all') {
            $query = MySQL::getInstance()->prepare(
                "SELECT DISTINCT item_type FROM facilities LIMIT :num"
            );
        } else {
            $query = MySQL::getInstance()->prepare(
                "SELECT DISTINCT item_type FROM facilities WHERE node_use LIKE '%". $node_use."%' LIMIT :num"
            );
        }
        $query->bindValue(':num', $num, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchPark($to_search) {
        $sql = "SELECT park_id, park_name FROM parks WHERE park_id LIKE '%".$to_search."%'";
        $sql .= " OR park_name LIKE '%".$to_search."%'";
        $sql .= " OR address LIKE '%".$to_search."%'";
        $sql .= " OR area LIKE '%".$to_search."%' ORDER BY visit DESC LIMIT 10";
        $query = MySQL::getInstance()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    function searchActivity($to_search) {
        $sql = "SELECT DISTINCT `name` FROM (SELECT `name`, `start_time` FROM `activities` WHERE `start_time` > NOW() AND (`name` LIKE '%".$to_search."%'";
        $sql .= " OR `event_type1` LIKE '%".$to_search."%'";
        $sql .= " OR `event_type2` LIKE '%".$to_search."%'";
        $sql .= " OR `activity_type` LIKE '%".$to_search."%') ORDER BY `start_time` ASC) T LIMIT 15";
        $query = MySQL::getInstance()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    function searchFacility($to_search) {
        $sql = "SELECT DISTINCT item_type FROM facilities WHERE item_type LIKE '%".$to_search."%'";
        $sql .= " OR node_use LIKE '%".$to_search."%' ORDER BY item_type LIMIT 10";
        $query = MySQL::getInstance()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    function getAllParks() {
        $query = MySQL::getInstance()->prepare(
            "SELECT park_id, park_name, address, area, ST_X(geolocation) AS lng, ST_Y(geolocation) AS lat FROM parks LIMIT 100"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPark($park_id) {
        $query = MySQL::getInstance()->prepare(
            "SELECT park_name, address, area, ST_X(geolocation) AS lng, ST_Y(geolocation) AS lat FROM parks WHERE park_id = :park_id"
        );
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDistinctParkArea() {
        $query = MySQL::getInstance()->prepare(
            "SELECT COUNT(*) AS cnt, area FROM `parks` GROUP BY area HAVING cnt > 2 ORDER by cnt ASC"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getAllActivities() {
        $query = MySQL::getInstance()->prepare(
            "SELECT DISTINCT A.name, A.park_id, ST_X(P.geolocation) AS lng, ST_Y(P.geolocation) AS lat FROM `activities` A LEFT JOIN parks P USING(park_id) WHERE A.start_time > NOW()"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }    
    function getActivity($park_id, $activity_name) {
        $query = MySQL::getInstance()->prepare(
            "SELECT * FROM activities WHERE park_id = :park_id AND `name` = :activity_name"
        );
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->bindValue(':activity_name', $activity_name, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getActivitiesOfPark($park_id, $num=0) {
        if ($num == 0) {
            $query = MySQL::getInstance()->prepare(
                "SELECT DISTINCT `name` FROM activities WHERE park_id = :park_id AND start_time > NOW()"
            );
        } else {
            $query = MySQL::getInstance()->prepare(
                "SELECT DISTINCT `name` FROM activities WHERE park_id = :park_id AND start_time > NOW() LIMIT :num"
            );
            $query->bindValue(':num', $num, PDO::PARAM_INT);
        }
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getActivities($activity_name) {
        $query = MySQL::getInstance()->prepare(
            "SELECT DISTINCT A.name, A.park_id, ST_X(P.geolocation) AS lng, ST_Y(P.geolocation) AS lat FROM `activities` A LEFT JOIN parks P USING(park_id) WHERE A.name = :activity_name AND A.start_time > NOW()"
        );
        $query->bindValue(':activity_name', $activity_name, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDistinctActivityType() {
        $query = MySQL::getInstance()->prepare(
            "SELECT COUNT(*) AS cnt, activity_type FROM `activities`GROUP BY activity_type HAVING cnt > 2 ORDER by cnt ASC"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getActivityId($id) {
        $query = MySQL::getInstance()->prepare(
            "SELECT * FROM activities WHERE id = :id"
        );
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getActivityIdFromNameAndPark($park_id, $name) {
        $query = MySQL::getInstance()->prepare(
            "SELECT id FROM activities WHERE park_id = :park_id AND name = :name"
        );
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->execute();
        return (int) ($query->fetchAll(PDO::FETCH_ASSOC)[0]);
    }
    function getActivitiesOfType($activity_type) {
        $query = MySQL::getInstance()->prepare(
            "SELECT * FROM activities WHERE `activity_type` = :activity_type"
        );
        $query->bindValue(':activity_type', $activity_type, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getAllFacilities() {
        $query = MySQL::getInstance()->prepare(
            "SELECT DISTINCT F.item_type, F.park_id, ST_X(P.geolocation) AS lng, ST_Y(P.geolocation) AS lat FROM `facilities` F LEFT JOIN parks P USING(park_id)"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getFacility($exclude_park_id) {
        $query = MySQL::getInstance()->prepare(
            "SELECT DISTINCT P.park_name FROM `facilities` F LEFT JOIN parks P USING(park_id) WHERE F.park_id != :exclude"
        );
        $query->bindValue(':exclude', $exclude_park_id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getFacilities($item_type) {
        $query = MySQL::getInstance()->prepare(
            "SELECT DISTINCT P.park_id, P.park_name, P.address, P.area, ST_X(P.geolocation) AS lng, ST_Y(P.geolocation) AS lat FROM `facilities` F LEFT JOIN parks P USING(park_id) WHERE F.item_type = :item_type"
        );
        $query->bindValue(':item_type', $item_type, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getFacilitiesOfPark($park_id, $num=0) {
        if ($num == 0) {
            $query = MySQL::getInstance()->prepare(
                "SELECT DISTINCT item_type FROM `facilities` WHERE park_id = :park_id"
            );            
        } else {
            $query = MySQL::getInstance()->prepare(
                "SELECT DISTINCT item_type FROM `facilities` WHERE park_id = :park_id LIMIT :num"
            );            
            $query->bindValue(':num', $num, PDO::PARAM_INT);
        }
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPosts($num=0) {
        if($num == 0) {
            $query = MySQL::getInstance()->prepare(
                "SELECT * FROM `post` ORDER BY post_time DESC"
            );
        } else {
            $query = MySQL::getInstance()->prepare(
                "SELECT * FROM `post` ORDER BY post_time DESC LIMIT :num"
            );
            $query->bindValue(':num', $num, PDO::PARAM_INT);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPost($post_id) {
        $query = MySQL::getInstance()->prepare(
            "SELECT * FROM `post` WHERE post_id = :post_id"
        );
        $query->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function getCommentsOf($post_id){
        $query = MySQL::getInstance()->prepare(
            "SELECT * FROM `comment` WHERE post_id = :post_id ORDER BY comment_time DESC"
        );
        $query->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function postCommentCount($post_id) {
        $query = MySQL::getInstance()->prepare(
            "SELECT COUNT(*) AS cnt FROM `comment` WHERE post_id = :post_id"
        );
        $query->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $query->execute();
        return (int) ($query->fetch(PDO::FETCH_ASSOC)['cnt']);
    }
    function insertPost($title, $words, $sender, $is_activity) {
        $query = MySQL::getInstance()->prepare(
            "INSERT IGNORE INTO post (sender, title, words, is_activity) 
            VALUES (:sender, :title, :words, :is_activity)"
        );
        $query->bindValue(':sender', $sender, PDO::PARAM_STR);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':words', $words, PDO::PARAM_STR);
        $query->bindValue(':is_activity', $is_activity, PDO::PARAM_BOOL);

        $query->execute();
    }
    function insertComment($post_id, $words) {
        $query = MySQL::getInstance()->prepare(
            "INSERT IGNORE INTO comment (sender, words, post_id) 
            VALUES (:sender, :words, :post_id)"
        );
        $query->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $query->bindValue(':words', $words, PDO::PARAM_STR);
        $query->bindValue(':sender', 'Anonymous' . rand(0, 19), PDO::PARAM_STR);

        $query->execute();
    }

    function visitParkAdd($park_id){
        $query = MySQL::getInstance()->prepare(
            "UPDATE parks SET visit = visit + 1 WHERE park_id = :park_id"
        );
        $query->bindValue(':park_id', $park_id, PDO::PARAM_STR);

        $query->execute();
    }

    function visitactivityAdd($id){
        $query = MySQL::getInstance()->prepare(
            "UPDATE activities SET visit = visit + 1 WHERE id = :id"
        );
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();
    }
?>