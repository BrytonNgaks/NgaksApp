<?php
session_start();
require_once 'conf.php';  // DB config
require_once 'ClassAutoLoad.php'; // Optional, if needed

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        die("Please fill in all fields.");
    }

    // Connect to database
    $mysqli = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);

    if ($mysqli->connect_error) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    // Check if user exists
    $stmt = $mysqli->prepare("SELECT password, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword, $email);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Login success
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            // Redirect to home page or dashboard
            header("Location: index.php");
            exit;
        } else {
            echo "Incorrect password. <a href='login.php'>Go back</a>";
        }
    } else {
        echo "Username not found. <a href='login.php'>Go back</a>";
    }

    $stmt->close();
    $mysqli->close();
} else {
    // Not a POST request
    header("Location: login.php");
    exit;
}
?>
