<?php

$connection = null;

try {
    //Config
    $host = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "db_perpus";

    //Connect
    $database = "mysql:dbname=$dbname;host=$host";
    $connection = new PDO($database, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Error ! " . $e->getMessage();
    die;
}
