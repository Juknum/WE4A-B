<?php
  session_start();

  // db settings
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "we4a";

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) exit("Failed to connect to MySQL: " . mysqli_connect_error());

  // check if the data from the register form was submitted
  if (!isset($_POST["username"], $_POST["password"], $_POST["confirm"], $_POST["email"])) 
    header("Location: register.php?error=" . urlencode("Please fill the username, password, confirm password & email fields!"));

  if (strlen($_POST["username"]) < 4) 
    header("Location: register.php?error=" . urlencode("Username must be at least 4 characters long!"));

  if ($_POST["password"] != $_POST["confirm"]) 
    header("Location: register.php?error=" . urlencode("Passwords do not match!"));

  if ($stmt1 = $conn->prepare("SELECT id FROM accounts WHERE email = ? OR username = ?")) {
    $stmt1->bind_param("ss", $_POST["email"], $_POST["username"]);
    $stmt1->execute();
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) header("Location: register.php?error=" . urlencode("Email/Username already taken!"));
    else {

      // INSERT INTO `accounts` (`id`, `username`, `password`, `email`) VALUES (id, 'test', 'password', 'test@test.com');
      if ($stmt2 = $conn->prepare("INSERT INTO `accounts` (`id`, `username`, `password`, `email`) VALUES (default, ? , ? , ?)")) {
        // bind params (s = string, i = integer, d = double, b = blob...)
        $stmt2->bind_param("sss", $_POST["username"], password_hash($_POST["password"], null), $_POST["email"]);
        $stmt2->execute();

        // store the result
        $stmt2->store_result();
        header("Location: login.php?success=" . urlencode("Account created successfully, please login!"));

        $stmt2->close();
      }
    }

    $stmt1->close();
  }
?>