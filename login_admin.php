<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);
$ObjLayouts->banner($conf);
?>

<div class="container py-4">
    <h2>Admin Login</h2>
    <form method="post" action="submit_login_admin.php">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Login as Admin</button>
        <a href="login.php" class="btn btn-secondary">Go Back</a>
    </form>
</div>

<?php
$ObjLayouts->footer($conf);
?>
