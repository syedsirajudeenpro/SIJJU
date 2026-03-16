<?php
// Prevent direct access to this file
if (!isset($conn)) { die("Direct access not allowed."); }

// Mock data for your StockPulse chart (we can connect this to an API later!)
$stock_labels = ["Apple", "Google", "Microsoft", "Amazon", "Tesla"];
$stock_prices = [175.50, 142.10, 405.20, 178.30, 165.10];
?>

<div class="dashboard-container">
    <h2>Welcome to StockPulse Dashboard 📊</h2>
    
    <div class="stats-grid" style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div class="stat-card" style="padding: 20px; background: #2c2c2c; border-radius: 8px; flex: 1;">
            <h4>Wallet Balance</h4>
            <p style="font-size: 24px; color: #4caf50;">$<?php echo number_format($_SESSION['wallet'] ?? 100000, 2); ?></p>
        </div>
        <div class="stat-card" style="padding: 20px; background: #2c2c2c; border-radius: 8px; flex: 1;">
            <h4>Active Stocks</h4>
            <p style="font-size: 24px;">12</p>
        </div>
    </div>

    <div style="background: #1e1e1e; padding: 20px; border-radius: 10px;">
        <canvas id="stockChart"></canvas>
    </div>
</div>

<script>
const ctx = document.getElementById('stockChart').getContext('2d');
const stockChart = new Chart(ctx, {
    type: 'bar', // You can change this to 'line' or 'pie'
    data: {
        labels: <?php echo json_encode($stock_labels); ?>,
        datasets: [{
            label: 'Current Stock Prices ($)',
            data: <?php echo json_encode($stock_prices); ?>,
            backgroundColor: 'rgba(76, 175, 80, 0.6)',
            borderColor: 'rgba(76, 175, 80, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true, grid: { color: '#444' } },
            x: { grid: { color: '#444' } }
        },
        plugins: {
            legend: { labels: { color: '#fff' } }
        }
    }
});
</script>