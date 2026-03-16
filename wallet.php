<?php
$uid = $_SESSION['user_id'];
$user = $conn->query("SELECT wallet_balance FROM users WHERE id = $uid")->fetch_assoc();
?>
<div class="card wallet-box">
    <h3>Wallet Balance</h3>
    <h1 style="color:var(--green)">₹ <?php echo number_format($user['wallet_balance'], 2); ?></h1>
    <form method="POST">
        <input type="number" name="amount" placeholder="Enter Amount" required>
        <button type="submit" name="add_money" class="btn-green">Add Funds</button>
    </form>
</div>