<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album of the Year - Startpage</title>
</head>

<body>
    <?php
    // MySQL Database connection
    // Change conn.php file and provide it with values corresponding with your database credentials.
    require 'conn1.php';
    ?>

    <h1>Album of the year. Choose yours!</h1>

    <div>
        <form action="create_list.php" method="post">
            <h3>Create list</h3>
            <p>Choose your account:
                <select name="username_input" id="username_input">
                    <option value=""></option>
                    <?php
                    $query = mysqli_query($mysqli, 'SELECT * FROM users');
                    while ($array = mysqli_fetch_array($query))
                        echo "<option value=\"" . $array[1] . "\">" . $array[1] . "</option>";
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
        foreach (new DirectoryIterator('lists') as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $json_content = file_get_contents($fileInfo->getPathname());
            $array = json_decode($json_content, true);
            $result .= $array["owner"] . ", ";
        }
        echo substr($result, 0, -2);
        ?>
    </div>

</body>

</html>