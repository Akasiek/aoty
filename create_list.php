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
    $file_path = 'lists/list_' . $_POST["username_input"] . '.json';
    // If json file for this user doesn't exist, create it.
    if (!file_exists($file_path)) {
        $json_content = ["owner" => $_POST["username_input"]];
        $json_content = json_encode($json_content);
        $json_file = fopen($file_path, 'x');
        fwrite($json_file, $json_content);
        fclose($json_file);
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