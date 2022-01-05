<h1>Mekkora legyen a sakktábla?</h1>
<br>
    <form method="GET">
        <table>
            <tr>
                <td><input type="text" name ="negyzet" placeholder="négyzetek száma" autocomplete="off"></td>
                <td><input type="submit" value="OK" class="btn btn-sm btn-success"></td>
            </tr>
        </table>
    
    </form>
    
<hr>

<table class="ST-table">
    <?php
        @$i=$_GET['negyzet'];
        for($r=1; $r<=$i; $r++){
            echo "<tr class=" . "ST-tr" . ">";
                for($c=1; $c<=$i; $c++){
                    $total=$r+$c;
                    if($total%2==0){
                        echo "<td class=" . "ST-black ST-td" . "></td>";
                    }
                    else{
                        echo "<td class=" . "ST-td" . "></td>";
                    }                    
                }
            echo "</tr>";
        }
    ?>
</table>
<br>
