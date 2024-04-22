<?php
session_start();
include("conn.php");
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check if email already exists
$query = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo "An account with this email already exists.";
} else {
    // Insert user data into the database
    $query = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
    if ($conn->query($query) === TRUE) {
        // Start session and set session variables
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_email'] = $email;
        // Redirect to home page
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
