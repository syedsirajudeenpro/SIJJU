<?php
if (!isset($conn)) { die("Direct access not allowed."); }

$user_id = $_SESSION['user_id'] ?? 1;

if (isset($_POST['buy_stock'])) {
    $stock_id = $_POST['stock_id'];
    $qty = (int)$_POST['qty'];
    
    // 1. Get stock price and user wallet
    $stock_data = $conn->query("SELECT current_price FROM stocks WHERE id = $stock_id")->fetch_assoc();
    $user_data = $conn->query("SELECT wallet_balance FROM users WHERE id = $user_id")->fetch_assoc();
    
    $total_cost = $stock_data['current_price'] * $qty;

    if ($user_data['wallet_balance'] >= $total_cost) {
        // 2. Deduct money
        $conn->query("UPDATE users SET wallet_balance = wallet_balance - $total_cost WHERE id = $user_id");
        
        // 3. Add to portfolio (Simplified: adds a new row for every trade)
        $price = $stock_data['current_price'];
        $conn->query("INSERT INTO portfolio (user_id, stock_id, quantity, buy_price) VALUES ($user_id, $stock_id, $qty, $price)");
        
        echo "<p style='color: #4caf50;'>🚀 Trade Successful! Check your Portfolio.</p>";
    } else {
        echo "<p style='color: #f44336;'>❌ Insufficient Funds!</p>";
    }
}
?>

<div class="trade-panel">
    <h3>Market Terminal 💹</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
        <?php
        $stocks = $conn->query("SELECT * FROM stocks");
        while($s = $stocks->fetch_assoc()): ?>
            <div style="background: #1e1e1e; padding: 15px; border-radius: 8px; border: 1px solid #333;">
                <h4><?php echo $s['symbol']; ?></h4>
                <p>Price: $<?php echo $s['current_price']; ?></p>
                <form method="POST">
                    <input type="hidden" name="stock_id" value="<?php echo $s['id']; ?>">
                    <input type="number" name="qty" value="1" min="1" style="width: 50px; padding: 5px;">
                    <button type="submit" name="buy_stock" style="background: #4caf50; color: white; border: none; padding: 5px 10px; cursor: pointer;">Buy</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>