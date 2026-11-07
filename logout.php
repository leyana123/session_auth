<?php

include "db.php";

// remove all session variables
$_SESSION = [];

// delte session
if (ini_get("session.use_cookies")) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );

}

// destroy session
session_destroy();

// return to login page
header("Location: index.php");
exit();

?>