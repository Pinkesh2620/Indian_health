<?php
require_once 'db.php';
require_once 'auth.php';

if (current_user()) { header('Location: index.php'); exit; }

$error = null;
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $redirect = $_POST['redirect'] ?? 'index.php';

    $stmt = $conn->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if (password_verify($pass, $row['password_hash'])) {
            $_SESSION['user'] = ['id'=>$row['id'], 'name'=>$row['name'], 'email'=>$row['email']];
            header('Location: ' . $redirect);
            exit;
        }
    }
    $error = 'Invalid credentials.';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Login</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="nav">
    <a href="index.php">Home</a>
    <a href="login.php" class="active">Login</a>
    <a href="register.php">Register</a>
  </div>
  <div class="container">
    <div class="card">
      <h2>Welcome back</h2>
      <?php if ($error): ?>
        <div class="tip" style="border-color:#ffd1d1;background:#fff5f5; color:#000;">
          <?=htmlspecialchars($error)?>
        </div>
      <?php endif; ?>
      <form class="form" method="post">
        <input type="hidden" name="redirect" value="<?=htmlspecialchars($redirect)?>" />
        <div class="input">
          <label>Email</label>
          <input type="email" name="email" required />
        </div>
        <div class="input">
          <label>Password</label>
          <input type="password" name="password" required />
        </div>
        <button class="btn" type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
