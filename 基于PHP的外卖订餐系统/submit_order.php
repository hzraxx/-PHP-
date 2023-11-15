<?php
// 获取订单号、总金额和当前时间
$orderNumber = $_POST['order_number'];
$totalAmount = $_POST['total_amount'];
$currentTime = $_POST['current_time'];

// 建立与数据库的连接
$mysqli = new mysqli("159.75.211.235", "phptest", "hyj5201314", "phptest");

// 检查连接是否成功
if ($mysqli->connect_errno) {
    die("连接数据库失败：" . $mysqli->connect_error);
}
$username = $_COOKIE["username"];
// 开启事务
$mysqli->begin_transaction();

try {
    // 插入订单数据（根据实际情况修改插入语句）
    $insertOrderQuery = "INSERT INTO u_order (username, order_number, price, time) VALUES ('$username','$orderNumber', '$totalAmount', '$currentTime')";
    $mysqli->query($insertOrderQuery);

    // 删除购物车数据（根据实际情况修改删除语句）
    $deleteCartQuery = "DELETE FROM shoppcart WHERE username = '$username'"; // 假设用户ID为1
    $mysqli->query($deleteCartQuery);

    //查询余额
    $check_balance = "SELECT balance FROM user WHERE username = '$username'";
    $result = $mysqli->query($check_balance);
    $row = $result->fetch_assoc();
    $balance = $row['balance'];

    //扣款
    $deductions = "UPDATE user SET balance = $balance-$totalAmount WHERE username = '$username'";
    $mysqli->query($deductions);
    // 提交事务
    $mysqli->commit();

    // 返回成功状态
    http_response_code(200);
    header("Location: personalcenter.php");
    //清空cookie
    $_COOKIE['total_amount'] = 0;
} catch (Exception $e) {
    // 回滚事务
    $mysqli->rollback();

    // 处理异常
    echo "提交订单失败：" . $e->getMessage();
}

// 关闭数据库连接
$mysqli->close();
?>
