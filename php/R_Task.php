
<?php
header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Origin: php/R_Task.php ");
include_once "dbconfig.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Return_task($id, $status, $range_start, $range_end, $dbconfig){
        $A=array("");
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
        $sql="SELECT * FROM `task` WHERE `status`= '$status' AND `id`<>'$id'";
        $result=mysqli_query($con, $sql);
    
        if (mysqli_num_rows($result) > 0 ) {
            // 输出数据
           while($row = mysqli_fetch_assoc($result)){
                $A[$i]="id:" . $row["id"]. "-title:" . $row["title"]. "-content:" . $row["content"]. "-pay:" . $row["pay"]."-No" .$row["No"];
                $No=$row["No"];

                $_sql2="SELECT * FROM `apply` WHERE `No`= '$No' AND  `id`='$id'";
                if(mysqli_num_rows(mysqli_query($con, $_sql2))>0){
                $A[$i] = $A[$i] . "-done";
                }

                $A[$A[$i]]=strtotime($row["set_time"]);
                $i++;
                }
            arsort($A);
            $array=$A[($range_start-1)];
            /*
            for ($x=$range_start; $x<=$range_end; $x++){
                $array=$array."、".$A[$x];
                }
            **/
            $x=($range_start);//1~5 0~4 0+1 x=1<5 1+2 x=2 2+3 x=3 3+4 x=4
            while($x<($range_end-1)){
                $array=$array."、".$A[$x];
                $x++;
            }
           
            /*$_sql="SELECT * FROM `score` WHERE `status`= '申請中' AND `id`='$id'";
            $_result=mysqli_query($con, $_sql);
            while($_row = mysqli_fetch_assoc($_result)){
                $array2=$_row["No"]."&".$array2;
            }*/
            return ($array);//.$range_start."&".$range_end);
        } 
        else {
            return "0 结果";
        }
        mysqli_close($con);
    }

function Return_test($status, $range_start, $range_end, $dbconfig){
        $A=array("");
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
        $sql="SELECT * FROM `task` WHERE `status`= '$status'";
        $result=mysqli_query($con, $sql);
    
        if (mysqli_num_rows($result) > 0 ) {
            // 输出数据
           while($row = mysqli_fetch_assoc($result)){
                $A[$i]="id:" . $row["id"]. "-title:" . $row["title"]. "-content:" . $row["content"]. "-pay:" . $row["pay"]."-No" .$row["No"];
                $A[$A[$i]]=strtotime($row["set_time"]);
                $i++;
                }
            arsort($A);
            $array=$A[($range_start-1)];
            /*
            for ($x=$range_start; $x<=$range_end; $x++){
                $array=$array."、".$A[$x];
                }
            */
            $x=$range_start;
            while($x<$range_end){
                $array=$array."、".$A[$x];
                $x++;
            }
            $_sql="SELECT * FROM `score` WHERE `status`= '申請中' AND `id`='$id'";
            $_result=mysqli_query($con, $_sql);
            while($_row = mysqli_fetch_assoc($_result)){
                $array2=$_row["No"]."&".$array2;
            }
            return ($array.$array2);//.$range_start."&".$range_end);
        } 
        else {
            return "0 结果";
        }
        mysqli_close($con);
    }
function Return_quantity($status, $id, $dbconfig){
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

    $sql="SELECT * FROM `task` WHERE `status`= '$status' AND `id`<>'$id'";
    $result=mysqli_query($con, $sql);
    return mysqli_num_rows($result);
    mysqli_close($con);
}
//返回No.title
function Return_Tasklist($id, $status, $identity, $dbconfig){
    //更改communication之tab顯示對象
    if($status=="communication"){
        $status="進行中";
    }
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
    if($identity=="Employer"){
        $sql="SELECT * FROM `task` WHERE `status`= '$status' AND `id`='$id'";
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $No=$No . "-" . $row["No"] .".". $row["title"];
            }
            return $No;
        } 
    }
    else if($identity=="Employee"){
        if($status=="申請中"){
            $sql="SELECT * FROM `apply` WHERE `id`='$id'";
        }
        else{
            $sql="SELECT * FROM `score` WHERE `status`= '$status' AND `id`='$id'";
        }
        $result=mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            $_sql="SELECT * FROM `task` WHERE `No`= " . $row["No"] ;
            $_result=mysqli_query($con, $_sql);
            $No=$No . "-" . $row["No"] .".". mysqli_fetch_assoc($_result)["title"];
            }
        return $No;
        }
    }
    else {
        return "錯誤";
    }
    mysqli_close($con);
}
if($_POST['identity']!=NULL && $_POST['identity']!=""){
    exit("{\"success\":\"True\"}:".$_POST['id'].$_POST['status'].$_POST['identity'].Return_Tasklist( $_POST['id'], $_POST['status'], $_POST['identity'], $dbconfig));
}
else if($_POST['range_start'] == NULL && $_POST['range_end'] == NULL){
    exit("{\"success\":\"True\"}:".Return_quantity($_POST['status'], $_POST['id'], $dbconfig));
}
else if($_POST['id']!=Null && $_POST['id']!=""){
        exit("{\"success\":\"True\"}:".Return_task($_POST['id'],$_POST['status'], $_POST['range_start'], $_POST['range_end'], $dbconfig));
}
else{
    exit("{\"success\":\"True\"}:".Return_test($_POST['status'], $_POST['range_start'], $_POST['range_end'], $dbconfig));
}
?>