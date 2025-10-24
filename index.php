<?php

require_once 'auth.php';
$user = current_user();

$startHref = $user ? 'mcq.php' : 'login.php?redirect=mcq.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Indian Health • Prakriti Assessment</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background: #0f1316;   
      color: #e6edf3;          
      line-height: 1.5;
    }

   
    .nav {
      position: sticky; top: 0;
      display: flex; gap: 10px; justify-content: flex-end; align-items: center;
      padding: 10px 16px;
      background: #1b2228;
      border-bottom: 1px solid #2c3238;
    }
    .nav a, .nav span {
      color: #e6edf3;
      text-decoration: none;
      padding: 6px 10px;
      border-radius: 8px;
    }
    .nav a.active, .nav a:hover {
      background: #283038;
    }
    .pill {
      background: #2b323a;
      color: #9ba8b4;
      font-weight: 600;
    }

  
    .hero {
      max-width: 800px;
      margin: 40px auto;
      padding: 24px;
      background: #1b2228;
      border: 1px solid #2c3238;
      border-radius: 12px;
      text-align: center;
    }
    .badge {
      display: inline-block;
      background: #2dd4bf;  
      color: #071013;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 12px;
    }
    h1 { margin: 12px 0; font-size: 28px; }
    .muted { color: #9ba8b4; }

   
    .btn {
      display: inline-block;
      padding: 10px 16px;
      border-radius: 10px;
      border: none;
      text-decoration: none;
      cursor: pointer;
      font-weight: 600;
      margin: 6px;
    }
    .btn-primary {
      background: #2dd4bf; color: #071013;
    }
    .btn-primary:hover { background: #1b9b8a; color: #ffffff; }
    .btn-secondary {
      background: #f4a261; color: #071013;
    }
    .btn-ghost {
      background: transparent; color: #e6edf3; border: 1px solid #394046;
    }

    
    .stats {
      display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;
      margin-top: 16px;
    }
    .stat {
      min-width: 120px; text-align: center;
      background: #1c242a; border: 1px solid #2c3238; border-radius: 10px;
      padding: 10px;
    }
  </style>
</head>
<body>


  <div class="nav">
    <a href="index.php" class="active">Home</a>
    <a href="result.php">Results</a>

    <?php if ($user): ?>
      <span class="pill">Hello, <?= htmlspecialchars($user['name']) ?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </div>

 
  <main class="hero">
    <span class="badge">🌿 Ayurveda • Prakriti</span>
    <h1>Know Your Balance. Live Your Best.</h1>
    <p class="muted">
      Find your dominant dosha — <strong>Vata</strong>, <strong>Pitta</strong>, or <strong>Kapha</strong> — with a quick MCQ quiz.
      Get instant lifestyle tips based on your result.
    </p>

    <div>
      <a class="btn btn-primary" href="<?= htmlspecialchars($startHref) ?>">Start Quiz</a>

      <?php if ($user): ?>
        <a class="btn btn-secondary" href="result.php">View Past Results</a>
      <?php else: ?>
        <a class="btn btn-ghost" href="register.php">Create Account</a>
      <?php endif; ?>
    </div>

    <div class="stats">
      <div class="stat">
        <div class="muted">Questions</div>
        <div style="font-weight:800; font-size:18px;">12</div>
      </div>
      <div class="stat">
        <div class="muted">Time</div>
        <div style="font-weight:800; font-size:18px;">~3 min</div>
      </div>
      <div class="stat">
        <div class="muted">Cost</div>
        <div style="font-weight:800; font-size:18px;">Free</div>
      </div>
    </div>
  </main>

</body>
</html>
