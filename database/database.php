<?php
    session_start();
    $mysql = new mysqli("localhost","root","");
    $db;
    if(!$mysql->connect_error)
    {
        $dbName = "imageshare";
        $createDb = "CREATE DATABASE IF NOT EXISTS imageshare";
        $response = $mysql->query($createDb);
        $db = new mysqli("localhost","root","","imageshare");
        if($db->connect_error)
        {
            echo "Server Error";
            die();
        }
    }
?>