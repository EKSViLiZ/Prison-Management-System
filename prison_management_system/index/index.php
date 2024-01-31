<?php
    $host_name = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'prison_management_system';
    $conn = mysqli_connect($host_name, $db_user, $db_password, $db_name);
    
    if (!$conn){
        die("could not connect to database,");
    }
?>
