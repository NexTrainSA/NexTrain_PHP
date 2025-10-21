<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$inipath = php_ini_loaded_file();
$ini_array = parse_ini_file($inipath, true)["PHP"];

$mqtt_topic = "nextrain_production";
$mqtt_user = $ini_array["nt_mqtt_user"];
$mqtt_pass = $ini_array["nt_mqtt_pass"];
$mqtt_host = $ini_array["nt_mqtt_host"];
$mqtt_port = 6883;

$mqtt = new \PhpMqtt\Client\MqttClient($mqtt_host, $mqtt_port, "nextrain_mqtt_client_" . uniqid());
$connSettings = (new \PhpMqtt\Client\ConnectionSettings)
    ->setUsername($mqtt_user)
    ->setPassword($mqtt_pass)
    ->setUseTls(false);

$mqtt->connect($connSettings, true);

if (!$mqtt->isConnected()) {
    die("Connection failed: " . mysqli_connect_error());
}

$mqtt->publish($mqtt_topic, "test", 0);