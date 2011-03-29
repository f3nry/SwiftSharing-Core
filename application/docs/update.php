<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'swiftsharing-phpfog-com');

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if($mysqli->connect_error) {
    die($mysqli->connect_error);
}

echo "Getting all members..";

$query = "SELECT * FROM myMembers";

$result = $mysqli->query($query);

if(!$result) {
    die($mysqli->error);
}

echo "done.\n";

while($member = $result->fetch_object()) {
    echo "Processing member " . $member->id . "..\n";
    $friend_array = explode(",", trim($member->friend_array, ", "));
    $member_id = $member->id;

    foreach($friend_array as $friend) {
        if(!$friend) {
            break;
        }

        $query = "SELECT * FROM friend_relationships WHERE (`from` = $friend AND `to` = $member_id) OR (`from` = $member_id AND `to` = $friend)";

        $checkResult = $mysqli->query($query);

        if(!$checkResult) {
            die($mysqli->error);
        }

        if($checkResult->num_rows != 2) {
            echo "\tInserting relationship between $member_id and $friend...";
            
            $query = "INSERT INTO friend_relationships VALUES 
                      (0, $member_id, $friend, 'FRIEND', 0),
                      (0, $friend, $member_id, 'FRIEND', 0)";

            if(!$mysqli->query($query)) {
                die($mysqli->error);
            }

            echo "done.\n";
        }
    }
}

echo "Done!\n";
