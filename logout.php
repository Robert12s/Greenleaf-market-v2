<?php

     /** 
    * @author Robert Twelves
    * @created 10/03/2025
    */

    // Destroy all session data
    session_unset();
    session_destroy();

    // Ensure cookies are deleted
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }

    // Redirect to login page
    header("Location: /login");
    exit;
?>
