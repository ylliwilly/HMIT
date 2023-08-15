<?php
    include_once "dbconfig.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    function Search( $id, $password, $dbconfig){
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
        $sql="SELECT * FROM `user` WHERE `id`= '$id' AND `password` = '$password'";
        $result=mysqli_query($con, $sql);
    
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return $row["nickname"];//$row["nickname"];
        }
        else {
            return 1;}
        mysqli_close($con);
    }
    function Return_information($id, $dbconfig){
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
        $sql="SELECT * FROM `user` WHERE `id`= '$id'";
        $result=mysqli_query($con, $sql);
    
        if (mysqli_num_rows($result) == 1) {
            // 输出数据
            $row = mysqli_fetch_assoc($result);
            return  $row["nickname"];
        } 
        else if(mysqli_num_rows($result) >= 2){
            return 1;
        }
        else if(mysqli_num_rows($result)==0){
            return 2;
        }
        else {
            return "Error!";
        }
        mysqli_close($con);
    }
    if($_POST['password']!=""){
        if(Search( $_POST['id'], $_POST['password'], $dbconfig)==1){
            exit("{\"success\":\"False\"}:查無此號");}
        else{
            exit("{\"success\":\"True\"}:".Search( $_POST['id'], $_POST['password'], $dbconfig));}
        }
    else if($_POST['password']==""){
        $Judge=Return_information($_POST['id'],$dbconfig);
        if($Judge==2){
        exit("{\"success\":\"False\"}:0");}
        else if($Judge==1){
        exit("{\"success\":\"False\"}:1" );}
        //中文$Judge==0|其他不為0。
    else { 
            exit("{\"success\":\"True\"}:" . $Judge);}
    }
?>