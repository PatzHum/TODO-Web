<html>
<?php
    include "data/base.php";
?>
<body>
<style>
    body{
        background:url("data/img/newpool_bg.jpg");
        background-size:cover;
    }
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
<?php
    if (isset($_POST["name"]) && isset($_POST["desc"])){
        $ret = make_pool($_POST["name"], $_POST["desc"]); 
        if ($ret == 0){
?>
    <h1 class="header">Add friends to <?php echo $_POST["name"];?></h1>
    <div class="container main-content">
        <input id="copyText" spellcheck="false" type="text" class="txt-input" value="todo.hypersystems.me/join.php?<?php
            $data = array('p'=>$_POST["name"]);
            echo http_build_query($data);
    ?>">
    <script>$("#copyText").select();</script>
    </div>
<div class="container">
   
<?php
        }else if ($ret == -1){
?> 
<?php    
        }
    }else{

?>
<h1 class="header">New Pool</h1>

<div class="container">
    <div class="row square-btn-bar"> 
        <a href="index.php"><button class="square-btn">Home</button></a>
        <a href="logout.php"><button class="square-btn square-btn-right">Logout</button></a>
    </div>

    <div class="row">
    <form class="form-nopad main-content" method="post" action="newpool.php">
        <input type="text" name="name" class="txt-input" placeholder="Name">

        <input type="text" name="desc" class="txt-input" placeholder="Description">
    
        <div class="square-btn-bar2">
            <input type="submit" class="square-btn fill-w" value="Create">
        </div>
    </form>
</div>
<?php
}?>
</body>
</html>
