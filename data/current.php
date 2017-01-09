<html>
<?php
    include "base.php";
    $assign_list = get_current_assignments($_SESSION["uid"]); 
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
    .header{
        padding-top:5%;
        padding-bottom:5%;
        color:white;
        background-color:#002966;
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
    .form-nopad{
        margin:0;
    }
</style>

<body>

<?php include "template.php";?>
<div class="container">

        <div class="row">
            <h1 class="text-center text-light header">Your active assignments.</h1>
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
                echo "<tr class=\"tr-assign\" style=\"background-color:" . $color . "\">";
                    echo "<td>" . $assign["name"] . "</td>";
                    echo "<td>" . $assign["details"] . "</td>";
                    echo "<td>" . $assign["due"] . "</td>";
                    if ($assign["url"] != ""){
                        echo "<td><a target=\"_blank\" href=\"" . $assign["url"] . "\">Go To Item</a></td>";
                    }else{
                        echo "<td>No Link</td>";
                    }
?>
                    <td>
                        <form class="form-nopad" action="remove.php" method="post">
                            <input type="hidden" name="rid" value="<?php echo $assign["rid"];?>"/>
                            <input class="btn btn-danger" type="submit" value="&#128465;"/>
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
</body>
</html>

