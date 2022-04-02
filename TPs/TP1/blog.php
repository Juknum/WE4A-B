<?php
require_once("php/utils.php");
session_start();
$conn = connectToMYSQL();

$messages = [];

if (isset($_GET["id"])) {
  $id = $_GET["id"];

  if ($stmt1 = $conn->prepare("SELECT `content`, `title` FROM `blogs` WHERE `id` = ?")) {
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->store_result();

    // if there is already a blog, then we bind its id to the blogId variable
    if ($stmt1->num_rows > 0) {
      $stmt1->bind_result($content, $title);
      $stmt1->fetch();

      if ($stmt2 = $conn->prepare("SELECT `content`, `title`, `authorId`, `date`, `id` FROM `messages` WHERE `blogId` = ? ORDER BY `date` ASC")) {
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->store_result();

        $meta = $stmt2->result_metadata();
        while ($field = $meta->fetch_field()) {
          $params[] = &$row[$field->name];
        }

        call_user_func_array(array($stmt2, 'bind_result'), $params);
        while ($stmt2->fetch()) {
          foreach ($row as $key => $val) {
            $c[$key] = $val;
          }
          $messages[] = $c;
        }

        $stmt2->close();
      }
    }

    $stmt1->close();
  }
} else {
  $content = "<p align='center'><a href='./discover.php'>Go back to Discover!</a></p>";
  $title = "Blog not found!";
}
?>

<?= file_get_contents("./html/header.html") ?>

<link rel="stylesheet" href="./styles/blog.css">
<title>BlogIt! <?= $title ?></title>
</head>

<body>
  <?php require("./html/navbar.php") ?>

  <div class="editComment" id="edit" style="display: none;">
    <form class="column" action="./php/editMessage.php" method="post">
      <p align="center" id="editLoading">Loading...</p>

      <div id="editFormContent" style="display: none;">
        <label for="title">Title</label>
        <input id="editTitle" name="title" type="text" required />

        <label for="content">Content</label>
        <textarea id="editContent" name="content" type="text" required></textarea>

        <input id="editId" type="hidden" name="id" value="" required>
        <input id="editMessageId" type="hidden" name="messageId" value="" required>
        <input id="blogId" type="hidden" name="blogId" value="<?= $id ?>" required>

        <div class="row">
          <input class="button" type="submit" value="Submit">
          <a class="button" onclick="cancel(`edit`)">Cancel</a>
        </div>
      </div>
    </form>
  </div>

  <div class="deleteComment" id="delete" onclick="cancel(`delete`)" style="display: none;">
    <form class="column" action="./php/deleteMessage.php" method="post">
      <strong>Would you delete this comment?</strong>
      <p align="center" id="deleteLoading">Loading...</p>

      <div id="deleteFormContent" style="display: none;">
        <label>Title</label>
        <input type="text" id="deleteTitle" value="" disabled></input>

        <label>Content</label>
        <textarea id="deleteContent" value="" disabled></textarea>

        <input id="deleteId" type="hidden" name="id" value="" required>
        <input id="deleteMessageId" type="hidden" name="messageId" value="" required>
        <div class="row">
          <input class="button error" type="submit" value="Delete">
          <a class="button" onclick="cancel(`delete`)">Cancel</a>
        </div>
      </div>
    </form>
  </div>

  <main>
    <h1><?= $title ?></h1>
    <div id="container"></div>

    <div class="comments">
      <h4>Comments</h4>
      <?php

      if ($_SESSION && $_SESSION["id"] != null) echo "<button class='button' onclick='actionOnComment(" . $_SESSION["id"] . ", null, `edit`)'>Add comment</button>";
      else echo "<p align='left'>You must be logged in to add comments!</p>";

      if ($messages) {
        $i = 0;

        foreach ($messages as $key => $value) {
          if ($i > 10) break;

          $i++;
          $_message_authorId = $value["authorId"];
          $_message_date = $value["date"];
          $_message_content = $value["content"];
          $_message_title = $value["title"];

          if ($stmt3 = $conn->prepare("SELECT `username`, `photo` FROM `accounts` WHERE `id` = $_message_authorId")) {
            $stmt3->execute();
            $stmt3->store_result();

            if ($stmt3->num_rows > 0) {
              $stmt3->bind_result($_message_author, $_message_authorPhoto);
              $stmt3->fetch();
            } else {
              $_message_author = "Unknown User";
              $_message_authorPhoto = "./images/avatar.png";
            }

            $stmt3->close();
          }

          echo "<div class='comment'><div class='author'><img src='" . $_message_authorPhoto . "' alt='profile'><strong>" . $_message_author . "</strong><p>" . $_message_date . "</p></div><div class='content'><h6>" . $_message_title . "</h6><p>" . $_message_content . "</p></div>";

          if ($_SESSION && $_SESSION["id"] == $_message_authorId) {
            echo "<div class='delete'><button class='delete-btn' onclick='actionOnComment(" . $_SESSION["id"] . ", " . $value["id"] . ", `delete`)'>❌</button></div>";
            echo "<div class='edit'><button class='edit-btn' onclick='actionOnComment(" . $_SESSION["id"] . ", " . $value["id"] . ", `edit`)'>✏️</button></div>";
          }

          echo "</div>"; // to let the delete btn in the comment block
        }
      }
      ?>
    </div>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/showdown@2.0.3/dist/showdown.min.js"></script>
  <script src="./js/comments.js"></script>

  <script>
    var converter = new showdown.Converter();
    var text = `<?= $content ?>`;

    document.getElementById("container").innerHTML = converter.makeHtml(text);
  </script>

</body>

<?= file_get_contents("./html/footer.html") ?>