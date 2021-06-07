<?php
    require_once("../database/database.php"); // data base page connection
    if(!$db->connect_error)
    {
        if($_SERVER["REQUEST_METHOD"]=="GET")
        {
            if($_GET["task"]=="loginCheck")
            {
                checkUser();
            }
        }
    }
    else{
        header("Content-Tyep:application/json");
        echo json_encode(array("data"=>"Server Error"));
        die();
    }

    function checkUser(){
        if(!isset($_SESSION["userAuth"]))
        {
            header("Content-Tyep:application/json");
            echo json_encode(array("data"=>"NoLogIn"));
        }
        else{
            header("Content-Tyep:application/json");
            echo json_encode(array("data"=>"userFound"));
        }
    }
?>