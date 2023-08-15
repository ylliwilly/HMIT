<?php
header("Access-Control-Allow-Origin: *");

include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Return_Score( $No, $status, $identity, $id, $dbconfig){
    $A=array("");
    $array="";
    $i=0;

    $con = mysqli_connect( $dbconfig["host"], $dbconfig["user"], $dbconfig["password"]);
    if (empty($con)){
        die("連接失敗: " . mysqli_connect_error());
        exit;
    }
    if( !mysqli_select_db($con, $dbconfig["name"])) {
        die ("無法選擇資料庫");
    }
    // 設定連線編碼
    mysqli_query( $con, "SET NAMES 'utf8'");
    // 選擇資料表
    /*if ($status=="未完成"){
        ;/* AND `identity`='Employee' AND `status`='申請中'";
    }
    //進行中
    else{
        $sql="SELECT * FROM `task` WHERE `No`= '$No'";
    }*/
   /* else if($identity=="Employer"){
        $sql="SELECT * FROM `task` WHERE `No`= '$No'";
        //`score` WHERE `No`= '$No' AND `identity`='Employee' AND `status`='$status'";
    }
    else if($identity=="Employee"){
        $sql="SELECT * FROM `task` WHERE `No`= '$No'";
    }*/

    /*$result=mysqli_query($con, $sql);
    if (mysqli_num_rows($result)==1) {
        $star=array("");
        while($row = mysqli_fetch_assoc($result)) {
            $count=0;
            $i=0;
            //從已完成事件中平均星數
                $_sql="SELECT * FROM `apply` WHERE `id`=".$row["id"] . "'AND `status`='已完成'";
                $_result=mysqli_query($con, $_sql);
                if (mysqli_num_rows($_result) > 0) {
                    while($_row = mysqli_fetch_assoc($_result)) {
                        $count=$count+$_row["star"];                    
                    }
                    $count=($count/mysqli_num_rows($_result));
                }*/
                    /*$count=$count/mysqli_num_rows($_result);
                    if($identity=="Employer"){
                    $star[i]=$count."、".mysqli_num_rows($_result)."、".$row["set_time"]."、".$row["id"] . "、" . mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `task` WHERE `No`= '$No'"))["content"];
                    }
                    else if($identity=="Employee"){
                        $star[i]=$count."、".mysqli_num_rows($_result)."、". mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `score` WHERE `No`= '$No' AND `id`='$id'"))["set_time"]."、".$row["content"];
                    }
                }
                else {
                    $star[i]="0、0、".$row["set_time"]."、".$row["id"]."、" . mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `task` WHERE `No`= '$No'"))["content"];
                }*/
                //$count=($count/mysqli_num_rows($_result));
                //
    /*else {
        return "Error!";
    }*/
    
    if ($status=="未完成"){
        $sql="SELECT * FROM `apply` WHERE `No`= '$No'";
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0 ) {
            // 输出数据
            while($row = mysqli_fetch_assoc($result)){
                $A[$i] ="id:" . $row["id"]. "、content:" . $row["content"]."、star:" .$row["star"]."、quantity:" .$row["quantity"]."、time:" .$row["set_time"];
                $A[$A[$i]]=strtotime($row["set_time"]);
                $i++;
            }
            arsort($A);
            $array=$A[0];
            $x=1;
            while($x<$i){
                $array=$array."=".$A[$x];
                $x++;
            }
        }
        else {
            return "0 结果";
        }
    }   
    else if ($status=="進行中"){
        $sql="SELECT * FROM `task` WHERE `No`= '$No'";
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0 ) {
            // 输出数据
            while($row = mysqli_fetch_assoc($result)){
                $A[$i] ="id:" . $row["id"]. "、content:" . $row["content"];//."、time:" .$row["set_time"];

                $_sql2="SELECT * FROM `score` WHERE `No`= '$No'";
                $A[$i] = $A[$i] ."、time:". mysqli_fetch_assoc(mysqli_query($con, $_sql2))["set_time"];
               // }

                $A[$A[$i]]=strtotime($row["set_time"]);
                $i++;
            }
            arsort($A);
            $array=$A[0];
            $x=1;
            while($x<$i){
                $array=$array."=".$A[$x];
                $x++;
            }
        }
    }
       /* else {
            return "0 结果";
        }
    }*/
    
    /*else if($identity=="Employer"){
                        //$star[i]=$count."、".mysqli_num_rows($_result)."、".$row["set_time"]."、".$row["id"] . "、" . mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `task` WHERE `No`= '$No'"))["content"]."、".$row["message"];
        if (mysqli_num_rows($result) > 0 ) {
            // 输出数据
            while($row = mysqli_fetch_assoc($result)){
                $A[$i] ="id:" . $row["id"]. "、content:" . $row["content"]."、time:" .$row["set_time"];
                $A[$A[$i]]=strtotime($row["set_time"]);
                $i++;
            }
            arsort($A);
            $array=$A[0];
            $x=1;
            while($x<$i){
                $array=$array."=".$A[$x];
                $x++;
            }
        }
        else {
            return "0 结果";
        }
    }
    else if($identity=="Employee"){
        //$star[i]=$count."、".mysqli_num_rows($_result)."、". mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `score` WHERE `No`= '$No' AND `id`='$id'"))["set_time"]."、".$row["id"]."、".$row["content"];
        if (mysqli_num_rows($result) > 0 ) {
                // 输出数据
                while($row = mysqli_fetch_assoc($result)){
                    $A[$i] ="id:" . $row["id"]. "、content:" . $row["content"]."、time:" .$row["set_time"];
                    $A[$A[$i]]=strtotime($row["set_time"]);
                    $i++;
                }
                arsort($A);
                $array=$A[0];
                $x=1;
                while($x<$i){
                    $array=$array."=".$A[$x];
                    $x++;
                }
            }
        
            else {
                return "0 结果";
            }
    }*/
                /*$array=$array . "=" . $star[i];
                $i++;*/
    return $array;
    mysqli_close($con);
}

if($_POST['No']!=NULL || $_POST['No']!=""){
        exit("{\"success\":\"True\"}:".Return_Score($_POST['No'], $_POST['status'], $_POST["identity"], $_POST['id'], $dbconfig));
}
else {
    exit("{\"success\":\"Flase\"}");}
    
    ?>