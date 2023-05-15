<?php

/*
Start the session to ensure that the session data
is properly cleared from the server

*/

session_start();
session_destroy(); 
header("Location: home.php");
exit(); 
