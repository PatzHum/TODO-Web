
<?php
    session_start();
    if (!isset($_SESSION["uid"])){
        header("Location: login.php");
        exit();
    }

    /*
    * Gets request type and appends to db accordingly*/
    require_once "auth.php";
    require_once "db.php";

    if (isset($_POST["req"])){
        CleanString($_POST["req"]);
        $req = $_POST["req"];

        if ($req == "assign"){
            if (isset($_POST["name"]) && isset($_POST["details"]) && isset($_POST["due"]) && isset($_POST["url"]) && isset ($_POST["uid"])){
                add_assignment($_POST["name"], $_POST["details"], $_POST["due"], $_POST["url"], $_POST["uid"]); 
            }
        }else if ($req == "mark-done"){
            if (isset($_POST["rid"])){
                mark_done($_POST["rid"]);
            }
        }else if ($req == "poolassign"){
            if (isset($_POST["name"]) && isset($_POST["details"]) && isset($_POST["due"]) && isset($_POST["url"]) && isset ($_POST["uid"]) && isset($_POST["pid"])){
                add_pool_assignment($_POST["name"], $_POST["details"], $_POST["due"], $_POST["url"], $_POST["uid"], $_POST["pid"]); 
            }
        }else if ($req == "take"){
            if (isset($_POST["rid"])){
                take_assignment($_SESSION["uid"], $_POST["rid"]);
            }
        }else if ($req == "join"){
            if (isset($_POST["pname"])){
                join_pool($_SESSION["uid"], $_POST["pname"]);
            }
        }else if ($req == "leave"){
            if (isset($_POST["pid"])){
                leave_pool($_SESSION["uid"], $_POST["pid"]);
            } 
        } 
    }
    if (isset($_POST["redir"])){
        header("Location: " . $_POST["redir"]);
    }else{
        header("Location: ../index.php");
    }
?>
