<?php
session_start();
include ("conn.php");
if(!$_SESSION["user_email"]) {
    header("location: login.html");
}
// Get user input from form
$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query(query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Start session and set session variables
        $_SESSION['user_email'] = $row['email'];
        // Redirect to home page
        header("Location: index.html");
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "No user found with the specified email.";
}

// Close connection
$conn->close();
?>
