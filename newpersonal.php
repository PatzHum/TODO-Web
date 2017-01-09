<html>
<?php 
    /*
    * Creates assignment for the user*/
    include "data/base.php";
?>
<style>
    body, html{
        font-family:"Roboto Condensed", sans-serif;
    }
    h1, h2, h3, h4, h5, h6{
        font-family:"Roboto", sans-serif;
    }
    .vcenter{
        height:100%;
        background:rgba(12,31,47,0.8);
        padding:3%;
        box-shadow:0px 0px 13px black;

    }
   
</style>
<body>
        <h1 class="header">New Item</h1> 
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <div class="row square-btn-bar"> 
                        <a href="index.php"><button class="square-btn">Home</button></a>
                        <a href="logout.php"><button class="square-btn square-btn-right">Logout</button></a>
                    </div>
                    <div class="row main-content">
                        <form action="data/post.php" method="post">
                            <input class="hidden" name="req" value="assign"/>
                            <input class="form-control" type="text" name="name" placeholder="Subject"/><br/>
                            <input class="form-control" type="text" name="details" placeholder="Details"/><br/>
                            <input class="form-control" type="text" name="url" placeholder="Link (optional)"/><br/>
                            <input class="form-control" type="date" name="due" /><br/>
                            <input class="form-control" type="hidden" name="uid" value="<?php echo $_SESSION["uid"]; ?>"/>
                            <input class="form-control" type="submit" value="Create new item"/>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

