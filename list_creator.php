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
        async function searchDB() {
            // Get DOM of input where user types search criteria 
            let searchInputDOM = document.getElementById("search_input");
            // If searchInputDOM is set, set searchInput variable to its value
            // Helps to display search results on window load
            let searchInput = "";
            if (searchInputDOM) {
                searchInput = searchInputDOM.value;
            }

            // Send request to search.php file for search result with searchInput variable as search criteria
            async function getDataFromDB(searchInput) {
                let res = await fetch("php/search.php?search_input=" + searchInput);
                return res.text();
            }

            // Unwrap async function return
            let result = await getDataFromDB(searchInput)
            // Use result variable as HTML markup of search_result element
            document.getElementById("search_result").innerHTML = result;
        }
        searchDB();
    </script>



</head>

<body>

    <header>
        <h1>Hi <?php echo $_GET['username_input']; ?>! Choose albums for your list</h1>
    </header>

    <hr>

    <main>
        <div class="left">
            <h2>List Order</h2>

            <form action="php/save_list.php" method="POST">
                <p><button onclick="saveListToDB()">Save list</button></p>
                <input type="hidden" id="json_data" name="json_data">
                <input type="hidden" id="username_input" name="username_input" value="<?php echo $_GET['username_input']; ?>">
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

        <hr>

        <div class="right">
            <h2>Search</h2>
            <p>
                <input type="search" name="search_input" id="search_input" placeholder="Search for a album" onsearch="searchDB()" onkeyup="searchDB()">
            </p>
            <div id="search_result"></div>
        </div>
    </main>

    <script src="js/list_creation.js"></script>

</body>

</html>