<?php
header("Access-Control-Allow-Origin: *");
include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Task($id, $title, $content, $pay, $dbconfig){
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
        mysqli_query($con, "SELECT * FROM `task`");
        $sql = "INSERT INTO `task` (`id`, `title`, `content`, `pay`, `status`, `set_time`) VALUES ( '$id', '$title', '$content', '$pay', '未完成', NOW());";
        if (mysqli_query($con, $sql)) {
            return 1;
        }
         else {
           // echo "Error: " . $sql . "<br>" . mysqli_error($con);
            return 0;
        }
        mysqli_close($con);
    }
    
        if(Task( $_POST['id'], $_POST['title'], $_POST['content'], $_POST['pay'],  $dbconfig)==1){
        exit("申請成功!~^.^~".$_POST['id']);}
        else if(Task( $_POST['id'], $_POST['title'], $_POST['content'], $_POST['pay'],  $dbconfig)==0){
        exit("申請失敗~QAQ~".$_POST['id']);}
        else{exit("Error!!!");}
?>