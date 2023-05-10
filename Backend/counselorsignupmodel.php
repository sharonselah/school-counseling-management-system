<?php

include 'functions.php'; 
if ($_SERVER["REQUEST_METHOD"]=="POST"){

    $name = filter_var ($_POST["name"], FILTER_SANITIZE_STRING); 
    $spec = filter_var($_POST["spec"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

    $role = "counselor"; // or "student"
    processForm("counselors", $name, $email, $password, $role);

}
