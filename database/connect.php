<?php
    $server = 'localhost';
    $dbusername = 'root';
    $serverpassword='';
    $dbname='newgallery';


    $conn = new mysqli($server, $dbusername, $serverpassword, $dbname);

    if($conn->connect_error){
        die("Connection Failed: " .$conn->connect_error);
    }
