<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album of the Year - Startpage</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        section.user_choice {
            display: flex;
        }

        section.user_choice>div {
            flex: 1;
            padding: 10px 20px;
        }

        section.leaderboard {
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        hr {
            margin: 10px 20px;
        }

        table {
            border: 1px solid #000;
        }


        table,
        th,
        td {
            outline: 1px solid #000;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }

        th:nth-child(-n + 3) {
            font-size: 2rem;
        }

        td:nth-child(-n + 2) {
            font-size: 2.5rem;
            padding: 0 20px;
        }

        td:nth-child(3) {
            display: flex;
            align-items: center;
            font-size: 1.75rem;
            text-align: left;
            padding: 0;
        }

        td:nth-child(3)>div:nth-child(2) {
            padding: 0 35px 0 15px;
        }

        td:nth-child(3)>div>p {
            margin: 0;
        }


        td:nth-child(3)>div>p:nth-child(2) {
            font-size: 1rem;
            font-style: italic;
            color: #555;
        }

        td>div:first-child {
            height: 200px;
        }

        td>div>img {
            width: 200px;
        }
    </style>
</head>

<body>
    <?php
    // MySQL Database connection
    // Change conn.php file and provide it with values corresponding with your database credentials.
    require "php/conn.php";
    ?>

    <h1>Album of the year. Choose yours!</h1>

    <section class="user_choice">
        <div>
            <form action="list_creator.php" method="get">
                <h3>Create list</h3>
                <p>Choose your account:
                    <select name="username_input" id="username_input">
                        <option value=""></option>
                        <?php
                        $query = mysqli_query($mysql_conn, 'SELECT * FROM users');
                        while ($row = mysqli_fetch_array($query))
                            echo "<option value=\"" . $row[1] . "\">" . $row[1] . "</option>";
                        ?>
                    </select>
                </p>
                <input type="submit" value="Create your list">
            </form>
        </div>

        <hr>

        <div>
            <h3>Users, whom created their list</h3>
            <?php
            $result = "";
            $query = mysqli_query($mysql_conn, 'SELECT users.username FROM lists INNER JOIN users ON lists.owner_id = users.id');
            if (mysqli_num_rows($query) == 0) {
                print "No users yet.";
            } else {
                while ($row = mysqli_fetch_array($query)) {
                    $user_markup = "<a href='list_creator.php?username_input=" . $row[0] . "'>" . $row[0] . "</a>";
                    $result .= $user_markup . ", ";
                }
            }
            print substr($result, 0, -2);
            ?>
        </div>
    </section>

    <hr>

    <section class="leaderboard">

        <?php
        require 'php/conn.php';
        // Get Top 10 albums on leaderboard by score
        $sql = " SELECT leaderboard.score, albums.title, artists.name, albums.coverart_url FROM leaderboard
        INNER JOIN albums ON leaderboard.album_id = albums.id
        INNER JOIN artists ON albums.artist_id = artists.id
        WHERE score != 0
        ORDER BY score DESC
        LIMIT 10";
        $result = mysqli_query($mysql_conn, $sql);

        if (mysqli_num_rows($result) != 0) {
            // Print results in table
            $place = 1;
            echo "<h1>Leaderboard</h1>";
            echo "<table><tr><th>#</th><th>Score</th><th>Album</th></tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>$place</td>";
                echo "<td>" . $row["score"] . "</td>";
                echo "<td><div><img src='" . $row["coverart_url"] . "'></div><div><p>" . $row["title"] . "</p><p>" . $row["name"] . "</p></div></td>";
                echo "</tr>";

                $place++;
            }
            echo "</table>";
        } else {
            echo "Leaderboard is empty...";
        }



        ?>
    </section>


</body>

</html>