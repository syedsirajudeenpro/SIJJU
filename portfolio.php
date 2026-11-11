<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Make sure this file is only used within a PHP page that has a DB connection.
if (!isset($conn) || !$conn instanceof mysqli) {
    die("Database connection not initialized.");
}

$user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 1;

// Fetch user's portfolio safely using prepared statements
$stmt = $conn->prepare("SELECT p.*, s.stock_name, s.current_price 
                        FROM portfolio p
                        JOIN stocks s ON p.stock_id = s.id
                        WHERE p.user_id = ?");

if (!$stmt) {
    die("Failed to prepare portfolio query: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="portfolio-container">
    <h3>Your Investment Portfolio 📁</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #1e1e1e; border-radius: 8px; overflow: hidden; color: #fff;">
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
                <?php while ($row = $result->fetch_assoc()): 
                    $current_total = $row['quantity'] * $row['current_price'];
                    $buy_total = $row['quantity'] * $row['buy_price'];
                    $pl = $current_total - $buy_total;
                    $pl_color = ($pl >= 0) ? "#4caf50" : "#f44336";
                ?>
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 15px;"><?php echo htmlspecialchars($row['stock_name']); ?></td>
                        <td style="padding: 15px;"><?php echo (int) $row['quantity']; ?></td>
                        <td style="padding: 15px;">$<?php echo number_format((float) $row['buy_price'], 2); ?></td>
                        <td style="padding: 15px;">$<?php echo number_format((float) $current_total, 2); ?></td>
                        <td style="padding: 15px; color: <?php echo $pl_color; ?>; font-weight: 600;">
                            <?php echo ($pl >= 0 ? "+" : "") . number_format((float) $pl, 2); ?>
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
