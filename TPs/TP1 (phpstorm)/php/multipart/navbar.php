<nav>
    <a href="/">Home</a>
    <div>

        <?php
            if ($SQLconn->loginStatus->successful) echo "<button id='logout' onclick='logout()'>logout</button>";
            elseif (!$SQLconn->loginStatus->successful) echo "<button id='login' onclick='showModal(`login`)'>login</button><button id='register' onclick='showModal(`register`)'>register</button>";
        ?>
    </div>

    <?php
        if (!$SQLconn->loginStatus->successful) echo '
    <div id="modal">
        <form id="login-form" action="./" method="post">
            <div class="img-container">
                <span onclick="document.getElementById(`modal`).style.display=`none`">&times;</span>
                <img src="./data/images/avatar.png" alt="avatar">
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
            <script src="./js/index.js"></script>
        </form>
    </div>';
    ?>
<?php

    /*
if ($_USER_LOGGED[0]) echo '<span>'. $_USER_NAME .'</span><button id="logout">Logout</button>';
else echo '
      <button onclick="showModal(`login`)" class="login">Login</button>
      <button onclick="showModal(`register`)" class="register">Register</button>

      <div id="modal">

      </div>

    ';*/
?>

</nav>

