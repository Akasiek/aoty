<?php
require "conn.php";

// Select all saved positions from list and albums assigned to it
$sql = "SELECT ratings.album_position, albums.id, albums.title, artists.name, albums.coverart_url FROM ratings
INNER JOIN albums ON ratings.album_id = albums.id
INNER JOIN lists ON ratings.list_id = lists.id
INNER JOIN users ON lists.owner_id = users.id
INNER JOIN artists ON albums.artist_id = artists.id
WHERE users.username = '" . $_GET["username"] . "'
ORDER BY ratings.album_position ASC";
$result = mysqli_query($mysql_conn, $sql);

// Make array of objects similiar to JS one
$loaded_list = [];
while ($row = mysqli_fetch_array($result)) {
    $parent = new stdClass;
    $parent->id = (int)$row["id"];
    $parent->albumName = $row["title"];
    $parent->artistName = $row["name"];
    $parent->coverartUrl = $row["coverart_url"];
    $loaded_list[$row["album_position"] - 1] = $parent;
}

// Send as JSON file
$reply = json_encode($loaded_list);
header("Content-Type: application/json; charset=UTF-8");
echo $reply;
