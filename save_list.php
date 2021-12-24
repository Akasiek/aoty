<?php
require 'conn.php';
// Get JSON of list as PHP array
$list = json_decode($_POST['json_data']);
$username = $_POST['username_input'];

// Get user id
$sql = "SELECT id FROM users WHERE username LIKE '$username'";
$result = mysqli_query($mysql_conn, $sql);
$row = mysqli_fetch_row($result);
$user_id = $row[0];


// If list doesn't exist in DB create. Else update the existing list
$sql = "SELECT * FROM lists WHERE owner_id = $user_id";
$query = mysqli_query($mysql_conn, $sql);
if (mysqli_num_rows($query) == 0) {
    createList($mysql_conn, $list, $user_id);
} else {
    updateList($mysql_conn, $list, $user_id);
}

function createList($conn, $list, $user_id)
{
    $sql = "INSERT INTO lists (owner_id) VALUES ($user_id)";
    if (mysqli_query($conn, $sql))
        $list_id = mysqli_insert_id($conn);
    else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);


    foreach ($list as $index => $value) {
        print("INSERTING: $list_id, $index, $value");
        $sql = "INSERT INTO ratings (album_position, album_id, list_id) VALUES (" . ($index + 1) . ", $value, $list_id)";
        if (mysqli_query($conn, $sql))
            print(mysqli_info($conn));
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function updateList($conn, $list, $user_id)
{
}
