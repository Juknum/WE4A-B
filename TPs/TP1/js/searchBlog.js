let input = document.getElementById("search");
let timeout = null;

input.addEventListener('keyup', (e) => {
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    selectBlogs();
  }, 1000); // 1s
});

// only happens 5s after the last keyup
const selectBlogs = () => {
  if (input.value === "") document.getElementById("hideSearch").style.display = "block"
  else {
    document.getElementById("hideSearch").style.display = "none";

    axios.get('./php/getBlogs.php?authorName=' + input.value)
      .then(res => {
        console.log(res.data);

        document.getElementById("searchResultTitle").innerHTML = res.data.title;
        document.getElementById("searchResultPhoto").src = res.data.author.photo;
        document.getElementById("searchResultAuthorName").innerHTML = res.data.author.username;
        document.getElementById("searchResultLink").href = "./blog.php?id=" + res.data.id;
        document.getElementById("searchResultContent").innerHTML = converter.makeHtml(res.data.content);

        document.getElementById("searchResult").style.display = "block";
      })
      // .catch(err => {
        
      //   document.getElementById("searchResult").style.display = "none";
      //   console.error(err.error);
      // })
  }

}