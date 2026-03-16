<?php
// 1. Database Connection Settings
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "stock_pulse";

$conn = new mysqli($host, $user, $pass, $dbname);

// 2. Check Connection - If this fails, it will tell you!
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// 3. Start Session & Debugging
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// TURN THIS ON to see errors if the page is blank
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('API_KEY', 'YOUR_FREE_API_KEY'); // Replace with your actual key later
?>