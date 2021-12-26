<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album of the Year - Startpage</title>

    <style>
        section.user_choice {
            display: flex;
        }

        section.user_choice>div {
            flex: 1;
            padding: 10px 20px;
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
        <h1 style="text-align:center;">Leaderboard</h1>

    </section>


</body>

</html>