<?php
require_once("./utils.php");
isLogged();
$conn = connectToMYSQL();

if (isset($_POST["id"], $_POST["title"], $_POST["content"], $_POST["messageId"], $_POST["blogId"])) {

  if ($_SESSION["id"] != $_POST["id"]) {
    header("Location: ../blog.php?id=" . $_POST["blogId"] . "&error=" . urlencode("You can't edit other people's messages!"));
  }

  // update message
  else if ($_POST["messageId"]) {
    if ($stmt1 = $conn->prepare("UPDATE `messages` SET `title` = ?, `content` = ?, `date` = ? WHERE `id` = ?")) {
      $stmt1->bind_param("sssi", $_POST["title"], $_POST["content"], date("Y-d-m"), $_POST["messageId"]);
      $stmt1->execute();
      $stmt1->close();
    }

    header("Location: ../blog.php?id=" . $_POST["blogId"]);
  }

  // create message
  else {
    if ($stmt1 = $conn->prepare("INSERT INTO `messages` (`blogId`, `title`, `content`, `authorId`, `date`) VALUES (?, ?, ?, ?, ?)")) {
      $stmt1->bind_param("issis", $_POST["blogId"], $_POST["title"], $_POST["content"], $_SESSION["id"], date("Y-d-m"));
      $stmt1->execute();
      $stmt1->close();
    }

    header("Location: ../blog.php?id=" . $_POST["blogId"]);
  }
}

$conn->close();
