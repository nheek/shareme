<?php

// Include configuration file for database connection
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

/**
 * Generates a random string of characters.
 *
 * @param int $length The length of the random string (default: 8).
 * @return string The generated random string.
 */
function generateRandomCharacters($length = 8)
{
    // Define the character pool containing letters (both uppercase and lowercase) and numbers
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    // Get the length of the character pool
    $poolLength = strlen($characters);

    // Initialize an empty string to store the random characters
    $randomString = '';

    // Generate random characters
    for ($i = 0; $i < $length; $i++) {
        // Get a random index within the character pool
        $randomIndex = rand(0, $poolLength - 1);

        // Append the character at the random index to the random string
        $randomString .= $characters[$randomIndex];
    }

    return $randomString;
}

/**
 * Retrieves items associated with a specific link from the database.
 *
 * @param string $link The link to retrieve items for.
 * @return mixed Returns the result set if items are found, otherwise null.
 */
function getItems($link)
{
    global $sqlConnect;

    // SQL query to select items for the given link
    $sql = "SELECT * FROM Items WHERE link = '{$link}' ORDER BY id";

    // Execute the query
    $result = $sqlConnect->query($sql);

    // Check if any rows were found
    if ($result->num_rows > 0) {
        // Return the result set
        return $result;
    }

    // Return null if no items are found
    return null;
}

/**
 * Retrieves the latest available item ID from the "Items" table.
 *
 * @return int The latest item ID.
 */
function getLatestItemID()
{
    global $sqlConnect;

    // SQL query to get the latest ID from the "Items" table
    $sql = "SELECT COALESCE(MAX(id), 0) + 1 AS latest_id FROM Items";

    // Execute the query
    $result = $sqlConnect->query($sql);

    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Return the latest ID
    return $row['latest_id'];
}


/**
 * Checks if a given link already exists in the "Items" table.
 *
 * @param string $link The link to check for existence.
 * @return bool True if the link exists, false otherwise.
 */
function checkIfLinkExists($link)
{
    global $sqlConnect;

    // SQL query to check if the link exists
    $sql = "SELECT COUNT(*) AS link_count FROM Items WHERE link = '{$link}'";

    // Execute the query
    $result = $sqlConnect->query($sql);

    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Return true if the link count is greater than 0, indicating existence
    return ($row['link_count'] > 0);
}


/**
 * Generates a unique link by repeatedly calling generateRandomCharacters
 * until a unique link is obtained using checkIfLinkExists.
 *
 * @return string The generated unique link.
 */
function generateLink()
{
    // Generate an initial random link
    $link = generateRandomCharacters();

    // Check if the generated link already exists
    if (!checkIfLinkExists($link)) {
        // If the link does not exist, return it
        return $link;
    } else {
        // If the link already exists, recursively call the function to generate a new one
        // Note: Recursion is used to ensure uniqueness, but it's important to consider a maximum number of attempts
        return generateLink();
    }
}

/**
 * Retrieves the title associated with a specific link from the database.
 *
 * @param string $link The link to retrieve the title for.
 * @return string The title associated with the link.
 */
function getListTitle($link)
{
    global $sqlConnect;

    // SQL query to select the title for the given link
    $sql = "SELECT * FROM Titles WHERE link = '{$link}'";

    // Execute the query
    $result = $sqlConnect->query($sql);

    // Check if any rows were found
    if ($result->num_rows > 0) {
        // Return the title associated with the link
        return $result->fetch_assoc()["title"];
    }

    // Return an empty string if no title is found
    return '';
}
