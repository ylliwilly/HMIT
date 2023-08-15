<?php
header("Access-Control-Allow-Origin: *");
include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type:text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*'); 
function Retrun_communicatuon($id, $No, $identity, $th,$dbconfig){
    $A=array("");
    $B=array("");
    $i=0;//array中的位置
    $con = mysqli_connect( $dbconfig["host"], $dbconfig["user"], $dbconfig["password"]);
    mysqli_query( $con, "SET NAMES 'utf8'");
    if (empty($con)){
        die("連接失敗: " . mysqli_connect_error());
        exit;
    }
    if( !mysqli_select_db($con, $dbconfig["name"])) {
        die ("無法選擇資料庫");
    }
    $sql="SELECT * FROM `communication` WHERE `No`= '$No'";
    $result=mysqli_query($con, $sql);
    if (mysqli_num_rows($result)>$th ) {
        // 输出数据
       while($row = mysqli_fetch_assoc($result)){
        $A[$i]="id:" . $row["id"]. "、content:" . $row["content"];//."、count:".$row["count"];
        //$n=$row["count"];
        $B[$row["count"]]=$A[$i];
        $i++;
        }
   /* if (mysqli_num_rows($result) > $th ) {
        // 输出数据
       while($i<(mysqli_num_rows($result)-$th)){
        $row = mysqli_fetch_assoc($result)[($i+$th)];
        $A[$i]="id:" . $row["id"]. "、content:" . $row["content"];
        $A[$A[$i]]=$row["count"];
        $i++;
        }*/

        //usort($A, "cmp");
        ksort($B);
        $array=$B[$th+1];
        $x=($th+2);
        while($x<=mysqli_num_rows($result)){
            $array=$array."&".$B[$x];
            $x++;
        }
     
    $array=$array."、count:".mysqli_num_rows($result);
    return $array;
    }
    else if($th>0){
        return "no_update";
    }
    else{return "no_message";}
    /*if($identity=(-1)){
        //AND `identity`='受僱人'
        $sql="SELECT * FROM `score` WHERE `No`= '$No' AND `identity`='Employee'";
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 1 ) {
        $row = mysqli_fetch_assoc($result);
        $target=$row['id'];
        } 
    }
    else if($identity=(-2)){
        $sql="SELECT * FROM `task` WHERE `No`= '$No' ";
        $result=mysqli_query($con, $sql);
            if (mysqli_num_rows($result) == 1 ) {
            $row = mysqli_fetch_assoc($result);
            $target=$row['id'];
            }
    }
    //th=0(即重新仔入/未輸入)
    if($th==0){
        $sql="SELECT * FROM `communication` WHERE `No`= '$No'"; 
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0 ) {

            // 输出数据
           while($row = mysqli_fetch_assoc($result)){
                $A[$i]="id:" . $row["id"]. "-content:" . $row["content"];
                $A[$A[$i]]=strtotime($row["time"]);
                $i++;
                if($row["id"]==$target){$o++;}
            }
            arsort($A);
            for($x=0;$x<count($A)/2;$x++){
                $array=$array."、".$A[$x];
            }    
            header("Content-Type:text/html; charset=utf-8");
           return ($array."&".$o);
           //
            }
           else{return ("no message");}
    }
    //target是否開啟(th!=0)
    else{
        $sql="SELECT * FROM `user` WHERE `id`= '$target' AND `status`='ON' AND `Toward_id`= '$id'"; 
        $result=mysqli_query($con, $sql);
        //若上線並連接
        if (mysqli_num_rows($result) == 1 ){
            $_sql="SELECT * FROM `communication` WHERE `No`= '$No' AND `id`='$target'"; 
            $_result=mysqli_query($con, $_sql);
            if (mysqli_num_rows($_result) > $th ) {
           while($_row = mysqli_fetch_assoc($_result)){
                $A[$i]=$_row["content"];
                $A[$A[$i]]=strtotime($_row["time"]);
                $i++;
            }
            arsort($A);
            for($x=$th;$x<count($A);$x++){
                $array=$array."、".$A[$x];
            }    
           return ($array);
            }
            else{return ("no update");}
        }
        //若無連接
        else{
            return("offline/offconnect");
        }
    }*/

    mysqli_close($con);
}
function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}


if($_POST["id"]!=NULL && $_POST["No"]!=NULL){
exit(Retrun_communicatuon( $_POST['id'], $_POST['No'], $_POST['identity'], $_POST['count'], $dbconfig));
}

else{
    exit("Error!");
}
?>

    