<body>
    <h2 id="title" contenteditable="true" oninput="editTitle();">
        <?php if (getListTitle($_SESSION["link"])) {
            echo getListTitle($_SESSION["link"]);
        } else {
            echo "Title";
        } ?>
    </h2>

    <section id="main">
        <button id="copy-link" onclick="copyURL();">Copy link</button>
        <button id="new-list" onclick="newList();">New list</button>
        <div id="list-container">
            <ul id="checklist">
            </ul>
        </div>
        <input type="text" id="new-item" placeholder="Enter new item">
    </section>

    <a id="sitename" href="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
        <h1>ShareMe</h1>
    </a>
    <?php if ($fromNheek) { ?>
        <a href="/"><button id="back-to-nheek">Back to www.nheek.com</button></a>
    <?php } ?>
</body>