<?php 

session_start(); 
include 'Backend/db.php'; 
$id = $_SESSION['user_id']; 

$stmt = $conn->prepare("SELECT * FROM notes where counselor_id = ?"); 

$stmt->bind_param('i', $id);
$stmt-> execute(); 

$result = $stmt->get_result(); 




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>

    table{
        border-collapse: collapse; 
    }

    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }
</style>
<body>

<div id="documents">
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Date Modified</th>
            <th>Open</th>
        
        </tr>
        </thead>

        <tbody> <?php

            if ($result-> num_rows >0){

                while ($row=$result->fetch_assoc()){
            echo"<tr>
                    <td>".$row["note_id"]."</td>
                    <td>".$row["title"]."</td>
                    <td>".$row["created_at"]."</td>
                    <td><a href='opennote.php?id=". $row ["note_id"]."'>Open</a></td>
                </tr>"; 

                $_SESSION["note_id"] = $row["note_id"]; 
               }
                
            }?>
            
        </tbody>
    </table>
</div>
</body>
</html>