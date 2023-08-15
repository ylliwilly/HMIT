<?php
header("Access-Control-Allow-Origin: *");
include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type:text/html; charset=utf-8");
header('Access-Control-Allow-Origin:*'); 
function Communicatuon($No, $id, $identity, $content, $dbconfig){
    $A=array("");
    $i=0;
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
    $count=1;
    if(mysqli_num_rows(mysqli_query($con, $sql))){
        $count=mysqli_num_rows(mysqli_query($con, $sql))+1;
    }

    $sql = "INSERT INTO `communication` (`No`,`id`,`content`,`identity`,`count` ) VALUES ( '$No', '$id', '$content', '$identity', '$count')";
    if(mysqli_query($con, $sql)){
        return 1;
    }

    mysqli_close($con);
}

if(Communicatuon($_POST['No'], $_POST['id'], $_POST['identity'], $_POST['content'], $dbconfig)){
    exit("Send!");}

else{exit("Error!".$_POST['No'].$_POST['id'].$_POST['identity'].$_POST['content']);}

?>