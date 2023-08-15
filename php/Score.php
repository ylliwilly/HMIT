<?php
header("Access-Control-Allow-Origin: *");

include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Score($id, $identity, $No, $dbconfig){
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
        mysqli_query($con, "SELECT * FROM `score`");
        $sql = "INSERT INTO `score` (`No`,`id`, `identity`,  `star`, `status`, `set_time`) VALUES ('$No', '$id', '$identity',  Null, '申請中', NOW())";
        if (mysqli_query($con, $sql)) {
            return 1;
        }
         else {
           // echo "Error: " . $sql . "<br>" . mysqli_error($con);
            return 0;
        }
        mysqli_close($con);
    }
function Score_task($id, $identity, $No, $status, $star, $dbconfig){
        $con = mysqli_connect( $dbconfig["host"], $dbconfig["user"], $dbconfig["password"]);
        if (empty($con)){
            die("連接失敗: " . mysqli_connect_error());
            exit;
        }
        if( !mysqli_select_db($con, $dbconfig["name"])) {
            die ("無法選擇資料庫");
        }
        mysqli_query( $con, "SET NAMES 'utf8'");
        //AGREE
        if($status=="agree"){
        //更改任務狀態
        $sql = "UPDATE `task` SET `status`='進行中' WHERE `No`='$No'";
        mysqli_query($con,$sql);
        /*mysqli_query($con,"UPDATE `score` SET `status`='進行中' , `set_time`=NOW()
        WHERE `id`='$id' AND `No`='$No' AND `identity`='$identity' AND `status`='申請中'");
        $sql ="DELETE FROM `score` WHERE `status`='申請中' AND `No`='$No'";*/
        //插入score(進行中)
        $_sql="SELECT * FROM `apply`";
        $_sql="INSERT INTO `score` (`No`, `id`, `identity`, `status`, `set_time`) VALUES ('$No', '$id', '$identity', '進行中', NOW())";
        mysqli_query($con,$_sql);
        //紀錄發布者
        /*$_sql="SELECT * FROM `task` WHERE `No`='$No'";
        $_result=mysqli_query($con, $_sql);
        $_row = mysqli_fetch_assoc($_result);
        $_sql="INSERT INTO `score` (`id`, `identity`, `No`, `status`, `set_time`) VALUES ({$_row['id']}, '僱傭人', {$_row['No']}, {$_row['進行中']}, NOW())";
        mysqli_query($con,$_sql);*/
        //刪除apply
        mysqli_query($con,"DELETE FROM `apply`
            WHERE `No`=$No");
        mysqli_close($con);
        //更改任務status
        mysqli_query($con,"UPDATE `task` SET `status`='進行中'
        WHERE `No`=$No AND `status`='未完成'");
        mysqli_close($con);
        return($sql);
        }
        else if($status=="disagree"){
            mysqli_query($con,"DELETE FROM `apply`
            WHERE `No`='$No'");
            mysqli_close($con);
        }
        else{//if($status=="finish"){
            mysqli_query($con,"UPDATE `score` SET `star`=$star ,`status`='已完成', `set_time`=NOW()
            WHERE `No`='$No' AND `identity`='$identity' AND `status`='進行中'");
            mysqli_query($con,"UPDATE `task` SET `status`='已完成'
            WHERE `No`='$No' AND `status`='進行中'");
            mysqli_query($con,"DELETE `communication`
            WHERE `No`='$No'");
            mysqli_close($con);
            return("Success".$id.$No.$identity.$star);
        }
        return("這裡".$status);
    } 

    if($_POST['identity']=="Employee"){
        //申請任務
       if($_POST['status']==1){
            if(Score( $_POST['id'], $_POST['identity'], $_POST['No'], $dbconfig)==1){
            exit("{\"success\":\"True\"}:申請成功" );}
            else if(Score( $_POST['id'], $_POST['identity'], $_POST['No'], $dbconfig)==0){
            exit("{\"success\":\"False\"}:申請失敗");}
            else{
                exit("{\"success\":\"False\"}:錯誤");}
        } 
        else{
            exit(Score_task( $_POST['id'], $_POST['identity'], $_POST['No'], $_POST['status'], $_POST['star'],$dbconfig));
        }
    }
    else{
        exit("錯誤".$_POST['identity']);
    }
?>