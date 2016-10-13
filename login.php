<html>
<head>
    <!-- Bootstrap Includes -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!--Roboto-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300|Roboto+Condensed" rel="stylesheet">
</head>
<style>
    .error-bar{
        width:100%;
        padding-top:1%;
        padding-bottom:1%;
        background-color:#ff9999;
        text-align:center;
        color:white;
    }
    body, html{
        font-family:"Roboto Condensed", sans-serif;
        color:black;
    }
    h1, h2, h3, h4, h5, h6{
        font-family:"Roboto", sans-serif;
    }
    
</style>

<?php
    require_once "db.php";
    if (isset($_POST["username"]) && isset($_POST["password"])){
        $uid = login($_POST["username"], $_POST["password"]);
        if ($uid >= 0){
            session_start();
            $_SESSION["uid"] = $uid;
            header("Location: "."current.php");
        }else{
?>
    <div class="error-bar">
        Invalid Login.
    </div> 
<?php
        } 
    } 
?>


<body>
    <div class="Container">
        <div class="col-md-4 col-md-push-4 ">
            <h1>Login</h1>
            <form action="login.php" method="post">  
                <input class="form-control" type="text" name="username" placeholder="Username"/><br/>
                <input class="form-control" type="password" name="password" placeholder="Password"/><br/>
                <input class="form-control" type="submit" value="Submit"/>
            </form>
            <p class="text-center"> <a href="register.php">Register</a> </p>
        </div>
    </div>
</body>
</html>

