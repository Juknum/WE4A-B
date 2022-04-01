<?php
  session_start();

  // db settings
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "we4a";

  // try to connect to db
  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) exit("Failed to connect to MySQL: " . mysqli_connect_error());

  // check if the data from the login form was submitted
  if (!isset($_POST["username"], $_POST["password"])) {
    exit("Please fill both the username and password fields!");
  }

  // avoid SQL injection by preparing the SQL statement
  if ($stmt = $conn->prepare("SELECT id, password FROM accounts WHERE username = ?")) {
    // bind params (s = string, i = integer, d = double, b = blob...)
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();

    // store the result
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->bind_result($id, $password);
      $stmt->fetch();	

      // account exists, now we verify the password
      // we use password_hash in your registration file to store the hashed passwords
      if (password_verify($_POST["password"], $password)) {
        // Verification success! User has logged in!
        // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
        session_regenerate_id();
        $_SESSION["logged"] = true;
        $_SESSION["name"] = $_POST["username"];
        $_SESSION["id"] = $id;
        
        header("Location: home.php");

      } else echo "Incorrect password and/or password!";

    } else echo "Incorrect username and/or password!";

    $stmt->close();
  }
?>