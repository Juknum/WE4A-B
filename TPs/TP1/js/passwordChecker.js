function passwordChecker () {
  let password = document.getElementById("password");
  let confirm = document.getElementById("confirm");
  let confirmLock = document.getElementById("confirmIcon");
  let btn = document.getElementById("submit");

  console.log(password.value != confirm.value)

  if (password.value != confirm.value) {
    btn.value = "Passwords Don't Match";
    btn.disabled = true;
    confirmLock.classList.add("disabled");
    confirmLock.firstChild.classList.remove("fa-lock");
    confirmLock.firstChild.classList.add("fa-lock-open");
  }
  else {
    btn.value = "Register";
    btn.disabled = false;
    confirmLock.classList.remove("disabled");
    confirmLock.firstChild.classList.remove("fa-lock-open");
    confirmLock.firstChild.classList.add("fa-lock");
  }
}