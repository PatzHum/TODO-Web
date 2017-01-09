<html>
<?php
    include "data/base.php";
    $assign_list = get_current_assignments($_SESSION["uid"]); 
    $pool_list = get_pools($_SESSION["uid"]);
?>
<style>
    body, html{
        color:white;
    }
    body{
        background:url("/data/img/index_bg.jpg");
        background-size:cover;
    }
    .text-center{
        text-align:center;
    }
    .text-light{
        font-weight:normal;
    }
    .tr-assign:hover{
        background-color:#e6e6e6; 
    } 
    .main-table{
        font-size:1.0em;
    } 
    .fillw{
        width:100%;
        margin:0 auto;
    } 
    .clear-btn{
        background:rgba(0,0,0,0.2);
        color:white;
        border:none;
        text-decoration:underline;
    }
    .section{
        padding-left:3%;
        padding-right:3%;
    }
    
    @media (max-width:991px){
        h1, h2, h3, h4, h5, h6{
            width:100%;
            text-align:center;
            margin-top:0;
        }
    } 
   
</style>

<body>

<h1 class="header">Dashboard</h1>
<div class="container main fill-height">
    <div class="row square-btn-bar">
        <a href="newpersonal.php"><button class="square-btn">New Personal</button></a>
        <a href="logout.php"><button class="square-btn square-btn-right">Logout</button></a>
        <a href="join.php"><button class="square-btn square-btn-right">Join Pool+</button></a>
        <a href="newpool.php"><button class="square-btn square-btn-right">Create Pool+</button></a>
    </div>
    <div class="row main-content">
        <div class="col-md-6 section">

            <div class="row">
                <h1>Upcoming</h1>
            </div>
            <div class="row">
                <div class ="table-responsive">
                <table class="table main-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Due</th>
                        <th>Link</th>
                        <th>Del</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                    foreach ($assign_list as $assign){
                        $color = "#FFFFFF"; 

                        $duedate = new DateTime($assign["due"]);
                        $today = new DateTime(date("Y-m-d H:i:s")); 
                        $interval = $today->diff($duedate);
                        $daysleft = $interval->d; 
                        if ($interval->invert){
                            $daysleft = $daysleft * -1;
                        } 

                        if ($daysleft < 0){
                            $color="#9F9F9F";
                        }else if ($daysleft < 1){
                            $color="#ff9999";
                        }else if ($daysleft < 3){
                            $color="#ffa366";
                        }else if ($daysleft < 5){
                            $color="#ffff99";
                        }
                        echo "<tr>";
                            echo "<td>" . $assign["name"] . "</td>";
                            echo "<td>" . $assign["details"] . "</td>";
                            echo "<td>" . explode(" ",$assign["due"])[0] . "</td>";
                            if ($assign["url"] != ""){
                                echo "<td><a target=\"_blank\" href=\"" . $assign["url"] . "\">Go To Item</a></td>";
                            }else{
                                echo "<td>No Link</td>";
                            }
        ?>
                            <td>
                                <form class="form-nopad" action="data/remove.php" method="post">
                                    <input type="hidden" name="rid" value="<?php echo $assign["rid"];?>"/>
                                    <input class="clear-btn" type="submit" value="X"/>
                                </form>
                            </td>
        <?php
                        echo "</tr>";
                    }
                ?>
                </tbody>
                </table>
            </div>
        </div>
        </div>
        <div class="col-md-6 section">
            <div class="row">
                <h3 class="inline">Pools</h3>
                <a href="manage.php"><button class="clear-btn inline float-right">Manage Pools</button></a>
            </div>
            <div class="row">
            
            <?php
        foreach($pool_list as $pid){
            $assigns = get_pool_assignments($pid[0]);
            $pool_meta = get_pool_metadata($pid[0]);
?>
        <div class="row square-btn-bar2">
        <div class="square-label">
<?php
            echo $pool_meta[0]["name"];
?>
        </div>
        <form action="newpublic.php" style="padding:0; margin:0;display:inline;" method="post">
            <input type="hidden" name="pid" value="<?php echo $pid[0];?>">
            <input type="submit" class="square-btn square-btn-right" value="New Item">
        </form>
        </div>
            <div class ="table-responsive">
                <table class="table main-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Due</th>
                        <th>Link</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
<?php
            foreach($assigns as $rid){
    ?>
    <tr>
    <?php
                $a = get_assignment($rid[0]);
                if (!isset($a[0])){
                    continue;
                }
                echo "<td>" . $a[0]["name"] . "</td>"; 
                echo "<td>" . $a[0]["details"] . "</td>";
                echo "<td>" . explode(" ", $a[0]["due"])[0] . "</td>";
                if ($a[0]["url"] != ""){
                    echo "<td><a target=\"_blank\" href=\"" . $a[0]["url"] . "\">Go To Item</a></td>";
                }else{
                    echo "<td>No Link</td>";
                }
                echo "<td>";
?>
        <form class="form-nopad" action="data/post.php" method="post">
            <input type="hidden" name="req" value="take">
            <input type="hidden" name="rid" value="<?php echo $rid[0];?>">
            <input class="clear-btn" type="submit" value="Take">
        </form>
<?php
    ?>
    </tr>
    <?php
            }
?>
            </tbody>
                </table>
            </div>

<?php
        }
            ?>  
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

