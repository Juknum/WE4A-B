const showModal = (type) => {
  let form = document.getElementById("login-form");
  let submitButton = document.getElementById("submit-btn");
  let confirmPassword = document.getElementById("confirm");

  switch (type) {
    case "login":
      submitButton.innerHTML = "Login";
      form.action = "./login.php";
      confirmPassword.style.display = "none";
      break;

    case "register":
    default:
      submitButton.innerHTML = "Register";
      form.action = "./register.php";
      confirmPassword.style.display = "block";
      break;
  }

  // finally: show the modal
  document.getElementById('modal').style.display = 'block';
}

const logout = () => {
  window.alert("NYI");
}