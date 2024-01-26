<?php
// Include configuration file and necessary functions
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

// Start or resume the PHP session
session_start();
?>

<?php
// Get the list items for the current session link
$content = getItems($_SESSION["link"]);

// Check if there are items in the list
if ($content) {
    // Loop through each result in the list
    while ($result = $content->fetch_assoc()) {
        ?>
        <?php
        // Check if the item is marked as checked
        if ($result["checked"] == "true") {
        ?>
            <li>
                <!-- Checkbox for checked item -->
                <input
                    onclick="check(<?php echo $result['id'] ?>);"
                    type="checkbox"
                    id="<?php echo $result["id"] ?>"
                    name="items"
                    checked
                >
                <!-- 
                    Label for the checked item, with editable content
                    and editItem function
                -->
                <label
                    id="l<?php echo $result["id"] ?>"
                    contenteditable="true"
                    oninput="editItem(<?php echo $result['id'] ?>);"
                >
                    <?php echo $result["item"] ?>
                </label>
            </li>
        <?php } else { ?>
            <li>
                <!-- Checkbox for unchecked item -->
                <input
                    onclick="check(<?php echo $result['id'] ?>);"
                    type="checkbox"
                    id="<?php echo $result["id"] ?>"
                    name="items"
                >
                <!--
                    Label for the unchecked item, with editable content
                    and editItem function
                -->
                <label 
                    id="l<?php echo $result["id"] ?>"
                    contenteditable="true"
                    oninput="editItem(<?php echo $result['id'] ?>);"
                >
                    <?php echo $result["item"] ?>
                </label>
            </li>
        <?php }
    }
} else {
    // Display a message if there are no items in the list
    ?>
    <div id="empty">
        <img src="../assets/question.svg" alt="question mark icon">
        <div id="empty-text">Seems empty here</div>
    </div>
<?php } ?>


<style>
    div#empty {
        text-align: center;
        font-size: 20px;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
</style>