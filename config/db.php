<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'crud_028';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function clean($data) {
    global $conn; // biar bisa pakai mysqli_real_escape_string
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

?>


