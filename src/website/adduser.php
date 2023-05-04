<?php
// Load the user data from the JSON file
$users = json_decode(file_get_contents('./data/users.json'), true);

// Check if the user is logged in
session_start();
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If the user is not logged in
  // redirect them to the login page
      header('Location: login.php');
      exit;
  }

if (isset($_GET['error'])) {
    echo '<p style="color: red;">' . $_GET['error'] . '</p>';
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get the form data
    $username = $_POST['username'];
    $date_added = date('Y-m-d H:i:s');
    $who_added = $_SESSION['username'];
    $codeforces = $_POST['codeforces'];

    // load the existing users from the json file
    $users_json = file_get_contents('./data/users.json');
    $users = json_decode($users_json, true);

    // check if the user already exists
    if (isset($users[$username])) {
        $error = 'L\'utilisateur existe déjà. Vous pouvez le modifier si vous le souhaitez :)';
        header('Location: adduser.php?error=' . urlencode($error));
    }

    // add the new user to the users array
    $users[$username] = array(
    'date_added' => $date_added,
    'who_added' => $who_added,
    'modified_by' => $_SESSION['username'],
    'last_modified' => $date_added,
    'name' => $username,
    'codeforces' => $codeforces
    );

    // save the updated users array to the json file
    $users_json = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents('./data/users.json', $users_json);

    // redirect to the admin page
    header('Location: admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
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
        }

        form {
            width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
            float: right;
        }

        input[type="submit"]:hover {
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
        <a href="admin.php">Admin</a>
        <a href="adduser.php">Add User</a>
        <a href="modifyuser.php">Modify User</a>
        </nav>
    </header>
    <main>
    <h1>Add User</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="codeforces">Codeforces:</label>
        <input type="text" id="codeforces" name="codeforces">

        <label for="other">Other:</label>
        <input type="text" id="other" name="other">



        <input type="submit" value="Add User">
    </form>
    <div class="top-right">
    <a href="logout.php">Logout</a>
    <a href="change-password.php">Change Password</a>
  </div>
    </main>
</body>
</html>
