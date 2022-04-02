<?= file_get_contents("./html/header.html") ?>

<title>Home</title>
</head>

<body>
  <?php require("./html/navbar.php") ?>

  <main>
    <p align=justify>
      Welcome to the best blog website ever made on this localhost. Yeah, we haven't raised enough money <strong>yet</strong> to go worldwide.
      <br>
      <br>
      In order to create your personal blog, you need <u>to first create/connect</u> to your account! Please use the login/register option on the top right of your screen.
      Once you have created/connected to your account, you'll be redirected to your personal blog page edition. Click the save button and tadaa! your blog is now offline! (localhost you know :o)
    </p>

    <p>You can freely visits blogs from everybody by clicking the Discover button. But you need an account to post messages below it! When you've posted a message, you can edit/delete it, so don't be scared of typos!</p>
  </main>

  <?= file_get_contents("./html/footer.html") ?>
</body>