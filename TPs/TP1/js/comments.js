const cancel = (id) => {
  document.getElementById(id).style.display = 'none';
  document.getElementById(`${id}Loading`).style.display = 'block';
  document.getElementById(`${id}FormContent`).style.display = 'none';
}

const actionOnComment = (authId, messId, action) => {
  document.getElementById(`${action}`).style.display = 'block';

  axios.get('./php/getMessage.php?messageId=' + messId)
    .then(res => {
      document.getElementById(`${action}Title`).value = res.data.title;
      document.getElementById(`${action}Content`).value = res.data.content;
      document.getElementById(`${action}Id`).value = authId;
      document.getElementById(`${action}MessageId`).value = messId;
      document.getElementById(`${action}Loading`).style.display = 'none';
      document.getElementById(`${action}FormContent`).style.display = 'block';
    })
}