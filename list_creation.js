const listTbodyDOM = document.getElementById("list_tbody");
let list = [];

// Render HTML markup of user's list.
function renderList() {
    listTbodyDOM.innerHTML = ""; // Reset list results

    // For each added album create row with position, album name, etc.
    list.forEach(function (obj, i) {
        let newRow = listTbodyDOM.insertRow();
        let positionCell = newRow.insertCell();
        let artistNameCell = newRow.insertCell();
        let albumNameCell = newRow.insertCell();
        let coverartUrlCell = newRow.insertCell();
        let deleteButtonCell = newRow.insertCell();

        positionCell.innerHTML =
            i + 1 + ". <button onclick='moveAlbumUp(" + i + ")'>▲</button><button onclick='moveAlbumDown(" + i + ")'>▼</button></div></div>";
        artistNameCell.innerHTML = obj["artistName"];
        albumNameCell.innerHTML = obj["albumName"];
        coverartUrlCell.innerHTML = "<img src='" + obj["coverartUrl"] + "'>";
        deleteButtonCell.innerHTML = "<button class='emoji_button' onclick='removeFromList(" + obj["id"] + ")'>❌</button>";
    });
}

function findAlbumInList(id) {
    return list.some((obj) => obj.id == id);
}

function addToList(id, album, artist, cover) {
    // If album is already include in the list return without adding
    if (findAlbumInList(id)) {
        alert("The album is already include in the list");
        return 0;
    }

    // Add album's metadata to list
    list.push({
        id: id,
        albumName: album,
        artistName: artist,
        coverartUrl: cover,
    });

    // Call function which renders HTML markup for the list
    renderList();
}

function removeFromList(id) {
    // Finding and deleting album from the list
    if (findAlbumInList(id)) {
        let index = list.findIndex((obj) => obj["id"] == id);
        list.splice(index, 1);
        renderList();
        return 0;
    }

    // If not found, call alert to user
    alert("The album is not include in the list.");
}

// Create temporary element which contains list array in JSON. This way PHP can add it to DB
function saveListToDB() {
    let smallList = [];
    list.forEach(function (obj, i) {
        smallList.push(obj["id"]);
    });
    let listJSON = JSON.stringify(smallList);
    // Add JSON data to HTML element
    document.getElementById("json_data").value = listJSON;
}

// Move album up the position and render list's markup
function moveAlbumUp(i) {
    if (i == 0) alert("Album is already on the top.");
    else {
        let x = list[i];
        list[i] = list[i - 1];
        list[i - 1] = x;
        renderList();
    }
}

// Move album down the position and render list's markup
function moveAlbumDown(i) {
    if (i == list.length - 1) alert("Album is already on the bottom.");
    else {
        let x = list[i];
        list[i] = list[i + 1];
        list[i + 1] = x;
        renderList();
    }
}
