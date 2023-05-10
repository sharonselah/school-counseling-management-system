<?php 

$host = "localhost";
$uname = "root";
$pwd = "sharon";
$dbname ="school-project";

//creates a new instance of the mysqli class and connects to a MySQL database


$conn = new mysqli ($host, $uname, $pwd, $dbname);

if ($conn-> connect_error){
    die("Connection Failed". $conn-> connect_error); 
}




