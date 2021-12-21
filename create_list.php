<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose albums</title>
</head>

<body>

    <?php
    require 'conn1.php';
    // Check if list exist in lists table
    if (mysqli_num_rows(mysqli_query(
        $mysql_conn,
        'SELECT * FROM lists
        INNER JOIN users ON lists.owner_id = users.id
        WHERE users.username LIKE "' . $_POST['username_input'] . '"'
    )) == 0) {
        $owner_id = mysqli_fetch_array(mysqli_query($mysql_conn, 'SELECT id FROM users WHERE username LIKE "' . $_POST['username_input'] . '"'));
        if (mysqli_query($mysql_conn, 'INSERT INTO lists (owner_id) VALUES (' . $owner_id[0] . ')'))
            echo "New record created successfully";
        else
            echo "Error: " . mysqli_error($mysql_conn);
    }
    ?>

    <h1>Choose albums for your list</h1>

    <input type="search" name="search" id="" placeholder="Search for album" onkeyup="load_data(this.value)">

</body>

<script>
    (function load_data(query = '') {
        var form_data = new FormData();

        form_data.append('query', query);

    })()
</script>

</html>