<?php
header("Access-Control-Allow-Origin: *");

include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Apply($id, $No, $dbconfig){
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
        //user找star數
        $_sql="SELECT * FROM `user` WHERE `id`= '$id'";
        $_result=mysqli_query($con, $_sql);
        $row = mysqli_fetch_assoc($_result);
        $star = $row["star"];
        $quantity = $row["quantity"];

        // 選擇資料表
        mysqli_query($con, "SELECT * FROM `apply`");
        $sql = "INSERT INTO `apply` ( `No`, `id`, `star`, `quantity`, `set_time`) VALUES ('$No', '$id', '$star', '$quantity', Now())";
        if (mysqli_query($con, $sql)) {
            return 1;
        }
        else {
           // echo "Error: " . $sql . "<br>" . mysqli_error($con);
            return 0;
        }
        mysqli_close($con);
    }

        //申請任務
    if($_POST['id']!="" || $_POST['id']!=NULL){

    if(Apply($_POST['id'], $_POST['No'], $dbconfig)==1){
        exit("{\"success\":\"True\"}:申請成功" );}

    else if(Apply($_POST['id'], $_POST['No'], $dbconfig)==0){
        exit("{\"success\":\"False\"}:申請失敗");}
    }
    else{
        exit("{\"success\":\"False\"}:未登入");}
?>