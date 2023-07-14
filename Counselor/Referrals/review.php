<?php
include '../../Backend/db.php';
session_start();

// Retrieve the student ID from the URL parameter
$student_id = $_GET['id'];
$id = $_SESSION['user_id'];

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  $understood = $_POST['understood'];

  if ($understood === 'yes') {
    // Compose the notification message
    $message = "You have received a new review from your counselor. It aims to find out how you are getting on with the therapy sessions so far. & how you would like future sessions to pan out.";

    // Insert the notification for the student
    $query = "INSERT INTO notifications (recipient_id, sender_id, recipient_role, sender_role, notification_type, message) 
              VALUES (?, ?, ?, ?, 'review', ?)";
    $stmt = $conn->prepare($query);
    $recipient_role = 'student';
    $sender_role = 'counselor';
    $stmt->bind_param("iisss", $student_id, $id, $recipient_role, $sender_role, $message);
    $stmt->execute();

    echo '<script>alert("Review notification sent!");</script>';
    echo '<script>setTimeout(function() { window.location.href = "../counselordashboard.php"; }, 2000);</script>';
    exit();
  }else {
    // Redirect back to the counselor dashboard
    header("Location: ../counselordashboard.php");
    exit();
  }

 
}
?>

<!-- HTML code -->
<!DOCTYPE html>
<html>
<head>
    <style>
    .container {
    max-width: 550px;
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 8px;
    }

    .container h1 {
    font-size: 24px;
    margin-bottom: 20px;
    }

    .container ul {
    text-align: left;
    margin-left: 10px;
    margin-bottom: 20px;
    line-height: 2;
    }

    .container ul li {
    margin-bottom: 10px;
    }

    .container .voluntary-message {
    font-style: italic;
    color: #888;
    color: red;
    margin-bottom: 50px;
    }

    .container form {
   
    display: flex;
    flex-direction: column;
    align-items: center;
    }

    .container label {
    margin-bottom: 10px;
    }

    .container select {
    margin-bottom: 10px;
    }

    .container button {
    padding: 8px 16px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }

    </style>
</head>
<body>
  <!-- Container and message -->
  <div class="container">
    <h1>Why ask for a Review?</h1>
    <ul>
        <li>Provide valuable feedback for the counselor to assess client progress and satisfaction.</li>
        <li>Strengthen trust, rapport, and safety.</li>
        <li>Ensure therapy goals align with the client's evolving needs.</li>
        <li>Help counselors refine therapy techniques for improved outcomes.</li>
        <li>Promote client involvement, self-awareness, and personal growth in their therapeutic journey.</li>
    </ul>

    <p class="voluntary-message">The review is completely voluntary. Do not coerce the student.</p>

    <!-- Form to confirm understanding -->
    <form method="POST">
        <label for="understood">Are you sure a review is necessary for this student at this point? </label>
        <select name="understood" id="understood">
        <option value="yes">Yes</option>
        <option value="no">No</option>
        </select>
        <button type="submit" name="submit">Submit</button>
    </form>
 </div>


  <!-- Other HTML code -->
</body>
</html>
