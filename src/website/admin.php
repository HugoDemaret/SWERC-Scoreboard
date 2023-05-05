<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // If the user is not logged in
// redirect them to the login page
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Page</title>
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

    .active {
    background-color: #4CAF50;
    }

    .buttons {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }

    .add-user, .modify-user {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px;
    cursor: pointer;
    border-radius: 5px;
    }

    .add-user:hover, .modify-user:hover {
    background-color: #3e8e41;
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
    </header>
    <main>
    
  <h1>Administration Page</h1>
  <p>Logged in as: <?php echo $_SESSION['username']; ?></p>

  <div class="buttons">
    <button class="add-user"><a href="adduser.php">Add User</a></button>
    <button class="modify-user"><a href="modifyuser.php">Modify User</a></button>
  </div>

  <div class="top-right">
    <a href="logout.php">Logout</a>
    <a href="change-password.php">Change Password</a>
  </div>
</main>
 
</body>
</html>