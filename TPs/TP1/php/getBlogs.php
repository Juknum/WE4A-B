<?php

session_start();
require_once("./utils.php");
$conn = connectToMYSQL();

if (isset($_GET["authorName"])) {
  $authorName = $_GET["authorName"];

  if ($stmt1 = $conn->prepare("SELECT `id`, `photo` FROM `accounts` WHERE `username` = ?")) {
    $stmt1->bind_param("s", $authorName);
    $stmt1->execute();
    $stmt1->store_result();

    if ($stmt1->num_rows > 0) {
      $stmt1->bind_result($id, $photo);
      $stmt1->fetch();

      if ($stmt2 = $conn->prepare("SELECT `content`, `title`, `id` FROM `blogs` WHERE `authorId` = ?")) {
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->store_result();

        if ($stmt2->num_rows > 0) {
          $stmt2->bind_result($content, $title, $id);
          $stmt2->fetch();
          $stmt2->close();

          header('Content-Type: application/json');
          http_response_code(200);

          echo "{\"content\": \"$content\", \"title\": \"$title\", \"id\": \"$id\", \"author\": {\"id\": \"$id\", \"username\": \"$authorName\", \"photo\": \"$photo\"}}";
          exit;
        }

        header('Content-Type: application/json');
        http_response_code(404);

        echo "{\"error\": \"No results for that user\"}";
        exit;
      }
    }
    header('Content-Type: application/json');
    http_response_code(404);

    echo "{\"error\": \"No corresponding users with the given username!\"}";
    exit;
  }
}

header('Content-Type: application/json');
http_response_code(500);

echo "{\"error\": \"No username was given!\"}";
exit;
