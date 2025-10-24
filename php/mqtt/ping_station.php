<?php
    include_once 'mqtt.php';
    
    $stationName = $_GET['station'] ?? '';
    $stationTopic = "nextrain/stations/" . $stationName;
    $mqtt->publish($stationTopic . "/ping", "ping", 0);

    $receivedPong = false;

    $mqtt->subscribe($stationTopic . "/pong", function ($topic, $message) {
        // Handle pong response here
        if ($message === 'pong') {
            echo '{"status":"online"}';
            $receivedPong = true;
            die();
        }
    }, 0);

    $callback = function ($mqtt, $elapsedTime) {
        if($elapsedTime > 2) {
            $mqtt->interrupt();
            die('{"status":"offline"}');
        }
    };

    $mqtt->registerLoopEventHandler($callback);
    $mqtt->loop(true, true, 2);
?>