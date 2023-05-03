<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
  </head>
  <body>
    <?php
      // Handle logging in
      if (isset($_POST['username']) && isset($_POST['password'])) {
        $hashed = file_get_contents('.env');
        $salt = file_get_contents('salt.txt');
        $hash = hash('sha256', $salt . $_POST['password']);
        if ($hash === $hashed) { 
          session_start();
          $_SESSION['loggedin'] = true;
          header('Location: admin.php');
          exit;
        } else {
          echo 'Invalid username or password';
        }
      }
    ?>

    <h1>Login Page</h1>

    <form method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <br>
      <label for="password">Password:</label>
      <input type="password" name="password" required>
      <br>
      <input type="submit" value="Log In">
    </form>
  </body>
</html>
