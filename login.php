<head>
    <!-- Bootstrap Includes -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!--Roboto-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300|Roboto+Condensed" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="data/css/general.css">
</head>

<style>
    html, body{
        font-family:"Roboto Condensed", sans-serif;
    }
    body{
        background:url("/data/img/login_bg.jpg");
        background-size:cover;
    }

    .error-bar{
        width:100%;
        padding-top:1%;
        padding-bottom:1%;
        background-color:#ff9999;
        text-align:center;
        color:white;
    }
    
    h1, h2, h3, h4, h5, h6{
        font-family:"Roboto", sans-serif;
    }
    .maincol{
        background:none;
    }
    .side-logo{
        padding-top:3%;
        padding-bottom:3%;
        text-align:center;
        background:linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0));;
        color:white;        
    }
    .side-logo h1{
        font-size: 6em;
        font-weight:100;
        font-family:Roboto;
        text-shadow:3px 3px 15px black;
        width:100%;
        }
    
    @media (max-width:991px){
        .side-logo{
            display:none;
        }
        body{
            margin-top:0;
        }
        .maincol{
            height:100%;
        } 
        .vcenter{
            height:100%;
        }
    }
    .vcenter{
        background:rgba(12,31,47,0.96);
        padding:3%;
        box-shadow:0px 0px 10px black;
        left:50%;
        color:white;
        transform:translateX(-50%);
    }
</style>

<?php
    require_once "data/db.php";
    if (isset($_POST["username"]) && isset($_POST["password"])){
        $uid = login($_POST["username"], $_POST["password"]);
        if ($uid >= 0){
            session_start();
            $_SESSION["uid"] = $uid;
            if (isset($_POST["redir"])){
                header("Location: " . $_POST["redir"]);
            }else{
                header("Location: /");
            }
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
    <div class="side-logo">
        <h1>Todo</h1>
        <p>Stay on track</p>
    </div>
    <div class="maincol">
        <div class="col-md-3 vcenter">
            <h1>Login</h1>
            <form action="login.php" method="post">  
                <input class="form-control" type="text" name="username" placeholder="Username"/><br/>
                <input class="form-control" type="password" name="password" placeholder="Password"/><br/>
                <input class="form-control" type="submit" value="Login"/>
<?php
                if (isset($_POST["redir"])){
?>
                    <input type="hidden" name="redir" value="<?php echo $_POST["redir"]; ?>"/>
<?php
                }   
?>
            </form>
            <p class="text-center"> <a href="register.php">Register</a> </p>
        </div>
    </div>
</body>
</html>

