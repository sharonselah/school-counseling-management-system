<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'counselor') {
    // User is not authenticated or is not a counselor, redirect to login page
    header('Location: Login.php');
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Note-Taking Template</title>
	

<style>
	body {
		font-family: "Times New Roman", serif;
		margin: 0;
		padding: 0;
		background-color: #f8f8f8; 
	}
	h1 {
		font-size: 24px;
		margin-top: 0;
	}
	form {
		width: 40%;
		margin: 20px auto; 
		background-color: #fff;
		padding: 20px;
		box-shadow: 0 0 5px rgba(0,0,0,0.3);
		border-radius: 5px;
		display: flex;
		flex-direction: column;
		align-items: center;
	}
	label {
		display: block;
		margin-top: 10px;
	}

	input[type="text"], textarea {
		display: block;
		width: 100%;
		padding: 5px;
		border: 1px solid #ccc;
		border-radius: 3px;
		font-size: 14px;
		margin-bottom: 10px;
        font-family: "Times New Roman", serif;
        line-height: 1.5rem; 
        font-size: 18px; 
	}

	input[type="submit"] {
		background-color: #800080;
		color: #fff;
		border: none;
		padding: 10px 20px;
		border-radius: 3px;
		cursor: pointer;
		font-size: 16px;
    
	}
	</style>
</head>
<body>
	<div class="container">
		
		<form method="POST" action="Backend/notesmodel.php">
			<h1>CUEA Counseling Note-Taking Template</h1>
		

			<label>Title<span style= 'color: red;'>*</span></label>
			<textarea name="title" id="title"> </textarea>

			<label>Content<span style= 'color: red;'>*</span></label>
			<textarea rows="10" cols="40" name="content" id = "content" >Client's complaint: 

Clinical Observations:

Issues and Stressors Discussed:

Diagnosis:

Plan: 
		</textarea>



			<input onclick ="return confirmSaving()" type="submit" value="Save Note">
			<p id = "message" style="color:red;"></p>
		</form>
	</div>

  <script>

    



	function confirmSaving(){

		let title = document.getElementById("title").value;
		let content = document.getElementById("content").value;
		let message = document.getElementById("message");

		if (title.trim() == ""){
			message.innerHTML = "Title cannot be empty";
			return false;
		}else {
			var confirmation= confirm("Are you sure you want to save the note?"); 
      		return confirmation; 
		}
      
    }
  </script>
</body>
</html>
