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

// If list array is empty delete all record from db
if (empty($list)) {
    // Delete records from ratings
    $sql = "DELETE ratings FROM ratings INNER JOIN lists ON ratings.list_id = lists.id WHERE owner_id = $user_id";
    if (mysqli_query($mysql_conn, $sql)); // Delete send successfully
    else
        echo "Error: " . $sql . "<br>" . mysqli_error($mysql_conn);

    // Delete record from lists
    $sql = "DELETE FROM lists WHERE owner_id = $user_id";
    if (mysqli_query($mysql_conn, $sql)); // Delete send successfully
    else
        echo "Error: " . $sql . "<br>" . mysqli_error($mysql_conn);

    // Redirect to index.php page after deleting data
    header('Location: index.php');
    exit;
}


// If list doesn't exist in DB create it and insert all album's positions. Else update the existing list
$sql = "SELECT * FROM lists WHERE owner_id = $user_id";
$result = mysqli_query($mysql_conn, $sql);
if (mysqli_num_rows($result) == 0) {
    createList($mysql_conn, $list, $user_id);
} else {
    updateList($mysql_conn, $list, $user_id);
}

function createList($conn, $list, $user_id)
{
    // Create record of new list in lists table
    $sql = "INSERT INTO lists (owner_id) VALUES ($user_id)";
    if (mysqli_query($conn, $sql))
        $list_id = mysqli_insert_id($conn);
    else
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    // Insert all albums position to ratings table
    foreach ($list as $album_pos => $album_id) {
        $sql = "INSERT INTO ratings (album_position, album_id, list_id) VALUES (" . ($album_pos + 1) . ", $album_id, $list_id)";
        if (mysqli_query($conn, $sql)); // Insert send successfully
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Redirect to index.php page after inserting data
    header('Location: index.php');
    exit;
}

function updateList($conn, $list, $user_id)
{
    // Get list's id
    $sql = "SELECT id FROM lists WHERE owner_id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $list_id = $row[0];

    // Check if album's position is in ratings table
    foreach ($list as $album_pos => $album_id) {
        $sql = "SELECT id FROM ratings WHERE list_id = $list_id AND album_id = $album_id";
        $result = mysqli_query($conn, $sql);

        // If there is no record of album's position, create it
        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO ratings (album_position, album_id, list_id) VALUES (" . ($album_pos + 1) . ", $album_id, $list_id)";
            if (mysqli_query($conn, $sql)); // Insert send successfully
            else
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        // If album's position is recorded, update it
        else {
            $sql = "UPDATE ratings SET album_position = " . ($album_pos + 1) . " WHERE list_id = $list_id AND album_id = $album_id";
            if (mysqli_query($conn, $sql)); // Update send successfully
            else
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // If there is record of album's position which was not included in list array, delete it
    // 1. Find all record's id which albums are not include in list array but are present in database and put them in array
    $all_albums_id = "";
    foreach ($list as $album_pos => $album_id) {
        $all_albums_id .= $album_id . ", ";
    }
    $all_albums_id = substr($all_albums_id, 0, -2);
    $sql = "SELECT ratings.id FROM ratings WHERE list_id = $list_id AND album_id NOT IN ($all_albums_id)";
    $result = mysqli_query($conn, $sql);
    $found_ids = [];
    while ($row = mysqli_fetch_array($result)) {
        array_push($found_ids, $row[0]);
    }
    // 2. Delete all found ids
    foreach ($found_ids as $id) {
        $sql = "DELETE FROM ratings WHERE id = $id";
        if (mysqli_query($conn, $sql)); // Delete send successfully
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Redirect to index.php page after inserting data
    header('Location: index.php');
    exit;
}
