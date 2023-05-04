<?php
// Start the session
session_start();

// Get the username and password from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Load the JSON file with the hashed passwords
$admins = json_decode(file_get_contents('/var/data/admins.json'), true);

// Check if the username exists
if (isset($admins[$username])) {
  // Get the hashed password and salt for this user
  $hash = $admins[$username]['hash'];
  $salt = $admins[$username]['salt'];

  // Hash the password with the salt
  $hashed_password = hash('sha256', $password . $salt);

  // Check if the hashed password matches the stored hash
  if ($hashed_password === $hash) {
    // Password is correct, so set the session variable
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    // Redirect the user to the admin page
    header('Location: admin.php');
    exit;
  }
}

// If we get to this point, the username or password is incorrect
$error = 'Incorrect username or password.';
header('Location: login.php?error=' . urlencode($error));
exit;
?>
