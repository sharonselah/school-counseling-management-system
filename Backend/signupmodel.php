<?php

include 'functions.php'; 

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $role = "student"; 
    processForm("students", $name, $email, $password, $role);

}
