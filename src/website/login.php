<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
        * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }
    .container {
      width: 100%;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 400px;
    }
    .card h1 {
      margin: 0 0 20px 0;
      font-size: 24px;
      font-weight: bold;
      text-align: center;
    }
    .card form {
      display: flex;
      flex-direction: column;
    }
    .card label {
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .card input[type="text"],
    .card input[type="password"] {
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 20px;
    }
    .card input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .card input[type="submit"]:hover {
      background-color: #3e8e41;
    }

</style>
</head>
<body>
  <h1>Login</h1>

  <?php
  // If an error message was passed as a GET parameter, display it
  if (isset($_GET['error'])) {
    echo '<p style="color: red;">' . $_GET['error'] . '</p>';
  }
  ?>

<div class="container">
    <div class="card">
      <h1>Login</h1>
      <form method="post" action="login-handler.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">

        <input type="submit" value="Login">
      </form>
    </div>
  </div>


</body>
</html>
