<?php
    require_once("../database/database.php");
    if(!$db->connect_error)
    {
        if(isset($_SESSION["userAuth"]))
        {
            if($_SERVER["REQUEST_METHOD"]=="POST")
            {
                $file = $_FILES["image"];
                $imageName = $_POST["imageName"];
                $group = $_POST["imageGroup"];

                $temName = $file["tmp_name"];
                $path = "storage/uploads/".$imageName.".".strtolower(explode(".",$file["name"])[1]);
                
                $checkTable = "CREATE TABLE IF NOT EXISTS images(
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    images MEDIUMTEXT UNIQUE,
                    title VARCHAR(199),
                    imageTag VARCHAR(50),
                    PRIMARY KEY(id)
                )";

                if($db->query($checkTable))
                {
                    $checkFileName = "SELECT * FROM images WHERE images='$path'";
                    $response = $db->query($checkFileName);
                    if($response->num_rows==0)
                    {
                        $store = "INSERT INTO images(images,imageTag) VALUES('$path','$group')";
                        if($db->query($store))
                        {
                            $response = move_uploaded_file($temName,"../".$path);
                            if($response)
                            {
                                echo "success";
                            }
                        }
                        else{
                            echo "failed";
                        }
                    }
                    else{
                        echo "fileExist";
                    }
                    
                }
                else{
                    echo"unable to create table";
                }
            }
            if($_SERVER["REQUEST_METHOD"]=="GET")
            {
                $checkTable = "CREATE TABLE IF NOT EXISTS images(
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    images MEDIUMTEXT UNIQUE,
                    title VARCHAR(199),
                    imageTag VARCHAR(50),
                    PRIMARY KEY(id)
                )";

                $response = $db->query($checkTable);
                if($response)
                {
                    $allData=[];
                    $fetch = $_GET["fetch"];
                    $images;
                    if($fetch=="all")
                    {
                        $images = "SELECT * FROM images";
                    }
                    else{
                        $images = "SELECT * FROM images WHERE imageTag='$fetch'";
                    }
                    
                    $response = $db->query($images);
                    if($response->num_rows!==0)
                    {
                        foreach($response as $response)
                        {
                            array_push($allData,$response);
                        }
                        echo json_encode($allData);
                    }
                    else{
                        echo "empty";
                    }
                }
            }
        }
    }
?>