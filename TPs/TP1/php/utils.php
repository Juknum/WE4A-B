<?php

/**
 * Basic connexion to MySQL database
 */
function connectToMYSQL()
{
  // db settings
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "we4a";

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) exit("Failed to connect to MySQL: " . mysqli_connect_error());

  return $conn;
}

/**
 * Check if the user is logged in
 * @param {boolean} $redirect - if true, redirect to login page if not logged in
 * @return {boolean} $startSession - avoid errors if the session has already been started
 */
function isLogged($redirect = true, $startSession = true)
{
  if ($startSession) session_start();

  if (!isset($_SESSION["logged"]) && $redirect) {
    header("Location: login.php");
    exit;
  }
}

/**
 * Get the original blog id from the message id
 * @param {object} $conn - the database connection @see connectToMYSQL()
 * @param {int} $messageId - the message id
 */
function getOriginalBlogId($conn, $messageId)
{
  $blogId = null;

  if ($stmt1 = $conn->prepare("SELECT `blogId` FROM `messages` WHERE `id` = ?")) {
    $stmt1->bind_param("i", $messageId);
    $stmt1->execute();
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {
      $stmt1->bind_result($blogId);
      $stmt1->fetch();
    }

    $stmt1->close();
  }

  return $blogId;
}
