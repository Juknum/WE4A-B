<?php

  session_start();

  if (!isset($_SESSION["logged"])) {
    header("Location: index.html");
    exit;
  }

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
  <title>Home</title>
</head>
<body>
  <nav class="navtop">
    <div>
      <h1>BlogIt!</h1>
      <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
  </nav>

  <div class="content">
    <h2>Home Page</h2>
    <p>Welcome back, <?=$_SESSION["name"]?>!</p>
  </div>

</body>
</html>