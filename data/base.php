<?php
    /*
     * Makes sure the user is logged in, else redirect to login page
     * Includes
     *      Bootstrap (CDN)
     *      JQuery (CDN)
     */
    require_once "db.php";
    session_start();

    if (!isset($_SESSION["uid"])){
        header("Location: login.php");
        exit();
    }
    include "styles.php";
?>


