<?php
include('config.php');
for ($i = 1; $i <= 5; $i++) {
    $email = "user" . rand(100, 999) . "@test.com";
    $pass = password_hash("password123", PASSWORD_DEFAULT);
    $wallet = rand(5000, 20000);
    $conn->query("INSERT INTO users (email, password, wallet_balance) VALUES ('$email', '$pass', $wallet)");
    echo "Created: $email with ₹$wallet <br>";
}
?>