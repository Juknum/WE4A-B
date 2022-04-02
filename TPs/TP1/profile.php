<?php
  session_start();

  if (!isset($_SESSION["logged"])) {
    header("Location: login.php?error=" . urlencode("You must be logged in to see your profile!"));
    exit;
  }

  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "we4a";

  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  if (mysqli_connect_errno()) exit("Failed to connect to MySQL: " . mysqli_connect_error());

  $stmt = $conn->prepare("SELECT password, email FROM accounts WHERE id = ?");
  $stmt->bind_param("i", $_SESSION["id"]);
  $stmt->execute();
  $stmt->bind_result($password, $email);
  $stmt->fetch();
  $stmt->close();

?>

<?=file_get_contents("./html/header.html")?>
  <link rel="stylesheet" href="./styles/profile.css">
  <title>Profile</title>
</head>
<body>

  <?php require("./html/navbar.php") ?>

  <main>
    <h2>Profile</h2>
    <div>
      <?php
        if (isset($_GET["success"])) echo "<p class='success'>" . urldecode($_GET["success"]) . "</p>";
      ?>
      <p>Your account details are below:</p>
      <table>
        <tr>
          <td>Username</td>
          <td><?=$_SESSION['name']?></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>●●●●●●●●●</td>
        </tr>
        <tr>
          <td>Email</td>
          <td><?=$email?></td>
        </tr>
      </table>
      <br>
      <button onclick="window.alert('Not Yet Implemented!')"><i class="fa-solid fa-user-pen"></i> Edit Profile</button>
    </div>
</main>

</body>
<?=file_get_contents("./html/footer.html")?>