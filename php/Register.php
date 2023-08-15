<?php
    include_once "dbconfig.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    function Register_User( $id, $nickname, $password, $email, $dbconfig){
        $con = mysqli_connect( $dbconfig["host"], $dbconfig["user"], $dbconfig["password"]);
        if (empty($con)){
            die("連接失敗: " . mysqli_connect_error());
            exit;
        }
        if( !mysqli_select_db($con,$dbconfig["name"])) {
            die ("無法選擇資料庫");
        }
        // 設定連線編碼
        mysqli_query( $con, "SET NAMES 'utf8'");
        // 選擇資料表
        mysqli_query($con, "SELECT * FROM `User`");
        $sql = "INSERT INTO `user` (`id`,`nickname`, `password`, `email`,  `reg_time`) VALUES ( '$id', '$nickname', '$password', '$email', NOW())";
        if (mysqli_query($con, $sql)) {
            return 1;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
            return 0;
        }
        mysqli_close($con);
    }
    
        if(Register_User( $_POST['id'], $_POST['nickname'], $_POST['password'], $_POST['email'], $dbconfig)==1){
        exit("{\"success\":\"True\"}:新用戶插入成功" );}
        else if(Register_User( $_POST['id'], $_POST['nickname'], $_POST['password'], $_POST['email'], $dbconfig)==0){
        exit("{\"success\":\"False\"}:" . $sql . "<br>" . mysqli_error($con));}
        else{exit("{\"success\":\"False\"}:Error!!!");}
?>