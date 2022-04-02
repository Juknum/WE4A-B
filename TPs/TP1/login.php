<?=file_get_contents("./html/header.html")?>

  <link rel="stylesheet" href="./styles/login.css">
  <title>Login</title>
</head>
<body>
  <main>
    <h1>Login</h1>

    <form action="authenticate.php" method="post">
      <label for="username"><i class="fa-solid fa-signature"></i></label>
      <input type="text" name="username" placeholder="Username" id="username" required>

      <label for="password"><i class="fa-solid fa-lock"></i></label>
      <input type="password" name="password" placeholder="Password" id="password" required>

      <p align="center">
        <?php
          if (isset($_GET["success"])) echo "<span class='success'>" . urldecode($_GET["success"]) . "</span><br>";
          if (isset($_GET["error"])) echo "<span class='error'>" . urldecode($_GET["error"]) . "</span><br>";
        ?>
        <a href="register.php">Don't have an account?</a>&nbsp;
        <a href="index.php" class='error'>Cancel</a>
      </p>
      <input type="submit" value="Login">
    </form>

  </main>
  
</body>
</html>