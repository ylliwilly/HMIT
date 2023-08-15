
<?php

$dbconfig=array(
	"host"=>"localhost",
	"user"=>"root",
	"password"=>"",
	"dbname"=>"database"
	);



// 创建连接
$con = mysqli_connect($dbconfig["host"],$dbconfig["user"],$dbconfig["password"],$dbconfig["dbname"]);
// 检测连接
if (!$con) {
    die("連接失敗: " . mysqli_connect_error());
}


/*
//創建數據庫
$sql = "CREATE DATABASE {$dbconfig["dbname"]}";
if (mysqli_query($con, $sql)) {
    echo "数据库创建成功";
} else {
    echo "Error creating database: " . mysqli_error($con);
}
*/


/*
//創建Task
$x="Task";
$sql = "CREATE TABLE {$x}(
    No int NOT NULL primary key AUTO_INCREMENT,
    id CHAR(7)  NOT NULL, 
    title VARCHAR(30) NOT NULL,
    content VARCHAR(100) NOT NULL,
    pay int(3),
    status char(3),
    set_time TIMESTAMP
    )";
     
    if (mysqli_query($con, $sql)) {
        echo "數據表".$x."创建成功";
    } else {
        echo "創建數據表表错误: " . mysqli_error($con);
    }  
*/
//創建score
$x="score";
$sql = "CREATE TABLE {$x}(
    No int NOT NULL,
    id CHAR(7)  NOT NULL, 
    identity VARCHAR(30) NOT NULL,
    status char(3),
    set_time TIMESTAMP
    )";
     
    if (mysqli_query($con, $sql)) {
        echo "數據表".$x."创建成功";
    } else {
        echo "創建數據表表错误: " . mysqli_error($con);
    }  
/*
//創建User
$x="User";
$sql = "CREATE TABLE {$x}(
    id CHAR(7)  NOT NULL PRIMARY KEY, 
    nickname VARCHAR(10) NOT NULL,
    password VARCHAR(15) NOT NULL,
    email VARCHAR(30) NOT NULL,
    reg_time TIMESTAMP
    )";
     
    if (mysqli_query($con, $sql)) {
        echo "數據表".$x."创建成功";
    } else {
        echo "創建數據表表错误: " . mysqli_error($con);
    }  
*/
//插入
/*mysqli_query( $con, "SET NAMES 'utf8'");
mysqli_query($con, "SELECT * FROM ` MyGuests`");
$sql = "INSERT INTO `MyGuests` (`firstname`, `lastname`, `email`) VALUES ('John', 'Doe', 'john@example.com');";

if (mysqli_query($con, $sql)) {
    echo "新紀錄插入成功";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
*/

mysqli_close($con);

?>
