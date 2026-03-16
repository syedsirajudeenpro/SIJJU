<?php
if (!isset($conn)) { die("Direct access not allowed."); }

$user_id = $_SESSION['user_id'] ?? 1;

// Fetch transaction history
$query = "SELECT h.*, s.symbol 
          FROM portfolio h 
          JOIN stocks s ON h.stock_id = s.id 
          WHERE h.user_id = $user_id 
          ORDER BY h.id DESC";
$result = $conn->query($query);
?>

<div class="history-container">
    <h3>Transaction History 📜</h3>
    <p style="color: #888;">A record of all your stock purchases.</p>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #1e1e1e; border-radius: 8px;">
        <thead>
            <tr style="background: #333; text-align: left;">
                <th style="padding: 15px;">Stock</th>
                <th style="padding: 15px;">Quantity</th>
                <th style="padding: 15px;">Price at Purchase</th>
                <th style="padding: 15px;">Total Investment</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #333;">
                    <td style="padding: 15px; font-weight: bold; color: #4caf50;"><?php echo $row['symbol']; ?></td>
                    <td style="padding: 15px;"><?php echo $row['quantity']; ?></td>
                    <td style="padding: 15px;">$<?php echo number_format($row['buy_price'], 2); ?></td>
                    <td style="padding: 15px;">$<?php echo number_format($row['quantity'] * $row['buy_price'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="padding: 20px; text-align: center;">No transactions found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>