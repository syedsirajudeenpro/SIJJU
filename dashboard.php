<?php
$uid = $_SESSION['user_id'];

// Handle the Buy Transaction
if (isset($_POST['buy_stock'])) {
    $symbol = $_POST['symbol'];
    $qty = (int)$_POST['qty'];
    $price = (float)$_POST['price'];
    $total_cost = $qty * $price;

    // 1. Check if user has enough money in wallet
    $user_data = $conn->query("SELECT wallet_balance FROM users WHERE id = $uid")->fetch_assoc();
    
    if ($user_data['wallet_balance'] >= $total_cost) {
        // 2. Subtract money from wallet
        $conn->query("UPDATE users SET wallet_balance = wallet_balance - $total_cost WHERE id = $uid");

        // 3. Add to portfolio
        $conn->query("INSERT INTO portfolio (user_id, symbol, quantity, buy_price) VALUES ($uid, '$symbol', $qty, $price)");
        
        echo "<script>alert('Purchase Successful! Check your Portfolio.');</script>";
    } else {
        echo "<script>alert('Insufficient Balance in Wallet!');</script>";
    }
}

$stocks = $conn->query("SELECT * FROM stocks LIMIT 50");
?>

<div class="card">
    <h3>Available Stocks to Invest</h3>
    <table>
        <tr><th>Company</th><th>Price (Live)</th><th>Action</th></tr>
        <?php while($s = $stocks->fetch_assoc()): 
            $live_price = rand(500, 3000); // Simulated real-time price
        ?>
        <tr>
            <td><strong><?php echo $s['symbol']; ?></strong><br><small><?php echo $s['company_name']; ?></small></td>
            <td style="color:var(--green);">₹<?php echo number_format($live_price, 2); ?></td>
            <td>
                <form method="POST" style="display:flex; gap:5px;">
                    <input type="hidden" name="symbol" value="<?php echo $s['symbol']; ?>">
                    <input type="hidden" name="price" value="<?php echo $live_price; ?>">
                    <input type="number" name="qty" value="1" min="1" style="width:50px;">
                    <button type="submit" name="buy_stock" class="btn-green">Buy</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>