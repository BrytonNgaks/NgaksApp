<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

require_once 'ClassAutoLoad.php'; 
require_once 'conf.php';

$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);
$ObjLayouts->banner($conf); // optional, can leave empty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Getting form values
    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    // 2. Hash password
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT);

    // 3. Generate verification token
    $token = bin2hex(random_bytes(16));

    // 4. Connect to database
    $mysqli = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
    if ($mysqli->connect_error) {
        die("<div class='alert alert-danger'>Database connection failed: " . $mysqli->connect_error . "</div>");
    }

    // 4a. Check if email already exists
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        echo "<div class='alert alert-danger'>This email is already registered. Try logging in.</div>";
    } else {
        // Insert new user
        $stmt->close();
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, token, verified) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("ssss", $name, $email, $hashedPass, $token);
        $stmt->execute();

        // 5. Sending verification email
        $verifyLink = $conf['site_url'] . "/verify.php?token=$token&email=" . urlencode($email);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $conf['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $conf['smtp_user'];
            $mail->Password   = $conf['smtp_pass'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $conf['smtp_port'];

            $mail->setFrom($conf['smtp_user'], $conf['site_name']);
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = "Welcome to {$conf['site_name']}! Account Verification";
            $mail->Body    = "
                Hello $name,<br><br>
                You requested an account on {$conf['site_name']}.<br>
                In order to use this account you need to <a href='$verifyLink'>Click Here</a> to complete the registration process.<br><br>
                Regards,<br>
                Systems Admin<br>
                {$conf['site_name']}
            ";

            $mail->send();
            echo "<div class='alert alert-success'>Signup successful! Please check your email to verify your account.</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-warning'>Signup saved, but email could not be sent. Error: {$mail->ErrorInfo}</div>";
        }
    }

    $stmt->close();
    $mysqli->close();
}
?>

<?php $ObjLayouts->content($conf); ?>

<div class="container py-4">
    <h2>Signup Form</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Sign Up</button>
        <a href="index.php" class="btn btn-secondary">Go Back</a>
    </form>
</div>

<?php $ObjLayouts->footer($conf); ?>
