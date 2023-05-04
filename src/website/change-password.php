<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // User is not logged in, so redirect to the login page
  header('Location: login.php');
  exit;
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <style>
    nav {
      background-color: #333;
      overflow: hidden;
    }
    nav a {
      float: left;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }
    nav a:hover {
      background-color: #ddd;
      color: black;
    }


    .password-form {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button[type="submit"] {
      display: block;
      margin: 20px auto 0;
      padding: 10px 20px;
      font-size: 18px;
      font-weight: bold;
      color: #fff;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #0062cc;
    }

    .top-right {
    position: absolute;
    top: 0;
    right: 0;
    }

    .top-right a {
    float: right;
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    }

    .top-right a:hover {
    background-color: #111;
    }

  </style>
</head>
<body>
<header>
        <nav>
        <a href="index.php">Scoreboard</a>
        <a href="admin.php">Admin</a>
        <a href="adduser.php">Add User</a>
        <a href="modifyuser.php">Modify User</a>
        </nav>
    </header>
  <main>
  <h1>Change Password</h1>

  <?php
  

  // If the form has been submitted, process the password change
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the old password, new password, and confirm password from the form
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Load the JSON file with the hashed passwords
    $admins = json_decode(file_get_contents('/var/data/admins.json'), true);

    // Get the username of the logged-in user
    $username = $_SESSION['username'];

    // Get the hashed password and salt for this user
    $hash = $admins[$username]['hash'];
    $salt = $admins[$username]['salt'];

    // Hash the old password with the salt
    $old_hashed_password = hash('sha256', $old_password . $salt);

    // Check if the old password is correct
    if ($old_hashed_password !== $hash) {
      $error = 'Old password is incorrect.';
    }
    // Check if the new password and confirm password match
    else if ($new_password !== $confirm_password) {
      $error = 'New password and confirm password do not match.';
    }
    // Update the password if everything checks out
    else {
      // Hash the new password with a new salt
      $new_salt = bin2hex(random_bytes(16));
      $new_hashed_password = hash('sha256', $new_password . $new_salt);

      // Update the hashed password and salt for this user in the JSON file
      $admins[$username]['hash'] = $new_hashed_password;
      $admins[$username]['salt'] = $new_salt;

      // Write the updated JSON file back to disk
      file_put_contents('/var/data/admins.json', json_encode($admins));

      // Set a success message and redirect back to the admin page
      $success = 'Password changed successfully.';
      header('Location: admin.php?success=' . urlencode($success));
      exit;
    }
  }
  ?>

  <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>

  <?php if (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
  <?php endif; ?>

  <form class="password-form" method="post">
  <div class="form-group">
    <label for="old_password">Old Password:</label>
    <input type="password" id="old_password" name="old_password" class="form-control">
  </div>

  <div class="form-group">
    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password" class="form-control">
  </div>

  <div class="form-group">
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary">Change Password</button>
</form>
<div class="top-right">
    <a href="logout.php">Logout</a>
    <a href="change-password.php">Change Password</a>
  </div>
  </main>
</body>
</html>
