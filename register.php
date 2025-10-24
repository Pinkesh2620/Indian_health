<?php
require_once 'db.php';
require_once 'auth.php';

if (current_user()) { header('Location: index.php'); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $pass === '') {
        $errors[] = 'All fields are required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email.';
    }

    if (!$errors) {
        // check duplicate email
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errors[] = 'Email already registered.';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hash);
            $insert->execute();

            $_SESSION['user'] = [
                'id' => $insert->insert_id,
                'name' => $name,
                'email' => $email
            ];
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Register</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="nav">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
    <a href="register.php" class="active">Register</a>
  </div>
  <div class="container">
    <div class="card">
      <h2>Create your account</h2>
      <?php if ($errors): ?>
        <div class="tip" style="border-color:#ffd1d1;background:#fff5f5; color:#000;">
          <strong>Fix the following:</strong>
          <ul><?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul>
        </div>
      <?php endif; ?>
      <form class="form" method="post">
        <div class="input">
          <label>Full name</label>
          <input type="text" name="name" required />
        </div>
        <div class="input">
          <label>Email</label>
          <input type="email" name="email" required />
        </div>
        <div class="input">
          <label>Password</label>
          <input type="password" name="password" required minlength="6" />
        </div>
        <button class="btn" type="submit">Register</button>
      </form>
    </div>
  </div>
</body>
</html>
