<?php
if (!isset($conn)) { die("Direct access not allowed."); }

// For your project, these can be hardcoded or fetched from an API like NewsAPI
$news_items = [
    ["title" => "Tech Stocks Rally as AI Demand Surges", "time" => "2h ago", "category" => "Tech"],
    ["title" => "Federal Reserve Hints at Potential Rate Cuts", "time" => "5h ago", "category" => "Economy"],
    ["title" => "Oil Prices Steady Amid Global Supply Shifts", "time" => "8h ago", "category" => "Energy"],
    ["title" => "Market Watch: Apple Hits New 52-Week High", "time" => "10h ago", "category" => "Stocks"]
];
?>

<div class="news-container">
    <h3>Market News Feed 📡</h3>
    <div class="news-list" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
        <?php foreach ($news_items as $news): ?>
            <div class="news-card" style="background: #1e1e1e; padding: 15px; border-radius: 8px; border-left: 4px solid #4caf50;">
                <span style="font-size: 10px; color: #888; text-transform: uppercase;"><?php echo $news['category']; ?> • <?php echo $news['time']; ?></span>
                <h4 style="margin: 5px 0; color: #fff;"><?php echo $news['title']; ?></h4>
                <a href="#" style="color: #4caf50; font-size: 12px; text-decoration: none;">Read More →</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>