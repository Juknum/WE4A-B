<?php
require_once("./utils.php");
isLogged();
$conn = connectToMYSQL();

if (!isset($_POST["title"], $_POST["content"])) header("Location: ../myblog.php?error=" . urlencode("Please fill the title & content fields!"));

// the blogId isn't known => the blog does not exist yet OR we haven't searched for it yet
// => we need to fetch it OR create a new blog post

$blogId = null;

// take blogs which authorId corresponds to the logged in user
if ($stmt1 = $conn->prepare("SELECT `id` FROM blogs WHERE authorId = ?")) {
  $stmt1->bind_param("i", $_SESSION["id"]);
  $stmt1->execute();
  $stmt1->store_result();

  // if there is already a blog, then we bind its id to the blogId variable
  if ($stmt1->num_rows > 0) {
    $stmt1->bind_result($blogId);
    $stmt1->fetch();
    $stmt1->close();
  }

  // otherwise we create it
  else {
    // create a new blog post
    if ($stmt2 = $conn->prepare("INSERT INTO `blogs` (`id`, `title`, `authorId`, `content`) VALUES (default, ?, ?, ?)")) {
      $stmt2->bind_param("sis", $_POST["title"], $_SESSION["id"], $_POST["content"]);
      $stmt2->execute();
      $stmt2->close();

      header("Location: ../myblog.php?success=" . urlencode("Blog post created!"));
    } else header("Location: ../myblog.php?error=" . urlencode("Failed to create a new blog post!"));

    exit();
  }

  if ($blogId != null) {
    if ($stmt3 = $conn->prepare("UPDATE `blogs` SET `title` = ?, `content` = ? WHERE `id` = ?")) {
      $stmt3->bind_param("ssi", $_POST["title"], $_POST["content"], $blogId);
      $stmt3->execute();
      $stmt3->close();

      header("Location: ../myblog.php?success=" . urlencode("Blog post updated!"));
    } else header("Location: ../myblog.php?error=" . urlencode("Failed to update the blog post!"));
  } else header("Location: ../myblog.php?error=" . urlencode("The blogId is null!"));
}

$conn->close();
