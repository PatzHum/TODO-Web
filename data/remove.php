<?php
    include "base.php";
    require_once "db.php";

    if (isset($_POST["rid"])){
       deactivate_assignment($_POST["rid"]); 
       header("Location: ../index.php");
    }
?>
