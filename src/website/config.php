<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // If the user is not logged in
// redirect them to the login page
    header('Location: login.php');
    exit;
}


// Read the config file
$config_file = '/var/data/config.json';
$config_data = file_get_contents($config_file);
$config = json_decode($config_data, true);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Update the config data with the form values
  $config['title'] = $_POST['title'];
  $config['subtitle'] = $_POST['subtitle'];
  $config['important_message'] = $_POST['important_message'];

  // Save the updated config file
  $config_data = json_encode($config, JSON_PRETTY_PRINT);
  file_put_contents($config_file, $config_data);

  // Redirect back to the form to show the updated values
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Config Editor</title>
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

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    h1 {
    text-align: center;
    margin-top: 50px;
    }

    form {
    max-width: 500px;
    margin: 0 auto;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    }

    label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    }

    input[type="text"],
    textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
    margin-bottom: 20px;
    box-sizing: border-box;
    }

    input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;
    }

    input[type="submit"]:hover {
    background-color: #3e8e41;
    }

    /* Align the fields in two columns */
    .form-group {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-bottom: 20px;
    }

    .form-group label {
    flex: 1;
    }

    .form-group input[type="text"],
    .form-group textarea {
    flex: 3;
    margin-left: 10px;
    box-sizing: border-box;
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
        <a href="top5.php">Top 5</a>
        <a href="top10.php">Top 10</a>
        <a href="admin.php">Admin</a>
        <a href="adduser.php">Add User</a>
        <a href="modifyuser.php">Modify User</a>
        <a href="config.php">Configuration</a>
        </nav>
        <div class="top-right">
            <a href="logout.php">Logout</a>
            <a href="change-password.php">Change Password</a>
        </div>
    </header>
<main>
  <h1>Config Editor</h1>
  <form method="post">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $config['title']; ?>">
    <label>Subtitle:</label>
    <input type="text" name="subtitle" value="<?php echo $config['subtitle']; ?>">
    <label>Important Message:</label>
    <textarea name="important_message"><?php echo $config['important_message']; ?></textarea>
    <input type="submit" value="Save">
  </form>
</main>
</body>
</html>
