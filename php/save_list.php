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

// How Points are Measured
// https://www.albumoftheyear.org/list/summary/2021/#:~:text=How%20Points%20are%20Measured
function get_points($pos)
{
    switch ($pos) {
        case 1:
            return 10;
        case 2:
            return 8;
        case 3:
            return 6;
        case ($pos > 3 && $pos <= 10):
            return 5;
        case ($pos > 10 && $pos <= 25):
            return 3;
        default:
            return 1;
    }
}

// If list array is empty delete all record from db
if (empty($list)) {
    // Get position of all albums to decrease points from leaderboard
    $sql = "SELECT album_position, album_id FROM ratings
    INNER JOIN lists ON ratings.list_id = lists.id
    WHERE owner_id = $user_id
    ORDER BY album_position ASC";
    $result = mysqli_query($mysql_conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql = "UPDATE leaderboard
                SET score = score - " . get_points($row["album_position"]) . "
                WHERE album_id = " . $row["album_id"];
        if (mysqli_query($mysql_conn, $sql)); // Leaderboard updated successfully
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

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
    header('Location: ../index.php');
    exit;
}


// If list doesn't exist in DB create it and insert all album's positions. Else update the existing list
$sql = "SELECT * FROM lists WHERE owner_id = $user_id";
$result = mysqli_query($mysql_conn, $sql);
if (mysqli_num_rows($result) == 0) {
    create_list($mysql_conn, $list, $user_id);
} else {
    update_list($mysql_conn, $list, $user_id);
}

function create_list($conn, $list, $user_id)
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

    // Get position of all albums to increase points in leaderboard
    $sql = "SELECT album_position, album_id FROM ratings
    INNER JOIN lists ON ratings.list_id = lists.id
    WHERE owner_id = $user_id
    ORDER BY album_position ASC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        // Update the score of the record with same album_id as our result
        // In leaderboard there is always a record for every album from albums table
        $sql = "UPDATE leaderboard
        SET score = score + " . get_points($row["album_position"]) . "
        WHERE album_id = " . $row["album_id"];
        if (mysqli_query($conn, $sql)); // Leaderboard updated successfully
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


    // Redirect to index.php page after inserting data
    header('Location: ../index.php');
    exit;
}

function update_list($conn, $list, $user_id)
{
    // Get list's id
    $sql = "SELECT id FROM lists WHERE owner_id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $list_id = $row[0];

    // Check if album's position is in ratings table
    foreach ($list as $album_pos => $album_id) {
        // $album_pos is really a index so code should always add 1 to it to get exact position
        $sql = "SELECT id FROM ratings WHERE list_id = $list_id AND album_id = $album_id";
        $result = mysqli_query($conn, $sql);

        // If there is no record of album's position, create it
        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO ratings (album_position, album_id, list_id) VALUES (" . ($album_pos + 1) . ", $album_id, $list_id)";
            if (mysqli_query($conn, $sql)); // Insert send successfully
            else
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);

            // Add new points for this album to leaderboard
            $sql = "UPDATE leaderboard
            SET score = score + " . get_points($album_pos + 1) . "
            WHERE album_id = $album_id";
            if (mysqli_query($conn, $sql)); // Leaderboard updated successfully
            else
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // If album's position is recorded, update it to the new one
        else {
            // Get old position. Needed for leaderboard update
            $sql = "SELECT album_position FROM ratings WHERE album_id = $album_id AND list_id = $list_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_row($result);
            $old_pos = $row[0];
            // Create variable with diffrence of two positions points
            $points_diff = get_points($album_pos + 1) - get_points($old_pos);

            // Update score in leaderboard for this album with position diffrence and only if diffrence != 0
            if ($points_diff != 0) {
                $sql = "UPDATE leaderboard
                SET score = score + " . $points_diff . "
                WHERE album_id = $album_id";
                if (mysqli_query($conn, $sql)); // Leaderboard updated successfully
                else
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            // Change position in ratings table
            $sql = "UPDATE ratings SET album_position = " . ($album_pos + 1) . " WHERE list_id = $list_id AND album_id = $album_id";
            if (mysqli_query($conn, $sql)); // Update send successfully
            else
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // If there is record of album's position which was not included in list array, delete it
    // 1. Find all record's id which albums are not include in list array but are present in database and put them in array.
    // Also store album_position for leaderboard update
    $all_albums_id = "";
    foreach ($list as $album_pos => $album_id) {
        $all_albums_id .= $album_id . ", ";
    }
    $all_albums_id = substr($all_albums_id, 0, -2);
    $sql = "SELECT ratings.album_id, ratings.album_position FROM ratings WHERE list_id = $list_id AND album_id NOT IN ($all_albums_id)";
    $result = mysqli_query($conn, $sql);
    $found_ids = [];
    while ($row = mysqli_fetch_array($result)) {
        $found_ids[$row["album_id"]] = $row["album_position"];
    }
    // 2. Delete all found album_ids from ratings table and update the leaderboard
    foreach ($found_ids as $album_id => $album_pos) {
        $sql = "DELETE FROM ratings WHERE album_id = $album_id AND list_id = $list_id";
        if (mysqli_query($conn, $sql)); // Delete send successfully
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);

        $sql = "UPDATE leaderboard SET score = score - " . get_points($album_pos) . " WHERE album_id = $album_id";
        if (mysqli_query($conn, $sql)); // Leaderboard updated successfully
        else
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Redirect to index.php page after inserting data
    header('Location: ../index.php');
    exit;
}
