<?php
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing
    $wallet = 100000.00;

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo "<p style='color:red;'>Email already registered!</p>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, password, wallet_balance) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $email, $pass, $wallet);
        
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registration successful! <a href='index.php?page=login'>Login here</a></p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<div class="login-box" style="max-width: 400px; margin: 100px auto; background: #1e1e1e; padding: 30px; border-radius: 10px;">
    <h2>Join StockPulse 🚀</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required style="width: 100%; padding: 10px; margin: 10px 0;">
        <input type="password" name="password" placeholder="Create Password" required style="width: 100%; padding: 10px; margin: 10px 0;">
        <button type="submit" name="register" style="width: 100%; padding: 10px; background: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer;">Create Account</button>
    </form>
    <p style="font-size: 14px; color: #888; margin-top: 15px;">Already have an account? <a href="index.php?page=login" style="color:#4caf50;">Login</a></p>
</div>