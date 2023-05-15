<?php


// Connect to database and get user ID from URL parameter
include '../Backend/db.php';
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
    

    // Update user data in database
    $stmt = $conn->prepare("UPDATE counselors SET name = ?, specialty = ?, email =? WHERE counselor_id = ?");
    $stmt->bind_param("ssssi", $name, $specialty,$email, $id);
    $stmt->execute();

    // Redirect back to user list
    header("Location: admindashboard.php");
    exit();
}
?>

<style>

    form{

    height: 350px; 
    width: 400px; 
    border-radius: 6px;
    margin: 20px auto; 
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    padding: 25px; 
    padding-top: 5px; 
}

input{
    width: 100%;  
    padding-top: 32px; 
    margin: 10px 0px; 
    border: none; 
    outline: none;
    border: 1px solid black; 
    border-radius: 6px;
}

button{
    background-color: #800000; 
    border: 1px solid #800000; 
    border-radius: 6px; 
    font-size: 18px;
    font-weight: 500;
    line-height: 1.2;
    list-style: none;
    padding: 15px 45px;
    transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
    color: white; 
    margin-left: 30%; 
}
</style>

<!-- Display form with current user data -->

    <form method="POST" id="edit_form">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>"><br>
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" value="<?php echo $user['specialty']; ?>"><br>
        <label for="specialty">Email:</label>
        <input type="text" name="email" value="<?php echo $user['email']; ?>"><br>
        <button type="submit" id="edit-button">Save</button>
    </form>


<script>

document.getElementById('edit-button').addEventListener('click', function(){ 
    confirm('Are you Sure you want to update?') });

    //Check if the peron clicked yes or No

    

// The button was clicked!
    
</script>
