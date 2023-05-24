<?php 


// Function to check and handle session timeout
function checkSessionTimeout($timeout = 1800) { // 1800 seconds = 30 minutes
    

    // Get the last activity timestamp from the session
    $lastActivity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();

    // Check if the user has been inactive for the timeout period
    if (time() - $lastActivity > $timeout) {
        // Destroy the session
        session_unset();
        session_destroy();
        $_SESSION = array();

        // Redirect to the login page or any other desired action
        header("Location: ../Login.php");
        exit();
    } else {
        // Update the last activity timestamp
        $_SESSION['last_activity'] = time();
    }
}

// Call the session timeout function on each page where session management is required
checkSessionTimeout();

