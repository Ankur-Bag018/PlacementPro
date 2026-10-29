<?php
// 1. Start the session so we can access the current user's session data
session_start();

// 2. Unset all of the session variables (removes gmail_id, role, full_name, etc.)
session_unset();

// 3. Destroy the session completely on the server
session_destroy();

// 4. (Optional but recommended) Delete the session cookie from the browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 5. Redirect the user back to the main landing page
// If your main homepage is named index.html instead of index.php, change it below.
header("Location: index.php");
exit();
?>