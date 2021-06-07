<?php
    require_once("../database/database.php");

    if(!$db->connect_error)
    {
        if($_SERVER["REQUEST_METHOD"]=="POST")
        {
            $groupName = $_POST["group"];
            
            $create = "CREATE TABLE IF NOT EXISTS image_groups(
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                id INT(11) NOT NULL auto_increment,
                imageTag VARCHAR(50) UNIQUE,
                PRIMARY KEY(id)
            )";

            if($db->query($create))
            {
                $insert = "INSERT INTO image_groups(imageTag) VALUES('$groupName')";
                $response = $db->query($insert);
                if($response)
                {
                    echo "success";
                }
                else{
                    echo "failed";
                }
            }
            else{
                echo "failed to create table";
            }
        }

        if($_SERVER["REQUEST_METHOD"]=="GET")
        {
            $allData = [];
            $check = "SELECT * FROM image_groups";
            $response = $db->query($check);
            if($response->num_rows!==0)
            {
                foreach($response as $data)
                {
                    array_push($allData,$data);
                }
                echo json_encode($allData);
            }
        }
    }

    
        
?>