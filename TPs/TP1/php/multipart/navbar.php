<nav>

  <?php
    if ($_USER_LOGGED[0]) echo '<span>'. $_USER_NAME .'</span><button id="logout">Logout</button>';
    else echo '
      <button onclick="showModal(`login`)" class="login">Login</button>
      <button onclick="showModal(`register`)" class="register">Register</button>

      <div id="modal">
        <form id="login-form" action="./" method="post">
          <div class="img-container">
            <span onclick="document.getElementById(`modal`).style.display=`none`">&times;</span>
            <img src="./images/avatar.png" alt="avatar">
          </div>

          <div class="container">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter username" name="username" required>
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter password" name="password" required>

            <button type="submit" id="submit-btn"></button>
            <label type="checkbox"><input type="checkbox" checked="checked" name="remember">Remember me</label>
            <input type="checkbox" id="register-checkbox" name="register" style="display: none;">
          </div>
        </form>
      </div>
      
      <script src="./js/index.js"></script>
    ';
  ?>
</nav>


<?php
  if ($_USER_LOGGED[1]) echo '<h3 class="errLogin">' . $_USER_LOGGED[2] . '</h3>';
?>

