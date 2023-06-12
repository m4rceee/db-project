<?php

    $uname = "localhost";
    $unmae = "root";
    $password = "";
    $db_name = "admin_db";

    $conn = mysqli_connect($uname, $unmae, $password, $db_name);

    if(!$conn) {
        echo "Connection failed.";
    }