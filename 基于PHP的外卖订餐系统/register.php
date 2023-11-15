<?php
$servername = "159.75.211.235";
$s_username = "phptest";
$s_password = "hyj5201314";
$dbname = "phptest";
$conn = new mysqli($servername,$s_username,$s_password,$dbname);
$register_username = $_POST['register_username'];
$register_password = $_POST['register_password'];
$repeat_password = $_POST['repeat_password'];
function CheckMobile($p){
    if (preg_match('/1[3456789]\d{9}$/',$p)) {
        return 1;
    }else {
        return 0;
    }
}
function CheckPasswrod($p){
    $pattern = "/(?![a-zA-Z]+$)(?!\d+$)(?![^\da-zA-Z\s]+$).{8,}$/";
    if (preg_match($pattern,$p)) {
        return 1;
    }else {
        return 0;
    }
}
if ($conn->connect_errno) {
    die("Connection failed:" . $conn->connect_errno);
} else {
    if (CheckMobile($register_username) == 0){
        echo "请输入正确的手机号！！！";
    }else {
        if (CheckPasswrod($register_password) == 0) {
            echo "密码必须有数字、字母或特殊字符中任意两种或两种以上组合而成且八位以上";
            echo "<br/>" . "请返回重新输入！！！";
        }else {
            if ($register_password == $repeat_password){
                $sql = "insert into user (username,password) values ('$register_username','$register_password')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: registersuccess.html");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }else {
                echo "重复密码错误";
            }
        }
    }

}
$conn->close();
?>
