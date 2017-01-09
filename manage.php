<html>
<?php
    include "data/base.php";
    $pool_list = get_pools($_SESSION["uid"]);
?>

<style>
body, html{
    font-family:"Abel", sans-serif;
    color:white;
}
.main-table{
    font-size:1.0em;
} 
.clear-btn{
    background:rgba(0,0,0,0.2);
    color:white;
    border:none;
    text-decoration:underline;
}

</style>
<body>
<h1 class="header">Subscriptions</h1>
<div class="container">
    <div class="col-md-8 col-md-push-2">
        <div class="row square-btn-bar"> 
            <a href="index.php"><button class="square-btn">Home</button></a>
            <a href="logout.php"><button class="square-btn square-btn-right">Logout</button></a>
        </div>

        <div class="row main-content">
            <div class ="table-responsive">
                <table class="table main-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Joined</th>
                        <th>Users</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody> 
<?php
foreach($pool_list as $pid){
    $meta = get_pool_metadata($pid["pid"]);
?>
                        <tr>
                        <td> <?php echo $meta[0]["name"];?> </td>
                        <td> <?php echo $pid["created"];?> </td>
                        <td> <?php echo $meta[0]["user_count"];?> </td>
                        <td>
                        <form class="form-nopad" action="data/post.php" method="post"> 
                            <input type="hidden" name="req" value="leave">
                            <input type="hidden" name="pid" value="<?php echo $pid["pid"];?>">
                            <input class="clear-btn" type="submit" value="Leave"></td>
                        </form>
                        </tr>
<?php
}
?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
</body>

</html>
