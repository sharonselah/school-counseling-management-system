<?php 

$host = "localhost"; //local computer that the program is running on
$uname = "root"; //mysql username
$pwd = "sharon"; //mysql password
$dbname ="school-project"; //database to be used

//creates a new instance of the mysqli class and connects to a MySQL database

$conn = new mysqli ($host, $uname, $pwd, $dbname);

//determine if the connection to the db was successful

if ($conn-> connect_error){
    //if error, halt execution using method die 
    die("Connection Failed". $conn-> connect_error); 
}




