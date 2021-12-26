<?php
// Hostname of your database. Probably localhost if you're using database installed on your computer
$hostname = '';

// Credentails to your database
$username = '';
$password = '';

// Name of the database in which .sql file from this repo was imported.
$database = '';

$mysql_conn = mysqli_connect($hostname, $username, $password, $database);
if (mysqli_connect_error())
    die('Connect Error');
