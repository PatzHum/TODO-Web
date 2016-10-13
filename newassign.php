<html>
<?php 
    include "base.php";
?>
<style>
    body, html{
        font-family:"Roboto Condensed", sans-serif;
        color:black;
        font-size:18px;
    }
    h1, h2, h3, h4, h5, h6{
        font-family:"Roboto", sans-serif;
    }
    .vcenter{
        position:fixed;
        top:50%;
        left:50%;
        transform: translate(-50%,-50%);
    }
</style>
<body>
        <div class="vcenter">
            <h1>What's coming up?</h1> 
            <form action="post.php" method="post">
                <input class="hidden" name="req" value="assign"/>
                <input class="form-control" type="text" name="name" placeholder="Name"/><br/>
                <input class="form-control" type="text" name="details" placeholder="Details"/><br/>
                <input class="form-control" type="text" name="url" placeholder="Link (optional)"/><br/>
                <input class="form-control" type="date" name="due" /><br/>
                <input class="form-control" type="hidden" name="uid" value="<?php echo $_SESSION["uid"]; ?>"/>
                <input class="form-control" type="submit" value="Create new item"/>
                
            </form>
        </div>
</body>
</html>

