<script>
    var newItem = document.getElementById("new-item");
    let link = "/?link=" + "<?php echo $_SESSION["link"] ?>";
    let linkNaked = "<?php echo $_SESSION["link"] ?>";

    // Initial load for the checklist
    getPage("checklist", "../../../pages/checklist.php");

    function addItem() {
        console.log("add ran")
        // Get the input value
        var item = newItem.value;

        // Get the title for the current list
        var title = "<?php echo getListTitle($_SESSION["link"]) ?>";

        // Get the element with ID 'empty'
        var empty = document.getElementById("empty");

        // If 'empty' exists, remove it
        if (empty) {
            empty.remove();
        }

        // Ignore empty input
        if (item.trim() == "") {
            return;
        }

        // Create a new list item
        var listItem = document.createElement("li");

        // Create a new checkbox
        var checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.id = "<?php echo getLatestItemID() ?>";
        checkbox.setAttribute("onclick", "check(" + checkbox.id + ");");
        checkbox.name = "items";
        checkbox.value = item;

        // Create a new label for the checkbox
        var label = document.createElement("label");
        label.setAttribute("contenteditable", "true");
        label.setAttribute("oninput", "editItem(" + checkbox.id + ");");
        label.innerText = item;

        // Append checkbox and label to the list item
        listItem.appendChild(checkbox);
        listItem.appendChild(label);

        // Ajax part to add item to the server
        $.ajax({
            url: '/xhr/general.php?f=general&s=add-item',
            type: 'POST',
            data: {
                linkNaked: linkNaked,
                item: item
            },
            success: function(data) {
                if (data == "success") {
                    console.log("add item working")
                    // If server response is 'success', append the list item to the checklist
                    document.getElementById("checklist").appendChild(listItem);

                    // Clear the input field for the next item
                    document.getElementById("new-item").value = "";
                }
            }, error: function(data) {
                console.log("add item not working");
            }
        });

        // If the title is empty, make an Ajax request to add a title
        if (title == "") {
            $.ajax({
                url: '/xhr/general.php?f=general&s=add-title',
                type: 'POST',
                data: {
                    linkNaked: linkNaked
                }
            });
        }
    }

    newItem.addEventListener("keypress", function(event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            addItem();
        }
    });

    // Change the current url based on the list ID which is auto-generated
    changeURL(link);

    // Checks item out/in to the list
    function check(itemID) {
        var item = document.getElementById(itemID);
        var setTo = ""
        if (item.checked) {
            setTo = "true";
        } else {
            setTo = "false";
        }

        $.ajax({
            url: '/xhr/general.php?f=general&s=check-item',
            type: 'POST',
            data: {
                itemID: itemID,
                setTo: setTo
            }
        })
    }

    // Handles the item editing logic
    function editItem(itemID) {
        // Get the elements by their IDs
        var itemEl = document.getElementById("l" + itemID);
        var inputEl = document.getElementById(itemID);

        // Get the current text content of the item
        var item = document.getElementById("l" + itemID).innerText;

        // Ajax request to update the item on the server
        $.ajax({
            url: '/xhr/general.php?f=general&s=edit-item',
            type: 'POST',
            data: {
                itemID: itemID,
                item: item
            }
        });

        // Check if the item is empty
        if (item == "") {
            // Ajax request to delete the item on the server
            $.ajax({
                url: '/xhr/general.php?f=general&s=delete-item',
                type: 'POST',
                data: {
                    itemID: itemID
                },
                success: function(data) {
                    // If server response is 'success', remove the input and item elements
                    if (data == "success") {
                        inputEl.remove();
                        itemEl.remove();
                    }
                }
            });
        }
    }


    // Create a new list
    function newList() {
        // Get the title element
        var title = document.getElementById("title");

        // Ajax request to create a new list on the server
        $.ajax({
            url: '/xhr/general.php?f=general&s=new-list',
            type: 'POST',
            data: {},
            success: function(data) {
                // If server response is not empty
                if (data) {
                    // Construct the new link and update global variables
                    link = "/?link=" + data;
                    linkNaked = data;

                    // Change the URL in the browser
                    changeURL("/?link=" + data);

                    // Load the checklist page content
                    getPage("checklist", "pages/checklist.php");

                    // Set the default title for the new list
                    title.innerText = "Title";
                }
            }
        });
    }

    // Edit the title of the current list
    function editTitle() {
        // Get the text content of the title element
        var title = document.getElementById("title").innerText;

        // Ajax request to update the title on the server
        $.ajax({
            url: '/xhr/general.php?f=general&s=add-title',
            type: 'POST',
            data: {
                linkNaked: linkNaked,
                title: title
            }
        });
    }


    // Function to copy the current URL to the clipboard
    function copyURL() {
        // Use the Clipboard API to write the current URL to the clipboard
        navigator.clipboard.writeText(getCurrentURL());

        // Get the copy link button element
        let copyButton = document.getElementById("copy-link");

        // Change the button text to indicate successful copying
        copyButton.innerText = "Link copied";

        // Reset the button text after 5 seconds
        setTimeout(() => {
            copyButton.innerText = "Copy link";
        }, 5000);
    }
</script>