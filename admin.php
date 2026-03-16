<?php
// Prevent direct access
if (!isset($conn)) { die("Direct access not allowed."); }

// Handle Form Submission to add a new stock
if (isset($_POST['add_stock'])) {
    $name = $_POST['s_name'];
    $sym = $_POST['s_symbol'];
    $price = $_POST['s_price'];

    $stmt = $conn->prepare("INSERT INTO stocks (stock_name, symbol, current_price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $sym, $price);
    
    if ($stmt->execute()) {
        echo "<p style='color: #4caf50;'>✅ Stock Added Successfully!</p>";
    } else {
        echo "<p style='color: #f44336;'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<div class="admin-panel">
    <h3>Admin Control: Manage Stocks 🛡️</h3>
    
    <form method="POST" style="background: #1e1e1e; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        <input type="text" name="s_name" placeholder="Stock Name (e.g. Nvidia)" required style="padding: 10px; margin-right: 10px;">
        <input type="text" name="s_symbol" placeholder="Symbol (NVDA)" required style="padding: 10px; margin-right: 10px;">
        <input type="number" step="0.01" name="s_price" placeholder="Price" required style="padding: 10px; margin-right: 10px;">
        <button type="submit" name="add_stock" style="padding: 10px 20px; background: #4caf50; color: white; border: none; cursor: pointer;">Add Stock</button>
    </form>

    <h4>Current Market Listings</h4>
    <div id="stock_list">
        <?php
        $res = $conn->query("SELECT * FROM stocks ORDER BY id DESC");
        while($s = $res->fetch_assoc()) {
            echo "<div style='padding: 10px; border-bottom: 1px solid #333;'>
                    <strong>{$s['symbol']}</strong> - {$s['stock_name']} | Price: \${$s['current_price']}
                  </div>";
        }
        ?>
    </div>
</div>