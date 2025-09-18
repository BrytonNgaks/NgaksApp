<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);
$ObjLayouts->banner($conf); // optional

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Connect to database
    $mysqli = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);

    if ($mysqli->connect_error) {
        die("<div class='alert alert-danger'>Connection failed: " . $mysqli->connect_error . "</div>");
    }

    // Check if email exists
    $stmt = $mysqli->prepare("SELECT password, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPass, $name);
        $stmt->fetch();

        if (password_verify($password, $hashedPass)) {
            echo "<div class='alert alert-success'>Login successful! Welcome, $name.</div>";
            echo "<a href='index.php' class='btn btn-secondary'>Go to Home</a>";
        } else {
            echo "<div class='alert alert-danger'>Incorrect password.</div>";
            echo "<a href='login.php' class='btn btn-secondary'>Try Again</a>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email not found.</div>";
        echo "<a href='login.php' class='btn btn-secondary'>Try Again</a>";
    }

    $stmt->close();
    $mysqli->close();
}

$ObjLayouts->content($conf);
$ObjLayouts->footer($conf);
?>
