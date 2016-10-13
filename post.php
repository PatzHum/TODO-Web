<?php
    require_once "auth.php";
    require_once "db.php";

    if (isset($_POST["req"])){
        CleanString($_POST["req"]);
        $req = $_POST["req"];

        if ($req == "assign"){
            if (isset($_POST["name"]) && isset($_POST["details"]) && isset($_POST["due"]) && isset($_POST["url"]) && isset ($_POST["uid"])){
                add_assignment($_POST["name"], $_POST["details"], $_POST["due"], $_POST["url"], $_POST["uid"]); 
            }
        }
    }
    header("Location: current.php");
?>
