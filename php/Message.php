<?php
header("Access-Control-Allow-Origin: *");

include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Leave_message($id, $No, $content, $nature, $dbconfig){
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
        mysqli_query($con, "SELECT * FROM `message`");
        if($nature=="comment"){
        $sql = "INSERT INTO `message` (`id`, `No`, `content`, `nature`, `time`) VALUES ( '$id', '$No', '$content', '$nature', NOW())";
        }
        else if($nature=="response"){
        $_sql="SELECT * FROM `message` WHERE `M_No`= '$No' AND `nature`='comment'";
        $result=mysqli_query($con, $_sql);
        $row = mysqli_fetch_assoc($result)["No"];
        $sql = "INSERT INTO `message` (`id`, `No`, `object` , `content`, `nature`, `time`) VALUES ( '$id', '$row', '$No' ,'$content', '$nature', NOW())";
        }
        if (mysqli_query($con, $sql)) {
            return 1;
        }
         else {
            // echo "Error: " . $sql . "<br>" . mysqli_error($con);
            return $id.$row.$No.$content.$nature;
        }
        mysqli_close($con);
    }
function communication($id, $No, $content, $target, $dbconfig){
        $con = mysqli_connect( $dbconfig["host"], $dbconfig["user"], $dbconfig["password"]);
        if (empty($con)){
            die("連接失敗: " . mysqli_connect_error());
        }
        if( !mysqli_select_db($con, $dbconfig["name"])) {
            die ("無法選擇資料庫");
        }
        mysqli_query( $con, "SET NAMES 'utf8'");
        if($target==(-1)){
        $sql="SELECT * FROM `score` WHERE `No.`= '$No' AND `status`='進行中'"; 
        }
        else if($target==(-2)){
        $sql="SELECT * FROM `task` WHERE `No.`= '$No' AND `status`='進行中'"; 
        }
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 1 ){
            $row = mysqli_fetch_assoc($result);
            $_target=$row["id"];
            $_sql="INSERT INTO `communication` ( `No`, `id`, `content`, `target`, `time`) VALUES ( '$No', '$id', '$content' , '$_target', NOW())"; 
            if (mysqli_query($con, $_sql)) {
                return 1;
            }
            else{return $target;}
        }
        else{return mysqli_num_rows($result);}
}


    if(Leave_message($_POST['id'],$_POST['No'],$_POST['content'],$_POST['nature'],$dbconfig)==1){
        exit("{\"success\":\"True\"}:留言成功" );
    }
    else if(communication($_POST['id'], $_POST['No'], $_POST['content'], $_POST['target'], $dbconfig)==1)
        exit("{\"success\":\"True\"}:訊息發送成功");
    else{
        exit("錯誤".communication($_POST['id'], $_POST['No'], $_POST['content'], $_POST['target'], $dbconfig).$_POST['id'].$_POST['No'].$_POST['content'].$_POST['target']);
    }
?>