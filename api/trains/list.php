<?php

include_once 'php\\db.php';
global $con;

function get_trains() {
    $query = "SELECT * FROM trens;";
    $result = mysqli_query(get_con(), $query);

    $trains = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $trains[] = $row;
    }

    return $trains;
}

?>