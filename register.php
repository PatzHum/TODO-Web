<html>
<head>
    <!-- Bootstrap Includes -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
    require "data/db.php";
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password-verify"]) && isset($_POST["g-recaptcha-response"])){
        $catch = verify_captcha($_POST["g-recaptcha-response"]);
        if ($catch){
            if ($_POST["password"] == $_POST["password-verify"]){
                $resp = register($_POST["username"], $_POST["password"]); 
                if ($resp == 1){
                    header("Location: login.php");
                }else if ($resp == -1){
                    ?>
                    <div class="error-bar">
                        Username already exists.
                    </div>
                    <?php
                }else if ($resp == -2){
                    ?>
                    <div class="error-bar">
                        We are unable to process the request at the moment. Pleas try again later.
                    </div>
                    <?php
                }
            }else{
                ?>
                <div class="error-bar">
                    Passwords must match.
                </div>
                <?php
            }
        }else{
            
            ?>
            <div class="error-bar">
                Captcha Failed.
            </div>

            <?php
        }
    }
    
?>
<body>
     <div class="Container">
        <div class="col-md-6 col-md-push-3 ">
            <h1>Register</h1>
            <form action="register.php" method="post">  
                <input class="form-control" type="text" name="username" placeholder="Username"/><br/>
                <input class="form-control" type="password" name="password" placeholder="Password"/><br/>
                <input class="form-control" type="password" name="password-verify" placeholder="Re-Type Password"/><br/>
                <div class="g-recaptcha" data-sitekey="6Lfx7wgUAAAAAJzDjM89P2N9GMZt2EifLAWpzxrM"></div><br/>
                <input class="form-control" type="submit" value="Submit"/>
            </form>
        </div>
    </div>
   
</body>
</html>
