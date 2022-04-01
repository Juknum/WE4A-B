<?php

  session_start();

  if (!isset($_SESSION["logged"])) {
    header("Location: index.html");
    exit;
  }

  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "we4a";

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) exit("Failed to connect to MySQL: " . mysqli_connect_error());

  $stmt = $conn->prepare("SELECT password, email FROM accounts WHERE id = ?");
  $stmt->bind_param("i", $_SESSION["id"]);
  $stmt->execute();
  $stmt->bind_result($password, $email);
  $stmt->fetch();
  $stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link rel="stylesheet" href="./styles/main.css">
  <link rel="stylesheet" href="./styles/home.css">
  <title>Profile</title>
</head>
<body>

  <nav class="navtop">
    <div>
      <h1>Website Title</h1>
      <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
  </nav>

  <div class="content">
    <h2>Profile Page</h2>
    <div>
      <p>Your account details are below:</p>
      <table>
        <tr>
          <td>Username:</td>
          <td><?=$_SESSION['name']?></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><?=$password?></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><?=$email?></td>
        </tr>
      </table>
    </div>
  </div>

</body>
</html>