<?php
require_once 'conf.php';

if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];

    $mysqli = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email=? AND token=? AND verified=0");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // mark user as verified
        $stmt = $mysqli->prepare("UPDATE users SET verified=1 WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        echo "Your account has been verified! You can now log in.";
    } else {
        echo "Invalid or expired verification link.";
    }

    $stmt->close();
    $mysqli->close();
}
?>
