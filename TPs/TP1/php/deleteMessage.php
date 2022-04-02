<?php
require_once("./utils.php");
isLogged();
$conn = connectToMYSQL();

if (isset($_POST["id"], $_POST["messageId"])) {

  if ($_SESSION["id"] != $_POST["id"]) {
    header("Location: ../blog.php?id=" . getOriginalBlogId($conn, $_POST["messageId"]) . "&error=" . urlencode("You can't delete other people's messages!"));
  } else {
    $temp = getOriginalBlogId($conn, $_POST["messageId"]); // because the message is deleted so we can't fetch it anymore aha

    if ($stmt1 = $conn->prepare("DELETE FROM `messages` WHERE `id` = ?")) {
      $stmt1->bind_param("i", $_POST["messageId"]);
      $stmt1->execute();
      $stmt1->close();
    }

    header("Location: ../blog.php?id=" . $temp);
  }
}

$conn->close();
