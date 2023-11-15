<?php
// 获取总金额（根据实际情况修改）
$totalAmount = $_COOKIE['total_amount'];

// 建立与数据库的连接
$mysqli = new mysqli("159.75.211.235", "phptest", "hyj5201314", "phptest");

// 检查连接是否成功
if ($mysqli->connect_errno) {
    die("连接数据库失败：" . $mysqli->connect_error);
}
$username = $_COOKIE["username"];
// 查询用户余额（根据实际情况修改查询语句）
$query = "SELECT balance FROM user WHERE username = '$username'"; // 假设用户ID为1
$result = $mysqli->query($query);

if ($result) {
    // 获取查询结果
    $row = $result->fetch_assoc();
    $balance = $row['balance'];

    // 检查余额是否足够
    $balanceSufficient = ($balance >= $totalAmount);

    // 返回结果
    $response = array(
        'balance_sufficient' => $balanceSufficient
    );
    echo json_encode($response);
} else {
    // 查询失败
    echo "查询数据库失败：" . $mysqli->error;
}

// 关闭数据库连接
$mysqli->close();
?>
