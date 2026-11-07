<?php
// Connect to Redis using its service NAME (from docker-compose), not an IP
$redis = new Redis();
$redis->connect('redis', 6379);

// If the form was submitted, save the message to the Redis list
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    if ($message !== '') {
        $redis->rPush('messages', $message);
    }
    // Redirect so refreshing the page doesn't send the message twice
    header('Location: /?sent=1');
    exit;
}

// Normal page load: count this visit (+1)
$visits = $redis->incr('visits');
$sent = isset($_GET['sent']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevOpsHub - Feedback</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fb; margin: 0;
               display: flex; justify-content: center; padding: 40px 16px; }
        .card { background: #fff; max-width: 480px; width: 100%; padding: 28px;
                border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.08); }
        h1 { margin-top: 0; color: #1d3557; }
        textarea { width: 100%; min-height: 120px; padding: 10px; font-size: 15px;
                   border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        button { margin-top: 12px; background: #1d3557; color: #fff; border: 0;
                 padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 15px; }
        .ok { background: #e6f4ea; color: #1e7b34; padding: 10px;
              border-radius: 8px; margin-bottom: 12px; }
        .visits { color: #666; font-size: 14px; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>DevOpsHub Feedback</h1>

        <?php if ($sent): ?>
            <div class="ok">Thanks! Your message was saved.</div>
        <?php endif; ?>

        <form method="POST">
            <textarea name="message" placeholder="Write your feedback..." required></textarea>
            <button type="submit">Send</button>
        </form>

        <p class="visits">This page has been visited <?= $visits ?> times.</p>
    </div>
</body>
</html>