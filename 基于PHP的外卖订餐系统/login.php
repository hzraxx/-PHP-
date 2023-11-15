<?php
$servername = "159.75.211.235";
$s_username = "phptest";
$s_password = "hyj5201314";
$dbname = "phptest";
$conn = new mysqli($servername,$s_username,$s_password,$dbname);
if ($conn->connect_errno) {
    die("Connection failed:" . $conn->connect_errno);
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "select * from user";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        // 输出数据
        while($row = mysqli_fetch_assoc($result)) {
            if ($username == $row["username"]) {
                if ($password == $row["password"]){
                    echo "登录成功";
                    setcookie("username","$username");
                    setcookie("balance",$row["balance"]);
                    header("Location: loginsuccess.html");
                    exit;
                }else {
                    echo "密码错误";
                }
            }
        }
    } else {
        echo "0 结果";
    }
}
$conn->close();
?>