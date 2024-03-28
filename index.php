<?php
// Include necessary functions and JavaScript functions
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/js_functions.php';

// Start or resume the PHP session

// Check if the 'link' parameter is not set in the URL
if (!isset($_GET["link"])) {
    // If not set, generate a new link and store it in the session
    $_SESSION["link"] = generateLink();
} else {
    // If 'link' is set in the URL, use that value and store it in the session
    $_SESSION["link"] = $_GET["link"];
}

// Check if 'from_nheek' is set in the URL, if not, set it to an empty string
$fromNheek = isset($_GET["from_nheek"]) ? $_GET["from_nheek"] : "";
?>

<!DOCTYPE html>
<html lang="en">

<!-- Import the head here -->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/head.php'; ?>
<!-- Import the body here -->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/body.php'; ?>

</html>

<!-- Import the main script file here -->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/scripts/main.php'; ?>

<style>
    /* Import the main css file here */
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/src/styles/style.css'; ?>
</style>