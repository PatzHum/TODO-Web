<html>
<?php
    include "data/base.php";
?>
<body>
<style>
    .txt-input{
        width:100%;
        background:rgba(255,255,255,0.1);
        font-size:1.25em;
        padding:15px;
        border:none;
        text-align:center;
        border: 2px solid rgba(255,255,255,0.2);
        margin-bottom:5px;
        margin-top:5px;
    }
    .fill-w{
        width:100%;
        text-align:center;
    }
</style>
<h1 class="header">Join A Pool</h1>
<div class="container">
    
    <form style="padding:0; margin:0;" action="data/post.php" method="post">
        <input type="hidden" name="req" value="join">
         <div class="col-md-4 col-md-push-4">
            <div class="row square-btn-bar"> 
                <a href="index.php"><button class="square-btn">Home</button></a>
                <a href="logout.php"><button class="square-btn square-btn-right">Logout</button></a>
            </div>

            <div class="row main-content">
            <input class="txt-input" value="
<?php 
if (isset($_GET["p"])){
    echo $_GET["p"];
}?>" name="pname" type="text" placeholder="Pool Name" <?php
    if (!isset($_GET["p"])){
        echo "autofocus";
    }
?>>
            <div class="square-btn-bar2">
                <input class="square-btn fill-w" type="submit" value="Join"
<?php
    if (isset($_GET["p"])){
        echo "autofocus";
    }
?>
> 
            </div>
        </div> 
        </div>
    </form>
</div>
</body>
</html>
