<?php 

$host = "localhost";
$uname = "root";
$pwd = "sharon";
$dbname ="school-project";


$conn = new mysqli ($host, $uname, $pwd, $dbname);

if ($conn-> connect_error){
    die("Connection Failed". $conn-> connect_error); 
}




