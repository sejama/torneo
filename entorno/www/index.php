<?php
echo "Testing a PHP Apache Docker Container";

$host = 'mysql-db';
$user = 'user';
$pass = 'pass';
$db = 'test_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<br>";
echo "Connected to MySQL successfully";

$conn->close();

?>