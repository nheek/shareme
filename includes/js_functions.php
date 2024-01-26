<!-- Imports the jQuery library for AJAX operations -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
/**
 * Changes the URL using the History API, allowing for updating the URL without a page reload.
 *
 * @param {string} newURL - The new URL to set.
 * @param {string|null} newTitle - The new title for the page (default is null).
 *
 * @example
 * // Change the URL to '/new-page' with the title 'New Page Title'
 * changeURL('/new-page', 'New Page Title');
 */
function changeURL(newURL, newTitle = null) {
    // Use the History API to change the URL
    history.pushState({}, newTitle, newURL);
}

/**
 * Retrieves content from a specified URL and updates the content of an HTML element with the received data.
 *
 * @param {string} elementID - The ID of the HTML element to update with the retrieved content.
 * @param {string} pageUrl - The URL from which to retrieve content.
 *
 * @example
 * // Get content from '/pages/about.html' and update the element with ID 'contentContainer'
 * getPage('contentContainer', '/pages/about.html');
 */
function getPage(elementID, pageUrl) {
    const xmlhttp = new XMLHttpRequest();

    // Event listener for when the XMLHttpRequest completes
    xmlhttp.onload = function() {
        // Update the specified HTML element with the received content
        document.getElementById(elementID).innerHTML = this.responseText;
    };

    // Configure the XMLHttpRequest to retrieve content from the specified URL
    xmlhttp.open("GET", pageUrl);

    // Send the XMLHttpRequest to initiate the content retrieval
    xmlhttp.send();
}

/**
 * Retrieves the current URL of the browser.
 *
 * @returns {string} The current URL.
 *
 * @example
 * // Get the current URL and log it to the console
 * const currentURL = getCurrentURL();
 * console.log(currentURL);
 */
function getCurrentURL() {
    return window.location.href;
}
</script>