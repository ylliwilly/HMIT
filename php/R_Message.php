<?php
include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Return_message($id, $No, $content, $nature, $dbconfig){
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
        //if ($nature=="comment"){
            $sql="SELECT * FROM `message` WHERE `No`= '$No' AND `nature`='$nature'";
        //}
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                    $_sql="SELECT nickname FROM `message` JOIN `user` ON `message`.id = `user`.id where `message`.M_No = ".$row["M_No"];
                    $_result=mysqli_query($con, $_sql);
                    $_row = mysqli_fetch_assoc($_result);
                    $array=$array . "-" .$_row["nickname"].".". $row["content"] . "." .$row["M_No"];
                }
        //response_array
            $sql="SELECT * FROM `message` WHERE `No`= '$No' AND `nature`='response'";
            $result=mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                        $_sql="SELECT nickname FROM `message` JOIN `user` ON `message`.id = `user`.id where `message`.M_No = ".$row["M_No"];
                        $_result=mysqli_query($con, $_sql);
                        $_row = mysqli_fetch_assoc($_result);
                        $array2=$array2 . "-" .$_row["nickname"].".". $row["content"] . "." .$row["object"];
                    }
                    $array=$array."&".$array2;
                }
                return $array;
            } 
        else {
                return "0 结果";
            }
            mysqli_close($con);
    }
    if($_POST['No']!=NULL){
        exit("{\"success\":\"True\"}:".Return_message($_POST['id'],$_POST['No'],$_POST['content'],$_POST['nature'],$dbconfig));
    }
    else{
        exit("錯誤");
    }
?>