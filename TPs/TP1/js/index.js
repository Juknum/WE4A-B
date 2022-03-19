const showModal = (type) => {
  // tell the form if it's a register or a simple login
  document.getElementById('register-checkbox').checked = type === 'register' ? 'checked' : null;
  // change button text with the type
  document.getElementById('submit-btn').innerHTML = type;

  // show the modal
  document.getElementById('modal').style.display = 'block';
}