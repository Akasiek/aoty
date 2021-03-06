<?php
require 'conn.php';
$search_input = $_GET['search_input'];

$sql = 'SELECT albums.id, albums.title, artists.name, albums.coverart_url FROM albums
INNER JOIN  artists ON albums.artist_id = artists.id
WHERE title LIKE "%' . $search_input . '%" OR artists.name LIKE "%' . $search_input . '%" LIMIT 10';
$result = mysqli_query($mysql_conn, $sql);

echo '<table><tr><th>Artist</th><th>Title</th><th>Cover Art</th><th></th></tr>';

while ($row = mysqli_fetch_array($result)) {
    $id = $row["id"];
    $artist = $row["name"];
    $album = $row["title"];
    $cover_url = $row["coverart_url"];
    echo '<tr>
    <td>' . $artist . '</td>
    <td>' . $album . '</td>
    <td><img src="' . $cover_url . '"></td>
    <td><button class="emoji_button" onclick="addToList(' . $id  . ', \'' . addslashes($album) . '\', \'' . addslashes($artist) . '\', \'' . addslashes($cover_url) . '\')">➕</button></td>
    </tr>';
}




echo '</table>';
