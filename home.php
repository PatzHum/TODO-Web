<html>
<?php
    session_start();
    include_once "data/styles.php";
    require_once "data/db.php";
    $logged_in = false;
    if (isset($_SESSION["uid"])){
        $assign_list = get_current_assignments($_SESSION["uid"]); 
        $logged_in = true;
    }
?>
<head>
    <title>Home</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
</head>
<style>
    
    html, body{
        font-family: Roboto;
        transition:1s;
        transition-timing-function:ease-in-out;
        margin:0;
    }
    body{
        background:black;
        margin-top:7%
    }
    .tod-greet{
        font-size:3.5em;
        font-family:Roboto;
        width:100%;
        text-align:center;
        white-space:nowrap;
    }
    .clock{
        font-size:7.5em;
        font-family:Roboto;
        width:100%;
        text-align:center;
        font-weight:bold;
    }
    .clock-seconds{
        color:rgba(255,255,255,0.4);
        display:inline;
    }
    .date{
        text-transform:uppercase;
        text-align:center;
    }
    .item{
        width:100%;
        font-size:1.2em;
    }
    .item-name{
        color:rgba(255,255,255,0.8);
        font-weight:bold;
        display:inline;
        width:100%;
    }
    .pad-left{
        padding-left:50px;
    }
    .text-right{
        text-align:right;
    }
    .border-underline{
        border-bottom: 1px solid white;
    }
    .pad-right{
        padding-right:50px;
    }
    .form-textbox{
        margin-bottom: 15px;
        border:none;
        border-bottom: 2px solid white;
        font-size: 1em;
        width:100%;
        background:none;
        font-family:Roboto;
        padding:5px;
    }
    input:-webkit-autofill{
        background:none;
        -webkit-box-shadow: 0 0 0px 1000px white inset;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="tod-greet"></div>
        </div>
        <div class="row">
            <div class="clock"></div>
        </div>
        <div class="row">
            <h1 class="date"></h1>
        </div>

       <div class="col-md-6 col-md-push-3">
<?php
    if ($logged_in){
?>
            <div class="row">
                <h3 class="text-center">Upcoming</h1>
            </div>
            <div class="row">
                <?php
                    $last = "";
                    foreach($assign_list as $assign){
                ?>
                <b>
                <?php
                        $duedate = new DateTime($assign["due"]);
                        $today = new DateTime(date("Y-m-d")); 
                        $diff = $today->diff($duedate);
                        $ddiff = 365 * $diff ->y + 31 * $diff->m + $diff->d;

                        $wdiff = $ddiff . " days";

                        if ($ddiff == 0){
                            $wdiff = "today";
                        }else if($ddiff == 1){
                            $wdiff = "tomorrow";
                        }else if($ddiff > 30){
                            $months = (int)($ddiff / 30); 
                            $wdiff = $months . " month";
                            if ($months > 1){
                                $wdiff = $wdiff . "s";
                            } 
                        }else if ($ddiff > 6){
                            $weeks = floor(($ddiff + 1) / 7);
                            $wdiff = $weeks . " week";
                            if ($weeks > 1){
                                $wdiff = $wdiff . "s";
                            }
                        }
                        if ($wdiff != $last){
                ?>
                <h4 class="nopad border-underline" style="padding-top:5px">
                <b>
                <?php
                            echo $wdiff;
                ?>
                </b>
                </h4>
                <?php
                            $last = $wdiff;
                        }
                ?>
                </b>

                <div class="item">
                <div class="item-name">
                <?php
                        echo $assign["name"];
                ?>
                </div>
                <?php
                        echo ' ' . $assign["details"];
                ?>
                </div>
                <?php
                    }
                ?>
            </div>
<?php
    }else{
?>
        <form action="login.php" method="post">
            <input class="form-textbox" type="text" name="username" placeholder="Username"/><br/>
            <input class="form-textbox" type="password" name="password" placeholder="Password"/><br/>
            <input class="form-control" style="border-radius:0;" type="submit" value="Login"/>
            <input class="hidden" type="hidden" name="redir" value="https://home.hypersystems.me">
        </form>
<?php
    }
?>
        </div>
    </div>
</body>
<script>

    function tod_greet_tool(){
        var time = new Date(); 
        var h = time.getHours();
        var ostring = "Good Morning";
        var bgCol = "rgb(206, 95, 37)";
        if (h >= 18 || h <= 6){
            //Evening from 6PM to 6 AM
            ostring = "Good Evening"; 
            bgCol = "rgb(15, 20, 24)";
        }else if (h >= 12 && h <= 17){
            ostring = "Good Afternoon";
            bgCol = "rgb(37, 132, 206)";
        }
        $(".tod-greet").html(ostring);
        $(".date").html(time.toDateString());
        $("body").css("background", bgCol);
        setTimeout(tod_greet_tool, 60000);
    }
    tod_greet_tool();
    function clock_tool(){
        var time = new Date(); 
        var h = time.getHours();
        var m = time.getMinutes();
        var s = time.getSeconds();

        if (m < 10) {m = "0" + m;}
        if (s < 10) {s = "0" + s;}

        $(".clock").html(h + ":" + m + "<div class=\"clock-seconds\">:" + s + "</div>");

        setTimeout(clock_tool, 500);
    }
    clock_tool();
</script>
</html>
