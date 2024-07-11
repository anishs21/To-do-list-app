<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "To_do_list_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>