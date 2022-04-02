<?=file_get_contents("./html/header.html")?>

  <link rel="stylesheet" href="./styles/login.css">
  <title>Register</title>
</head>
<body>
  <main>
    <h1>Register</h1>

    <form action="createAccount.php" method="post">
      <script src="./js/passwordChecker.js"></script>

      <label for="username"><i class="fa-solid fa-signature"></i></label>
      <input type="text" name="username" placeholder="Username" id="username" required>

      <label for="email"><i class="fa-solid fa-at"></i></label>
      <input type="email" name="email" placeholder="someone@somewhere.net" required>

      <label for="password"><i class="fa-solid fa-lock"></i></label>
      <input oninput="passwordChecker()" type="password" name="password" placeholder="Password" id="password" required>
      
      <label for="confirm" id="confirmIcon" ><i class="fa-solid fa-lock"></i></label>
      <input oninput="passwordChecker()" type="password" name="confirm" placeholder="Confirm Password" id="confirm" required>

      <p align="center">
        <?php
          if (isset($_GET["error"])) echo "<span class='error'>" . urldecode($_GET["error"]) . "</span><br>";
        ?>

        <a href="login.php">Already have an account?</a>&nbsp;
        <a href="index.php" class='error'>Cancel</a>
      </p>
      <input id="submit" type="submit" value="Register">
    </form>

  </main>
  
</body>
</html>