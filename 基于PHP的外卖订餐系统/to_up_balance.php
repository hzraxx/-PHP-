<?php

// 获取 POST 请求中的充值金额
$amount = $_POST['amount'];

// 连接到 MySQL 数据库
$servername = "159.75.211.235";
$s_username = "phptest";
$s_password = "hyj5201314";
$dbname = "phptest";
$username = $_COOKIE['username'];
$conn = new mysqli($servername, $s_username, $s_password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 更新数据库中的 balance 字段值
$sql = "UPDATE user SET balance = balance+$amount WHERE username = '$username'";
if ($conn->query($sql) === TRUE) {
    echo "充值成功！";
} else {
    echo "充值失败: " . $conn->error;
}

// 关闭数据库连接
$conn->close();
?>