<?php

session_start(); 

include '../Backend/db.php'; 

if (isset($_GET['id'])) {
  $note_id = $_GET['id'];
}


// Get user data from database
$stmt = $conn->prepare("SELECT * FROM notes WHERE note_id = ?");


$stmt->bind_param("i", $note_id);
$stmt->execute();
$result = $stmt->get_result();
$note = $result->fetch_assoc();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get new name and specialty from form
    $title = $_POST["title"];
    $content = $_POST["content"];
   

    // Update user data in database
    $stmt2 = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE note_id = ?");
    $stmt2->bind_param("ssi", $title, $content, $note_id);
    $stmt2->execute();

    // Redirect back to user list
    header("Location: counselordashboard.php");
    exit();
}
?>

<style>

        form{
                height: 580px; 
                width: 400px; 
                border-radius: 6px;
                margin: auto; 
                box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
                padding: 25px; 
                padding-top: 5px;
                
            }

            label, textarea{
                display: block; 
            }

             textarea{
                width: 100%;  
                padding-top: 32px; 
                margin: 10px 0px; 
                border: none; 
                outline: none;
                border: 1px solid black; 
                border-radius: 6px;
                font-family: 'Times New Roman'; 
                font-size: 16px; 
                line-height: 1.5rem;  
            }

             input{
                background-color: #800000; 
                border: 1px solid #800000; 
                border-radius: 6px; 
                font-size: 16px; 
                line-height: 1.2;
                padding: 10px 45px;
                color: white; 
                margin-left: 30%; 
            }
</style>

<!-- Display form with current user data -->
<form method="POST" action="">
      <h1>CUEA Counseling Note-Taking Template</h1>
   
			<label>Title:</label>
			<textarea name="title"> <?php echo $note["title"];?> </textarea>

			<label>Content:</label>
			<textarea rows="10" cols="40" name="content"><?php echo $note["content"]; ?></textarea>

			<input onclick ="return confirmSaving()" type="submit" value="Update Note">
		</form>


  <script>

    function confirmSaving(){
      var confirmation= confirm("Are you sure you want to save the note?"); 
      return confirmation; 
    }
  </script>
