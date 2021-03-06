<?php
require_once("./utils.php");
session_start();
$conn = connectToMYSQL();

// check if the data from the login form was submitted
if (!isset($_POST["username"], $_POST["password"]))
  header("Location: ../login.php?error=" . urlencode("Please fill both the username and password fields!"));

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

      header("Location: ../myblog.php");
    } else header("Location: ../login.php?error=" . urlencode("Incorrect password and/or password!"));
  } else header("Location: ../login.php?error=" . urlencode("Incorrect username and/or password!"));

  $stmt->close();
}
