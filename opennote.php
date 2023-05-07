<?php

session_start(); 

include 'Backend/db.php'; 
$note_id = $_SESSION["note_id"]; 

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
