<?php
require_once("php/utils.php");
isLogged();
$conn = connectToMYSQL();

$stmt = $conn->prepare("SELECT `password`, `email`, `photo` FROM `accounts` WHERE `id` = ?");
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$stmt->bind_result($password, $email, $photo);
$stmt->fetch();
$stmt->close();

?>

<?= file_get_contents("./html/header.html") ?>
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
      <div class="row profile-row">
        <img class="profile-picture" src="<?= $photo ?>" alt="profile picture">
        <table>
          <tr>
            <td>Username</td>
            <td><?= $_SESSION['name'] ?></td>
          </tr>
          <tr>
            <td>Password</td>
            <td>●●●●●●●●●</td>
          </tr>
          <tr>
            <td>Email</td>
            <td><?= $email ?></td>
          </tr>
        </table>
      </div>
      <br>
      <button onclick="window.alert('Not Yet Implemented!')"><i class="fa-solid fa-user-pen"></i> Edit Profile</button>
    </div>
  </main>

</body>
<?= file_get_contents("./html/footer.html") ?>