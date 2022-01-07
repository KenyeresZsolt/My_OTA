<h2 class="text-center m-3">Ez az oldal is elkészül hamarosan.</h2>
<h4 class="text-center">Addig sakkozz:</h4>
<hr>
<p class="text-center">Mekkora legyen a sakktábla?</p>
    <form class="me-auto ms-auto" method="GET">
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
