<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

// Use your layouts object
$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);
$ObjLayouts->banner($conf); // optional, can leave empty

// Connect to the database
$mysqli = new mysqli($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']);
if ($mysqli->connect_error) {
    die("<div class='alert alert-danger'>Database connection failed: " . $mysqli->connect_error . "</div>");
}

// Fetch users sorted by name ascending
$result = $mysqli->query("SELECT name, email FROM users ORDER BY name ASC");
if (!$result) {
    die("<div class='alert alert-danger'>Query failed: " . $mysqli->error . "</div>");
}

echo "<div class='container py-4'>";
echo "<h2 class='mb-4'>Registered Users</h2>";

// Display users in numbered boxes
$counter = 1;
echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3'>"; // responsive grid
while ($row = $result->fetch_assoc()) {
    echo "<div class='col'>";
    echo "<div class='card shadow-sm p-3'>";
    echo "<h5>" . $counter . ". " . htmlspecialchars($row['name']) . "</h5>";
    echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
    echo "</div>"; // card
    echo "</div>"; // col
    $counter++;
}
echo "</div>"; // row
echo "</div>"; // container

$mysqli->close();

$ObjLayouts->footer($conf);
?>
