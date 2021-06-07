<?php
    require_once("../database/database.php");
    if(!$db->connect_error)
    {
        if($_SERVER["REQUEST_METHOD"]=="POST")
        {
            $check_table = "CREATE TABLE IF NOT EXISTS users(
                id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(99),
                username VARCHAR(50) UNIQUE,
                password VARCHAR(50),
                PRIMARY KEY(id)
            )";

            $response = $db->query($check_table);
            if($response)
            {
                $name = $_POST["name"];
                $username = $_POST["username"];
                $password = $_POST["password"];

                $insert = "INSERT INTO users(name,username,password) VALUES('$name','$username','$password')";
                if($db->query($insert))
                {
                    echo "success";
                }
                else{
                    echo "failed";
                }
            }
        }
        if($_SERVER["REQUEST_METHOD"]=="GET")
        {
            $check_table = "CREATE TABLE IF NOT EXISTS users(
                id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(99),
                username VARCHAR(50) UNIQUE,
                password VARCHAR(50),
                PRIMARY KEY(id)
            )";

            $response = $db->query($check_table);
            if($response)
            {
                print_r($_GET);
            }
        }
    }
?>