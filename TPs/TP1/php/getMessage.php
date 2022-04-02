<?php 
  
  session_start();
  require_once("./utils.php");
  $conn = connectToMYSQL();

  if (isset($_GET["messageId"])) {
    $id = $_GET["messageId"];

    if ($stmt1 = $conn->prepare("SELECT `content`, `title` FROM `messages` WHERE `id` = ?")) {
      $stmt1->bind_param("i", $id);
      $stmt1->execute();
      $stmt1->store_result();

      if ($stmt1->num_rows > 0) {
        $stmt1->bind_result($content, $title);
        $stmt1->fetch();
      }
      else {
        $content = "";
        $title = "";
      }

      $stmt1->close();
    }


    $conn->close();
  }

  else {
    $content = "";
    $title = "";
  }

  header('Content-Type: application/json');
  http_response_code(200);

  echo "{\"content\": \"$content\", \"title\": \"$title\"}";
