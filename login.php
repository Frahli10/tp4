<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tp";
    $port = "3306";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT salt, password, firstname, lastname FROM users WHERE email='" . $_POST['email'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
         
            $hash = md5($_POST["password"].$row["salt"]);
            if($hash == $row["password"]){
                echo "Welcome ". $row["firstname"]." ".$row["lastname"]." ".$hash;
            }else{
                echo "Login failed";
            }
        }
    } else {
        echo "0 results";
    }
    $conn->close();
}
