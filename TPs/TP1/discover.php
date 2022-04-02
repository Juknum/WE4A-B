<?php
  session_start();

  if (!isset($_SESSION["logged"])) {
    header("Location: login.php");
    exit;
  }

?>

<?=file_get_contents("./html/header.html")?>

  <link rel="stylesheet" href="./styles/discover.css">
  <title>BlogIt! Discover</title>
</head>
<body>

  <?php require("./html/navbar.php")?>

  <main>
    <h2>Discover</h2>
    <p>Welcome <strong><?=$_SESSION["name"]?></strong>! Find everything you want here!</p>

    <h3 for="search">Search</h3>
    <form class="row searchbar">
      <input type="submit" value="" />
      <input type="text" name="search" id="search" placeholder="Search for blogs..." required />
    </form>

  <!-- todo: SEARCH FUNCTION TROUGH MYSQL -->
  <!-- todo: RANDOM SECTION OF POSTS -->
  <!-- todo: SPECIFIC POST PAGE -->
  
</main>

</body>

<?=file_get_contents("./html/footer.html")?>