<?php
require_once("php/utils.php");
session_start();
?>

<?= file_get_contents("./html/header.html") ?>

<link rel="stylesheet" href="./styles/discover.css">
<title>BlogIt! Discover</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/showdown@2.0.3/dist/showdown.min.js"></script>
<script>
  var converter = new showdown.Converter();
</script>
</head>

<body>
  <?php require("./html/navbar.php") ?>

  <main>
    <h2>Discover</h2>

    <h3>Search</h3>
    <div class="row searchbar">
      <span class="searchIMG"></span>
      <input type="text" name="search" id="search" placeholder="Search for blogs authors..." required />
    </div>

    <div class="blogs" id="searchResult" style="display: none;">
      <div class="blog">
        <h4 id="searchResultTitle"></h4>
        <span><img id="searchResultPhoto" alt="profile"><strong id="searchResultAuthorName"></strong>,&nbsp;<a id="searchResultLink">read blog</a></span>
        <p id="searchResultContent"></p>
      </div>
    </div>

    <div id="hideSearch">
      <h3>Selected for you</h3>
      <div class="blogs">
        <?php
        $conn = connectToMYSQL();

        $query = "SELECT `id`, `title`, `content`, `authorId` FROM `blogs` ORDER BY `id` DESC";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $title = $row["title"];
            $content = $row["content"];
            $authorId = $row["authorId"];

            $content = substr($content, 0, 100);
            $content = $content . "...";

            if ($stmt3 = $conn->prepare("SELECT `username`, `photo` FROM `accounts` WHERE `id` = $authorId")) {
              $stmt3->execute();
              $stmt3->store_result();

              if ($stmt3->num_rows > 0) {
                $stmt3->bind_result($authorName, $authorPhoto);
                $stmt3->fetch();
              } else {
                $authorName = "Unknown User";
                $authorPhoto = "./images/avatar.png";
              }

              $stmt3->close();
            }

            echo "<div class='blog'>
            <h4>$title</h4>
            <span><img src='$authorPhoto' alt='profile'><strong>$authorName</strong>,&nbsp;<a href='./blog.php?id=$id'>read blog</a></span>
            <p id='$id'></p>

            <script id='silentScript$id'>
              document.getElementById('$id').innerHTML = converter.makeHtml(`$content`);
              document.getElementById('silentScript$id').remove();
            </script>
          </div>";
          }
        } else {
          echo "<p>No blogs found!</p>";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </main>
</body>

<script src="./js/searchBlog.js"></script>

<?= file_get_contents("./html/footer.html") ?>