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
    <meta charset="UTF-8">
    <title>Modify User</title>
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

        #container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        #form {
            border: 1px solid black;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin: 10px;
        }

        input[type="text"] {
            margin: 10px;
        }

        #save-button {
            margin-top: 20px;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        #save-button:hover {
            background-color: #3e8e41;
        }

        .error {
            color: red;
            margin: 10px;
        }
        #users-container {
        margin: 20px auto;
        max-width: 800px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        }

        #users-container h2 {
        font-size: 24px;
        margin-top: 0;
        margin-bottom: 20px;
        }

        #users-container table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        }

        #users-container th {
        background-color: #eee;
        border: 1px solid #ddd;
        padding: 10px;
        }

        #users-container td {
        border: 1px solid #ddd;
        padding: 10px;
        }

        #users-container tr:nth-child(even) {
        background-color: #f9f9f9;
        }

        /* Style the delete button */
        .delete {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        width: 80px;
        height: 30px;
        }

        /* Style the modify button */
        .modify {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        width: 80px;
        height: 30px;
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
    
    <div id="container">
        <div id="form">
            <?php
            $error = '';

            $users = json_decode(file_get_contents('./data/users.json'), true);

            if ($user)
           
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the submitted username
                $username = $_POST['username'];
            
                // Load the users from the JSON file
                $users = json_decode(file_get_contents('./data/users.json'), true);
            
                // Check if the user exists
                if (isset($users[$username])) {
                    // Get the user information
                    $user = $users[$username];
            
                    // Update the user information with the new codeforces name
                    $user['codeforces'] = $_POST['codeforces'];
            
                    // Update the user in the users array
                    $users[$username] = $user;
            
                    // Save the updated users array to the JSON file
                    file_put_contents('./data/users.json', json_encode($users));
            
                    // Display a success message
                    echo '<div class="success">User updated successfully!</div>';
                } else {
                    // Display an error message if the user does not exist
                    $error = 'User does not exist';
                }
            }
            
            if (!empty($error)) {
                // Display the error message if there is one
                echo '<div class="error">' . $error . '</div>';
            } elseif (isset($_POST['username'])) {
                // Display the form with the updated user information
                $username = $_POST['username'];
                $user = $users[$username];
                ?>
                <h1>Modify User</h1>
                <form method="post">
                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                    <label for="name">Name:</label>
                    <input type="text" name="name"><br>
                    <label for="codeforces">Codeforces Name:</label>
                    <input type="text" name="codeforces"><br>
                    <input type="submit" id="save-button" name="submit" value="Save">
                </form>
                <?php
            } else {
                // Display the form to enter the username
                ?>
                <h1>Modify User</h1>
                <form method="post">
                    <input type="hidden" name="username">
                    <label for="name">Name:</label>
                    <input type="text" name="name"><br>
                    <label for="codeforces">Codeforces Name:</label>
                    <input type="text" name="codeforces"><br>
                    <input type="submit" id="save-button" name="submit" value="Save">
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <div id="users-container">
    <h2>All Users</h2>
    <table>
        <thead>
        <tr>
            <th>Username</th>
            <th>Date Added</th>
            <th>Added By</th>
            <th>Last Modified</th>
            <th>Modified By</th>
            <th>Codeforces</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $username => $user) : ?>
            <tr>
            <td><strong><?php echo $username; ?></strong></td>
            <td><?php echo $user['date_added']; ?></td>
            <td><?php echo $user['who_added']; ?></td>
            <td><?php echo $user['last_modified']; ?></td>
            <td><?php echo $user['modified_by']; ?></td>
            <td><?php echo $user['codeforces']; ?></td>
            <td>
            <form method="post" onsubmit="return confirm('Are you sure you want to delete this user?');" action="deleteuser.php">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="delete" name="delete">Delete</button>
            </form>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <div class="top-right">
    <a href="logout.php">Logout</a>
    <a href="change-password.php">Change Password</a>
  </div>
    </main>
</body>
</html>
