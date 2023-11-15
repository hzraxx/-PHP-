<?php
// 获取传递的参数
$username = $_POST['username'];
$amount = $_POST['amount'];
$id = $_POST['id'];
// 数据库连接信息
$servername = "159.75.211.235";
$s_username = "phptest";
$s_password = "hyj5201314";
$dbname = "phptest";

// 创建数据库连接
$conn = new mysqli($servername, $s_username, $s_password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
// 查询数据库中对应的记录
$sql = "SELECT * FROM shoppcart WHERE username = '$username' AND product_id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentQuantity = $row['num'];

    // 更新数量
    $newQuantity = $currentQuantity + $amount;

    $price = $row['product_price'] * $newQuantity;
    if ($newQuantity < 0) {
        $newQuantity = 0;
    }

    // 更新数据库中的数量
    $updateSql1 = "UPDATE shoppcart SET num = $newQuantity WHERE username = '$username' AND product_id = '$id'";
    $updateSql2 = "UPDATE shoppcart SET price = '$price' WHERE username = '$username' AND product_id = '$id'";
    $conn->query($updateSql1);
    $conn->query($updateSql2);

    if ($newQuantity == 0) {
        // 删除数量为0的行数据
        $deleteSql = "DELETE FROM shoppcart WHERE username = '$username' AND product_id = '$id'";
        $conn->query($deleteSql);
    }

    // 返回成功响应
    echo "success";
} else {
    // 返回错误响应
    echo "error";
}
?>