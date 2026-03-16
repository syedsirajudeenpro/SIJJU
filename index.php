<?php 
// 1. Core Config and Security Lock
include_once('config.php'); 

// Allow both login AND register pages without being logged in
$allowed_pages = ['login', 'register'];
$current_page = $_GET['page'] ?? 'dashboard';

if (!isset($_SESSION['user_id']) && !in_array($current_page, $allowed_pages)) {
    header("Location: index.php?page=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPulse</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="dark-mode">

    <div class="sidebar" style="width: 250px; position: fixed; height: 100%; background: #1a1a1a; padding: 20px;">
        <h2 style="color: #4caf50;">StockPulse</h2>
        <hr style="border: 0.5px solid #333;">
        <ul style="list-style: none; padding: 0;">
            <li style="padding: 15px 0;"><a href="index.php?page=dashboard" style="color: white; text-decoration: none;">🏠 Dashboard</a></li>
            <li style="padding: 15px 0;"><a href="index.php?page=portfolio" style="color: white; text-decoration: none;">💼 Portfolio</a></li>
            <li style="padding: 15px 0;"><a href="index.php?page=trade" style="color: white; text-decoration: none;">💹 Trade Stocks</a></li>
            <li style="padding: 15px 0;"><a href="index.php?page=news" style="color: white; text-decoration: none;">📡 Market News</a></li>
            <li style="padding: 15px 0;"><a href="index.php?page=history" style="color: white; text-decoration: none;">📜 History</a></li>
            <li style="padding: 15px 0;"><a href="index.php?page=admin" style="color: white; text-decoration: none;">🛡️ Admin Panel</a></li>
            <hr style="border: 0.5px solid #333;">
            <li style="padding: 15px 0;"><a href="logout.php" style="color: #f44336; text-decoration: none;">🚪 Logout</a></li>
        </ul>

        <div style="position: absolute; bottom: 20px; left: 20px; color: #888; font-size: 12px;">
            Logged in as:<br>
            <span style="color: #4caf50; font-weight: bold;">
                <?php echo isset($_SESSION['user_id']) ? "User #" . $_SESSION['user_id'] : "Guest"; ?>
            </span>
        </div>
    </div>

    <div class="main-content" style="margin-left: 280px; padding: 40px;">
        <?php 
        $file = "modules/" . $current_page . ".php";
        
        if (file_exists($file)) {
            include($file);
        } else {
            echo "<h3>Module '$current_page' not found. Check your 'modules' folder!</h3>";
        }
        ?>
    </div>

</body>
</html>