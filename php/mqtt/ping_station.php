<?php
    include_once 'mqtt.php';
    
    $stationName = $_GET['station'] ?? '';
    $stationTopic = "input/" . $stationName;
    $mqtt->publish($stationTopic, "ping", 0);

    $receivedPong = false;

    $mqtt->subscribe("out/" . $stationName, function ($topic, $message) {
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
