<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role, wallet_balance FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // In a real app, use password_verify. For now, we check the string.
        if ($pass == $user['password'] || password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['wallet'] = $user['wallet_balance'];
            header("Location: index.php?page=dashboard");
        } else {
            echo "<p style='color:red;'>Invalid Password!</p>";
        }
    } else {
        echo "<p style='color:red;'>User not found!</p>";
    }
}
?>

<div class="login-box" style="max-width: 400px; margin: 100px auto; background: #1e1e1e; padding: 30px; border-radius: 10px;">
    <h2>Login to StockPulse</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required style="width: 100%; padding: 10px; margin: 10px 0;">
        <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 10px; margin: 10px 0;">
        <button type="submit" name="login" style="width: 100%; padding: 10px; background: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer;">Enter Dashboard</button>
    </form>
    <p style="font-size: 12px; color: #888; margin-top: 15px;">Default Admin: admin@stockpulse.com / admin123</p>
</div>