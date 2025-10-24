<?php
require_once 'db.php';
require_once 'auth.php';

$user = current_user();
$result = $_SESSION['result'] ?? null;
$savedAt = null;

// If no session result, load latest from DB (when logged in)
if (!$result && $user) {
    $stmt = $conn->prepare("SELECT * FROM quiz_results WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $result = [
          'vata' => (int)$row['vata_count'],
          'pitta'=> (int)$row['pitta_count'],
          'kapha'=> (int)$row['kapha_count'],
          'dominant' => $row['dominant']
        ];
        $savedAt = $row['created_at'];
    }
}

// Tips (educational only)
$tips = [
  'Vata' => [
    'Favor warm, cooked, slightly oily foods; avoid skipping meals.',
    'Keep a steady daily routine; prioritize sleep and gentle yoga.',
    'Stay warm; try sesame or almond oil self-massage (abhyanga).',
  ],
  'Pitta' => [
    'Choose cooling foods (cucumber, mint, sweet fruits); avoid very spicy.',
    'Practice calming activities; avoid overheating in mid-day sun.',
    'Coconut oil head massage; hydrate well throughout the day.',
  ],
  'Kapha' => [
    'Go for light, warm, spiced foods; reduce sugar and heavy dairy.',
    'Daily brisk movement; add variety and wake up early.',
    'Favor dry heat, ginger tea; keep spaces decluttered.',
  ],
];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Your Result</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="nav">
    <a href="index.php">Home</a>
    <a href="mcq.php">Quiz</a>
    <a href="result.php" class="active">Results</a>
    <?php if ($user): ?>
      <span class="pill">Logged in as <?=htmlspecialchars($user['name'])?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </div>

  <div class="container">
    <div class="card" style="max-width:1100px;margin:0 auto;">
      <h2>Your Prakriti Result</h2>
      <p class="muted" style="margin-bottom:16px;">
        Educational overview of your dosha balance based on your quiz responses.
        <?php if ($savedAt): ?><br><span class="muted">Last saved: <?=htmlspecialchars($savedAt)?></span><?php endif; ?>
      </p>

      <?php if (!$result): ?>
        <div class="tip">
          <strong>No results yet.</strong> Take the quiz to see your analysis.
        </div>
        <div class="row" style="margin-top:16px;">
          <a class="btn" href="<?= $user ? 'mcq.php' : 'login.php?redirect=mcq.php' ?>">Take the Quiz</a>
        </div>
      <?php else: ?>
        <div class="result-grid" style="margin-top:14px;">
          <div class="card">
            <h3>Dosha Counts</h3>
            <div class="spacer"></div>
            <p>Vata: <strong><?= (int)$result['vata'] ?></strong></p>
            <p>Pitta: <strong><?= (int)$result['pitta'] ?></strong></p>
            <p>Kapha: <strong><?= (int)$result['kapha'] ?></strong></p>
            <div class="spacer"></div>
            <?php
              $domText = htmlspecialchars($result['dominant']);
              $first = explode(' & ', $result['dominant'])[0];
              $badgeBg = 'background: var(--accent); color:#071013;';
              if ($first === 'Pitta') $badgeBg = 'background: #f4a261; color:#071013;';
              if ($first === 'Kapha') $badgeBg = 'background: #89a3ff; color:#071013;';
            ?>
            <p>Dominant: <span class="pill" style="<?= $badgeBg ?> font-weight:800;"><?= $domText ?></span></p>
          </div>

          <div class="card">
            <h3>Lifestyle Tips</h3>
            <div class="tips">
              <?php
                $dominants = explode(' & ', $result['dominant']);
                foreach ($dominants as $d) {
                  $d = trim($d);
                  if (!isset($tips[$d])) continue;
                  echo "<div class='tip'><strong>" . htmlspecialchars($d) . " support:</strong><ul style='margin:8px 0 0 18px'>";
                  foreach ($tips[$d] as $t) echo "<li>" . htmlspecialchars($t) . "</li>";
                  echo "</ul></div>";
                }
              ?>
              <div class="tip">
                <strong>Note:</strong> This quiz is educational, not a medical diagnosis. For health concerns, consult a qualified professional.
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-top:18px;">
          <a class="btn" href="mcq.php?reset=1">Retake Quiz</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
