<?php
// Prevent direct access
if (!isset($conn)) { die("Direct access not allowed."); }

$user_id = $_SESSION['user_id'] ?? 1; // Default to 1 for testing

// Fetch user's portfolio from the database
$query = "SELECT p.*, s.stock_name, s.current_price 
          FROM portfolio p 
          JOIN stocks s ON p.stock_id = s.id 
          WHERE p.user_id = $user_id";
$result = $conn->query($query);
?>

<div class="portfolio-container">
    <h3>Your Investment Portfolio 📁</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #1e1e1e; border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background: #333; text-align: left;">
                <th style="padding: 15px;">Stock Name</th>
                <th style="padding: 15px;">Quantity</th>
                <th style="padding: 15px;">Buy Price</th>
                <th style="padding: 15px;">Current Value</th>
                <th style="padding: 15px;">Profit/Loss</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): 
                    $current_total = $row['quantity'] * $row['current_price'];
                    $buy_total = $row['quantity'] * $row['buy_price'];
                    $pl = $current_total - $buy_total;
                    $pl_color = ($pl >= 0) ? "#4caf50" : "#f44336";
                ?>
                <tr style="border-bottom: 1px solid #333;">
                    <td style="padding: 15px;"><?php echo $row['stock_name']; ?></td>
                    <td style="padding: 15px;"><?php echo $row['quantity']; ?></td>
                    <td style="padding: 15px;">$<?php echo number_format($row['buy_price'], 2); ?></td>
                    <td style="padding: 15px;">$<?php echo number_format($current_total, 2); ?></td>
                    <td style="padding: 15px; color: <?php echo $pl_color; ?>;">
                        <?php echo ($pl >= 0 ? "+" : "") . number_format($pl, 2); ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="padding: 30px; text-align: center; color: #888;">No stocks found. Start trading!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>