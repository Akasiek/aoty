// Function for sending XMLHttp Request to PHP file. Searching without reloading page
function searchDB() {
    let xmlhttp = new XMLHttpRequest();
    let searchInputDOM = document.getElementById("search_input");
    let searchInput = "";

    if (searchInputDOM) {
        searchInput = searchInputDOM.value;
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("search_result").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "search.php?search_input=" + searchInput, true);
    xmlhttp.send();
}
searchDB();
