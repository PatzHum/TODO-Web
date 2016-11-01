<?php
    require_once "db.php";
    session_start();
    $assign_list = 0;
    if (isset($_SESSION["uid"])){
        $assign_list = get_current_assignments($_SESSION["uid"]); 
    }
?>

<html>
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

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
             })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-82380260-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
    <style>
        .datetime{
            position: absolute;
            top:70%;
            left:10%;
        }
        .clock{
            font-size: 100px;
            position: relative;
        }
        .date{
            font-size: 40px;
            position: relative;
        }
        .welcome{
            background:none;
            position:absolute;
            width: 100%;
            padding: 0;
            margin: 0;
            text-align:center;
            top:30%;
            left: 0;
            font-size: 75px;
        }
        .welcome-content{
            background:none;
            font-size: 75px;
            font-family: Abel;
            border:none;
            border-bottom: solid 2px white;
            color:white;
        }
        .tiny-content{
            font-size:10;
        }
        .footer{
            position:absolute;
            width:100%;
            padding: 0;
            margin: 0;
            bottom:1%;
            right:1%;
            text-align:right;
            cursor:pointer;
        }
        .link{
            font-size: 30px;
            width:100%;
            position:relative;
            display:block;
            text-align:center;
            color:white;
            text-decoration:none;
        }
        .link:visited{
            color:white;
        }
        .link:hover{
            color:white;
            font-weight:bold;
        }
        .link.active{
            color:white;
            font-weight:normal;
        }
        .welcome-header{
            margin-bottom:5%;
        }
        input{
            color:white;
        }
        body{
            background-image: url("img/Scape.jpg");
            background-size: cover;
            background-attachment: fixed;
            transition:3s;
            background-position: center center;
            background-repeat: no-repeat;
            background-color: #232323;
            font-family: Abel, serif;
            color:white;
            text-shadow: 0px 0px 30px rgba(0,0,0, .5);
            height:100%;
        }
        .greyout{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0, 0, 0, .2);
            padding:0;
            margin:0;
        }
        .whiteout{
            position:absolute;
            top:0;
            left:0;
            width:100%; 
            height:100%;
            background:rgba(255, 255, 255, .5);
            padding:0;
            margin:0;
            z-index:-1;

        }
        body, html{
            padding:0;
            margin:0;
            overflow:hidden;
        } 
        .task-item{
            color:black;
            text-shadow:none;
        }
        .smooth-transition{
            transition: 1s;
            -webkit-transition: 1s;
        }
        .toggle-bar{
            position: absolute;
            right: 0;
            top:50%;
            transform:translateY(-50%);
            height:7%;
            width:30px;
            line-height: 100%;
            background:rgba(0,0,0,.2);
            color: white;
            border-radius:10% 0% 0% 10%;
            text-align:center;
        }
    </style>
    <body  onselectstart="return false;" ondragstart="return false;" style="cursor:default;">
        <div id="main-content" class="smooth-transition col-md-9" style="height:100%;width:100%;">
        <div class="greyout"></div>
        <div id="name-wrapper" class="welcome">
            <div id="welcome" class="welcome-header" >Good day</div>
            <a href="https://google.com" class="link">Google</a>
            <a href="https://facebook.com" class="link">Facebook</a>
            <a href="https://youtube.com" class="link">Youtube</a>
        </div>
        <p id="change-name" style="display: none" class="footer tiny-content" onclick="resetName()">Change Name</p>
        <div id="new-user" class="welcome" style="display: none">
            <input type="text" class="welcome-content" id="user-name" placeholder="Hi, my name is "/>
            <input type="button" class="welcome-content" onclick="submit_new_user()" value="Submit"/>
        </div>
        <div class="datetime">
            <div id="clock" class="clock">
            </div>
            <div id="date" class="date">
            </div>
        </div>
        <div class="toggle-bar" onclick="toggleTasks()">
           <h1 id="toggle-bar-text">&#10092;</h1> 
        </div>
        </div>
        <div id="sidebar" class="smooth-transition col-md-3" style="height:100%; width:0;">
            <div class="whiteout">&nbsp;</div>
            &nbsp;
            <?php
                if ($assign_list != 0){
?>
                    <h2>Upcoming Tasks</h2>
<?php
                    foreach ($assign_list as $assign){
                        echo "<h4 class=\"task-item\">" . $assign["name"] . " " . $assign["details"] . "</h4>";
                    } 
                }else{
?>
                <form action="login.php" method="post">
                    <input type="hidden" name="redir" value="home.php"/>
                    <input type="submit" class="btn btn-default" value="Login"/>
                </form>
<?php
                }
            ?>
        </div>
    </body>

    <script> 
        var sidebar_shown = false;
        function toggleTasks(){
            if (sidebar_shown){
                hideTasks();
            }else{
                showTasks();
            }
            sidebar_shown = !sidebar_shown;
        }
        function hideTasks(){
            $("#sidebar").fadeOut();
            $("#sidebar").css("width", "0%");
            $("#main-content").css("width", "100%");
            $("#toggle-bar-text").html("&#10092;");
        }
        function showTasks(){
            $("#sidebar").fadeIn();
            $("#sidebar").css("width", "25%");
            $("#main-content").css("width", "75%");
            $("#toggle-bar-text").html("&#10093;");

        }
        var str_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        var str_months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function parseCookie(){
            var raw = document.cookie;
            var broken = raw.split(';');
            var parsed = [];
            for (i = 0; i < broken.length; ++i){
                var j = broken[i].split('=');
                if (j.length != 2){
                    continue;
                }else{
                    parsed[j[0].trim()] = j[1].trim();
                }
            }
            return parsed;
        }

        function buildCookie(data){
            var built = "";
            for (var i in data){
                built =  built  + i + "=" + data[i] + " "; 
            }
            document.cookie = built;
        }

        var cookieData = parseCookie();
        

        function submit_new_user(){
            document.cookie = "name=" + document.getElementById("user-name").value;
            setTimeout(location.reload(), 100);
        }
        
        var bgs = ["Scape.jpg", "tundra.jpg", "bridge.jpeg", "mountain.jpg", "brooklyn.jpg", "nightscape.jpeg", "water.jpeg"];
        bgs.forEach(function(img){
                new Image().src = "img/" + img;
        });
        function fade_bg(index){
             
            $(document.body).css("background-image", "url(img/" + bgs[index % bgs.length] + ")");
            setTimeout(function(){
                    fade_bg(index + 1);
                }, 120000);
        }
        fade_bg(Math.floor(Math.random() * bgs.length));
        function updateClock(){
            var time = document.getElementById("clock");
            var date = document.getElementById("date");

            var d = new Date();
            time.innerHTML = d.getHours() + ":" + ("0" + d.getMinutes()).slice(-2);

            date.innerHTML = str_days[d.getDay()] + ", " + str_months[d.getMonth()] + " " + d.getDate() + " " + d.getFullYear();
             
            if (cookieData.hasOwnProperty("name") && cookieData['name'] != ""){
                var TOD = "Evening";
                if (d.getHours() < 12){
                    TOD = "Morning"
                     
                }else if (d.getHours() >= 12 && d.getHours() < 18){
                    TOD = "Afternoon"
                }
                document.getElementById("welcome").innerHTML = "Good " + " " + TOD + ", " + cookieData["name"];
                document.getElementById("change-name").style="";
            }else{
                document.getElementById("new-user").style="";
                document.getElementById("name-wrapper").style="display: none";
            }

            setTimeout(updateClock, 1000);
        }

        function resetName(){
            cookieData["name"] = "";
            buildCookie(cookieData);
            location.reload();
        }

        updateClock();
        hideTasks();
   </script>
</html>


