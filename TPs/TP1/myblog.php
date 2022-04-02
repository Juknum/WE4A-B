<?php
  session_start();

  if (!isset($_SESSION["logged"])) {
    header("Location: login.php?error=" . urlencode("You must be logged in to edit your blog!"));
    exit;
  }


  // db settings
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "we4a";

  $title = "How I met your mother / Episode IV: A new Hope / Alors on danse";
  $content = "How would you describe your story?";

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) exit("Failed to connect to MySQL: " . mysqli_connect_error());

  if ($stmt1 = $conn->prepare("SELECT `content`, `title` FROM `blogs` WHERE `authorId` = ?")) {
    $stmt1->bind_param("i", $_SESSION["id"]);
    $stmt1->execute();
    $stmt1->store_result();

    // if there is already a blog, then we bind its id to the blogId variable
    if ($stmt1->num_rows > 0) {
      $stmt1->bind_result($content, $title);
      $stmt1->fetch();	
      $stmt1->close();
    }
  }

?>

<?=file_get_contents("./html/header.html")?>

  <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
  <link rel="stylesheet" href="./styles/myblog.css">
  <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

  <title>BlogIt! Editing your blog</title>
</head>
<body>

  <?php require("./html/navbar.php")?>

  <main>

    <form action="editblog.php" method="post">
      <label for="title"><i class="fa-solid fa-heading"></i>Title</label>
      <input type="text" name="title" value="<?=$title?>" placeholder="How I met your mother / Episode IV: A new Hope / Alors on danse" required>

      <label for="content"><i class="fa-brands fa-markdown"></i>Blog content</label>
      <textarea type="text" id="markdownEditor" placeholder="How would you describe your story?"></textarea>
      <textarea type="text" name="content" id="content" style="display:none" required></textarea>
      
      <?php
        if (isset($_GET["error"])) echo "<span class='error'>" . urldecode($_GET["error"]) . "</span>";
      ?>
      <?php
        if (isset($_GET["success"])) echo "<span class='success'>" . urldecode($_GET["success"]) . "</span>";
      ?>
      <input class="button block" type="submit" value="Save" />

    </form> 

  </main>

  <script>
    const easyMDE = new EasyMDE({element: document.getElementById('markdownEditor')});

    // first load the content of the textarea from the db
    easyMDE.value(`<?=$content?>`);
    document.getElementById("content").value = easyMDE.value();

    // we need to get the content of the textarea and put it in the hidden input
    easyMDE.codemirror.on("change", () => {
      document.getElementById("content").value = easyMDE.value();
    });
  </script>
</body>
<?=file_get_contents("./html/footer.html")?>
