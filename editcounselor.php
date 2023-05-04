<?php
// Connect to database and get user ID from URL parameter
include 'Backend/db.php';
$id = $_GET["id"];

// Get user data from database
$stmt = $conn->prepare("SELECT * FROM counselors WHERE counselor_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get new name and specialty from form
    $name = $_POST["name"];
    $specialty = $_POST["specialty"];
    $email = $_POST['email'];
    $role = $_POST['role']; 

    // Update user data in database
    $stmt = $conn->prepare("UPDATE counselors SET name = ?, specialty = ?, email =? , role =? WHERE counselor_id = ?");
    $stmt->bind_param("ssssi", $name, $specialty,$email, $role, $id);
    $stmt->execute();

    // Redirect back to user list
    header("Location: admindashboard.php");
    exit();
}
?>

<!-- Display form with current user data -->
<form method="POST" id="edit_form">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $user['name']; ?>"><br>
    <label for="specialty">Specialty:</label>
    <input type="text" name="specialty" value="<?php echo $user['specialty']; ?>"><br>
    <label for="specialty">Email:</label>
    <input type="text" name="email" value="<?php echo $user['email']; ?>"><br>
    <label for="specialty">Role:</label>
    <input type="text" name="role" value="<?php echo $user['role']; ?>"><br>
    <button type="submit" id="edit-button">Save</button>
</form>

<script>

document.getElementById('edit-button').addEventListener('click', function(){ 
    confirm('Are you Sure you want to update?') });

    //Check if the peron clicked yes or No

    

// The button was clicked!
    
</script>
