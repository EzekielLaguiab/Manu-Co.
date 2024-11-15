<?php
$servername = "	sql111.infinityfree.com";
$username = "	if0_37668462";
$password = "Manuscraft13";
$dbname = "if0_37668462_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}