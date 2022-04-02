<nav>
  <ul>
    <li><a class="nav-title" href="./discover.php">BlogIt!</a></li>
    <li>
      <a href='./discover.php'><i class="fa-solid fa-book-open"></i>Discover</a>
      <?php
        if (isset($_SESSION["logged"])) echo "
          <a href='./myblog.php'><i class='fa-solid fa-file-lines'></i>My Blog</a>
          <a href='./profile.php'><i class='fa-solid fa-user'></i>Profile</a>
          <a href='./logout.php'><i class='fa-solid fa-arrow-right-to-bracket'></i>Logout</a>
        ";

        else echo "
          <a href='./login.php'><i class='fa-solid fa-user'></i>Login</a>
          <a href='./register.php'><i class='fa-solid fa-user-plus'></i>Register</a>
        ";
      ?>
    </li>
  </ul>
</nav>