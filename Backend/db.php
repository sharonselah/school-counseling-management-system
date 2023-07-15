<?php 

$host = "localhost";
$uname = "root";
$pwd = "sharon";
$dbname ="school-project";

//creates a new instance of the mysqli class and connects to a MySQL database

$conn = new mysqli ($host, $uname, $pwd, $dbname);

//determine if the connection to the db was successful

if ($conn-> connect_error){
    //if error, halt execution using method die 
    die("Connection Failed". $conn-> connect_error); 
}




