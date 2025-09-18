<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);
$ObjLayouts->banner($conf);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Connect to database
    $mysqli = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare statement to get admin info by email
    $stmt = $mysqli->prepare("SELECT password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbPassword);
        $stmt->fetch();

        // Plain text check
        if ($password === $dbPassword) {
            // Login successful, redirect to admin.php
            header("Location: admin.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Incorrect password.</div>";
            echo "<a href='login_admin.php' class='btn btn-primary'>Try Again</a>";
        }
    } else {
        echo "<div class='alert alert-danger'>Admin not found.</div>";
        echo "<a href='login_admin.php' class='btn btn-primary'>Try Again</a>";
    }

    $stmt->close();
    $mysqli->close();
}

$ObjLayouts->content($conf);
$ObjLayouts->footer($conf);
?>
