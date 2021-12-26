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

        .emoji_button {
            background-color: #fff;
            border: 2px solid #878787;
            padding: 2px 2px 3px 2px
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
        // Function for sending XMLHttp Request to PHP file. Searching without reloading page
        function searchDB() {
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
            xmlhttp.open("GET", "php/search.php?search_input=" + searchInput, true);
            xmlhttp.send();
        }
        searchDB();
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

            <form action="php/save_list.php" method="POST">
                <p><button onclick="saveListToDB()">Save list</button></p>
                <input type="hidden" id="json_data" name="json_data">
                <input type="hidden" id="username_input" name="username_input" value="<?php echo $_POST['username_input']; ?>">
            </form>



            <table>
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Artist</th>
                        <th>Title</th>
                        <th>Cover Art</th>
                        <th></th>
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

            <p>
                <input type="search" name="search_input" id="search_input" placeholder="Search for a album" onkeyup="searchDB()">
            </p>

            <div id="search_result"></div>

            <!-- <input type="checkbox" name="" id="1_For the first timee" onclick="addToList(1, 'For the first timee', 'Black Country, New Road' )"> -->

        </div>
    </main>




    <script src="js/list_creation.js"></script>

    <script>

    </script>

</body>

</html>