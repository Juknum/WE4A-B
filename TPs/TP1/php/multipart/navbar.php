<nav>

  <?php
    if ($_USER_LOGGED[0]) echo '<span>'. $_USER_NAME .'</span><button id="logout">Logout</button>';
    else echo '
      <button id="register">Register</button>
      <button id="login">Login</button>
    ';
  ?>
</nav>

<?php
  if ($_USER_LOGGED[1]) echo '<h3 class="errLogin">' . $_USER_LOGGED[2] . '</h3>';
  
?>