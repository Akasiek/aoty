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

    <script src="search_db.js"></script>

</head>

<body>

    <header>
        <h1>Hi <?php echo $_POST['username_input']; ?>! Choose albums for your list</h1>
    </header>

    <hr>

    <main>
        <div class="left">
            <h2>List Order</h2>

            <form action="save_list.php" method="POST">
                <p><button onclick="saveListToDB()">Save list</button></p>
                <input type="hidden" id="json_data" name="json_data">
                <input type="hidden" name="username_input" value="<?php echo $_POST['username_input']; ?>">
            </form>

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


    <script src="list_creation.js"></script>

</body>

</html>