<?php
// Connect to Redis using its service NAME from docker-compose (not an IP)
$redis = new Redis();
$redis->connect('redis', 6379);

// Read the data that App 1 writes
$totalMessages = $redis->lLen('messages');
$totalVisits   = (int) $redis->get('visits');
$latest = array_reverse($redis->lRange('messages', -5, -1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevOpsHub - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fb;
               margin: 0; padding: 40px 16px; }
        .wrap { max-width: 640px; margin: 0 auto; }
        h1 { color: #1d3557; }
        .stats { display: flex; gap: 16px; flex-wrap: wrap; }
        .card { flex: 1; min-width: 200px; background: #fff; padding: 24px;
                border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.08); }
        .num { font-size: 40px; font-weight: bold; color: #1d3557; }
        .label { color: #666; }
        .latest { margin-top: 16px; }
        .latest li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>DevOpsHub Dashboard</h1>

        <div class="stats">
            <div class="card">
                <div class="num"><?= $totalMessages ?></div>
                <div class="label">Messages collected</div>
            </div>
            <div class="card">
                <div class="num"><?= $totalVisits ?></div>
                <div class="label">Visits to the message page</div>
            </div>
        </div>

        <div class="card latest">
            <h2>Latest messages</h2>
            <?php if (empty($latest)): ?>
                <p>No messages yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($latest as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>