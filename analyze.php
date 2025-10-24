<?php
require_once 'db.php';
require_once 'auth.php';

if (!isset($_SESSION['answers']) || !is_array($_SESSION['answers']) || !$_SESSION['answers']) {
    header('Location: mcq.php');
    exit;
}

$answers = $_SESSION['answers']; // values are 'Vata'/'Pitta'/'Kapha'
$vata = $pitta = $kapha = 0;

foreach ($answers as $a) {
    if ($a === 'Vata')  $vata++;
    if ($a === 'Pitta') $pitta++;
    if ($a === 'Kapha') $kapha++;
}

$max = max($vata, $pitta, $kapha);
$dominants = [];
if ($vata === $max)  $dominants[] = 'Vata';
if ($pitta === $max) $dominants[] = 'Pitta';
if ($kapha === $max) $dominants[] = 'Kapha';
$dominant = implode(' & ', $dominants);

// Save if logged in
$user = current_user();
if ($user) {
    $answersJson = json_encode($answers, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

    $stmt = $conn->prepare("
        INSERT INTO quiz_results (user_id, vata_count, pitta_count, kapha_count, dominant, answers_json)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iiiiss", $user['id'], $vata, $pitta, $kapha, $dominant, $answersJson);
    $stmt->execute();

    $_SESSION['last_result_id'] = $conn->insert_id;
}

// Store result in session for immediate view
$_SESSION['result'] = [
  'vata' => $vata,
  'pitta' => $pitta,
  'kapha' => $kapha,
  'dominant' => $dominant
];

// Reset quiz progress
unset($_SESSION['current_question']);

header('Location: result.php');
exit;
