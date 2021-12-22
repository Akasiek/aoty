<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose albums</title>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        header {
            margin: 20px;
        }

        main {
            display: flex;
        }

        main>div {
            margin: 20px;
            min-height: 100vh;
            flex: 0 1 50%;
        }

        hr {
            margin: 10px 20px;
        }

        table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 5px;
        }

        td>img {
            height: 75px;
        }

        td:last-child {
            text-align: center;
        }
    </style>

    <script>
        function loadData() {
            let xmlhttp = new XMLHttpRequest();
            let searchInputDOM = document.getElementById("search_input");
            let searchInput = "";

            if (searchInputDOM) {
                searchInput = searchInputDOM.value;
            }

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search_result").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "search.php?search_input=" + searchInput, true);
            xmlhttp.send();
        }
        loadData();
    </script>

</head>

<body>

    <header>
        <h1>Hi <?php echo $_POST['username_input']; ?>! Choose albums for your list</h1>
    </header>

    <hr>

    <main>
        <div class="left">
            <h2>List Order</h2>
            <?php
            // // Connection file
            // require 'conn.php';
            // // Check if list exist in lists table
            // if (mysqli_num_rows(mysqli_query(
            //     $mysql_conn,
            //     'SELECT * FROM lists
            // INNER JOIN users ON lists.owner_id = users.id
            // WHERE users.username LIKE "' . $_POST['username_input'] . '"'
            // )) == 0) {
            //     $owner_id = mysqli_fetch_array(mysqli_query($mysql_conn, 'SELECT id FROM users WHERE username LIKE "' . $_POST['username_input'] . '"'));
            //     if (!mysqli_query($mysql_conn, 'INSERT INTO lists (owner_id) VALUES (' . $owner_id[0] . ')'))
            //         echo "Error: " . mysqli_error($mysql_conn);
            // }
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Artist</th>
                        <th>Title</th>
                        <th>Cover Art</th>
                    </tr>
                </thead>
                <tbody id="list_tbody">

                </tbody>
            </table>
        </div>


        </div>

        <hr>

        <div class="right">
            <h2>Search</h2>

            <form>
                <p>
                    <input type="search" name="search_input" id="search_input" placeholder="Search for a album" onkeydown="loadData()">
                </p>
            </form>

            <div id="search_result"></div>

            <!-- <input type="checkbox" name="" id="1_For the first timee" onclick="addToList(1, 'For the first timee', 'Black Country, New Road' )"> -->

        </div>
    </main>


    <script>
        const listTbodyDOM = document.getElementById("list_tbody");
        let list = [];

        function addToList(id, album, artist, cover) {
            // Create reference to checkbox from search result table
            const albumCheckbox = document.getElementById("album_" + id);


            if (albumCheckbox.checked) { // If checkbox checked add corresponding album object to the list array
                list.push({
                    id: id,
                    albumName: album,
                    artistName: artist,
                    coverartUrl: cover
                });
            }
            if (albumCheckbox.checked == false) { // Else push album object from the list array
                list.forEach(function(obj, i) {
                    if (obj["id"] == id)
                        list.splice(i, 1);
                });
            }

            renderList(list);
        }

        function renderList(list) {
            // Reset list results
            listTbodyDOM.innerHTML = "";

            // For each added album create row with position, album name, etc.
            list.forEach(function(obj, i) {
                let newRow = listTbodyDOM.insertRow();
                let positionCell = newRow.insertCell();
                let artistNameCell = newRow.insertCell();
                let albumNameCell = newRow.insertCell();
                let coverartUrlCell = newRow.insertCell();

                positionCell.innerHTML = i + 1;
                artistNameCell.innerHTML = obj["artistName"];
                albumNameCell.innerHTML = obj["albumName"];
                coverartUrlCell.innerHTML = "<img src='" + obj["coverartUrl"] + "'>";
                // let albumMarkup = `
                //     <tr>
                //         <td>${i+1}<td>
                //         <td>${obj["artistName"]}<td>
                //         <td>${obj["albumName"]}<td>
                //         <td><img src="${obj["coverartUrl"]}"><td>
                //     </tr>
                // `;
                // console.log(albumMarkup);
                // listTbodyDOM.innerHTML += albumMarkup;
            });
        }
    </script>

</body>

</html>