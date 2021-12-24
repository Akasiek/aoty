const listTbodyDOM = document.getElementById("list_tbody");
let list = [];

function addToList(id, album, artist, cover) {
    const albumCheckbox = document.getElementById("album_" + id); // Create reference to checkbox from search result table

    if (albumCheckbox.checked) {
        // If checkbox checked add corresponding album object to the list array
        list.push({
            id: id,
            albumName: album,
            artistName: artist,
            coverartUrl: cover,
        });
    }
    if (albumCheckbox.checked == false) {
        // If checkbox unchecked push album object from the list array
        list.forEach(function (obj, i) {
            if (obj["id"] == id) list.splice(i, 1);
        });
    }
    renderList();
}

// Render all elements of user's list.
function renderList() {
    listTbodyDOM.innerHTML = ""; // Reset list results

    // For each added album create row with position, album name, etc.
    list.forEach(function (obj, i) {
        let newRow = listTbodyDOM.insertRow();
        let positionCell = newRow.insertCell();
        let artistNameCell = newRow.insertCell();
        let albumNameCell = newRow.insertCell();
        let coverartUrlCell = newRow.insertCell();

        positionCell.innerHTML =
            i + 1 + ". <button onclick='moveAlbumUp(" + i + ")'>▲</button><button onclick='moveAlbumDown(" + i + ")'>▼</button></div></div>";
        artistNameCell.innerHTML = obj["artistName"];
        albumNameCell.innerHTML = obj["albumName"];
        coverartUrlCell.innerHTML = "<img src='" + obj["coverartUrl"] + "'>";
    });
}

// Create temporary JSON file containing list array. This way PHP can add it to DB
function saveListToDB() {
    let smallList = [];
    list.forEach(function (obj, i) {
        smallList.push(obj["id"]);
    });
    let listJSON = JSON.stringify(smallList);
    document.getElementById("json_data").value = listJSON;
}

// Move album up the position
function moveAlbumUp(i) {
    if (i == 0) alert("Album is already on the top");
    else {
        let x = list[i];
        list[i] = list[i - 1];
        list[i - 1] = x;
        renderList();
    }
}

// Move album down the position
function moveAlbumDown(i) {
    if (i == list.length - 1) alert("Album is already on the bottom");
    else {
        let x = list[i];
        list[i] = list[i + 1];
        list[i + 1] = x;
        renderList();
    }
}
