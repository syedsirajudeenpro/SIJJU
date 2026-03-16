<?php
$uid = $_SESSION['user_id'];

// Search Logic
$search_query = "";
if (isset($_POST['search_term'])) {
    $search_term = $conn->real_escape_string($_POST['search_term']);
    $search_query = " WHERE symbol LIKE '%$search_term%' OR company_name LIKE '%$search_term%'";
}

$stocks = $conn->query("SELECT * FROM stocks $search_query LIMIT 30");
?>

<div class="container">
    <div class="header-section" style="margin-bottom: 30px;">
        <h2>Search Stocks</h2>
        <p style="color: #94a3b8;">Search any listed company by name, symbol, or sector</p>
    </div>

    <div class="card" style="margin-bottom: 30px;">
        <form method="POST" style="display: flex; gap: 15px;">
            <input type="text" name="search_term" placeholder="🔍 Search by stock name, symbol, or sector..." 
                   style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--border); background: #0b0e11; color: white;">
            <button type="submit" class="btn-green" style="padding: 0 30px;">Search</button>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <?php if ($stocks->num_rows > 0): ?>
            <?php while($s = $stocks->fetch_assoc()): 
                $sim_price = rand(100, 5000); // Simulated price for display
            ?>
            <div class="card" style="transition: 0.3s; cursor: pointer;" onmouseover="this.style.borderColor='var(--green)'" onmouseout="this.style.borderColor='var(--border)'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <span style="background: #334155; padding: 2px 8px; border-radius: 4px; font-size: 10px;"><?php echo $s['sector']; ?></span>
                        <h3 style="margin: 10px 0 5px 0;"><?php echo $s['symbol']; ?></h3>
                        <small style="color: #94a3b8;"><?php echo $s['company_name']; ?></small>
                    </div>
                    <div style="text-align: right;">
                        <h3 style="margin: 0; color: var(--green);">₹<?php echo number_