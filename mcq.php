<?php
require_once 'auth.php';
require_login(); // must be logged in to take quiz

// Define questions with dosha mapping
if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = [
        "What is your skin type?" => ["dry" => "Vata", "oily" => "Pitta", "balanced" => "Kapha"],
        "What is your body frame?" => ["thin" => "Vata", "muscular" => "Pitta", "heavy" => "Kapha"],
        "What is your hair type?" => ["dry" => "Vata", "oily" => "Pitta", "thick" => "Kapha", "thin" => "Vata"],
        "What are your eye features?" => ["small_dull" => "Vata", "medium_sharp" => "Pitta", "large_bright" => "Kapha"],
        "How is your general mindset?" => ["restless" => "Vata", "intense" => "Pitta", "calm" => "Kapha"],
        "How is your memory?" => ["forgetful" => "Vata", "sharp" => "Pitta", "stable" => "Kapha"],
        "What is your emotional tendency?" => ["anxiety" => "Vata", "anger" => "Pitta", "content" => "Kapha"],
        "What food do you prefer?" => ["light" => "Vata", "hot_spicy" => "Pitta", "sweet" => "Kapha"],
        "How is your sleep?" => ["trouble" => "Vata", "moderate" => "Pitta", "deep" => "Kapha"],
        "How is your energy level?" => ["fatigue" => "Vata", "energetic" => "Pitta", "balanced" => "Kapha"],
        "What weather do you prefer?" => ["warm" => "Vata", "cool" => "Pitta", "moderate" => "Kapha"],
        "How do you respond to stress?" => ["anxious" => "Vata", "irritable" => "Pitta", "calm" => "Kapha"]
    ];
}

$questions = $_SESSION['questions'];

if (!isset($_SESSION['current_question'])) {
    $_SESSION['current_question'] = 0;
    $_SESSION['answers'] = [];
}

if (isset($_GET['reset'])) {
    $_SESSION['current_question'] = 0;
    $_SESSION['answers'] = [];
    header('Location: mcq.php');
    exit;
}

$currentQuestion = $_SESSION['current_question'];
$questionKeys = array_keys($questions);
$totalQuestions = count($questions);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['answer'])) {
    $_SESSION['answers']["q{$currentQuestion}"] = $_POST['answer']; // Vata/Pitta/Kapha value
    $_SESSION['current_question']++;

    if ($_SESSION['current_question'] >= $totalQuestions) {
        header("Location: analyze.php");
        exit();
    } else {
        $currentQuestion = $_SESSION['current_question'];
    }
}

$questionText = $questionKeys[$currentQuestion];
$options = $questions[$questionText];
$progressPct = (($currentQuestion) / $totalQuestions) * 100;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Prakriti Quiz</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="nav">
    <a href="index.php">Home</a>
    <a href="mcq.php" class="active">Quiz</a>
    <a href="result.php">Results</a>
    <span class="pill">Logged in</span>
    <a href="logout.php">Logout</a>
  </div>

  <div class="container">
    <div class="card" style="max-width:720px;margin:0 auto;">
      <h2>Question <?=($currentQuestion + 1)?> of <?=$totalQuestions?></h2>
      <div class="progress"><div style="width: <?=round($progressPct)?>%;"></div></div>
      <p><strong><?=htmlspecialchars($questionText)?></strong></p>

      <form method="POST" action="mcq.php">
        <?php foreach ($options as $key => $dosha): ?>
          <label class="quiz-option">
            <input type="radio" name="answer" value="<?=htmlspecialchars($dosha)?>" required />
            <span><?=ucfirst(str_replace("_", " ", htmlspecialchars($key)))?></span>
          </label>
        <?php endforeach; ?>
        <div class="row" style="margin-top:8px;">
          <button class="btn" type="submit"><?=($currentQuestion == $totalQuestions - 1) ? "Submit" : "Next";?></button>
          <a class="btn ghost" href="mcq.php?reset=1">Reset</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
