<?php
//获取用户名
$username = $_COOKIE['username'];

//判断是否登录
if (!isset($username) || $username == ""){
    echo "您未登录!请返回登录";
    header("Location: notlogin.html");
}else{
    //连接数据库
    $servername = "159.75.211.235";
    $s_username = "phptest";
    $s_password = "hyj5201314";
    $dbname = "phptest";
    $conn = new mysqli($servername,$s_username,$s_password,$dbname);
    if ($conn->connect_errno) {
        die("Connection failed:" . $conn->connect_errno);
    } else {
        echo "";
    }

    //获取菜品数量
    for ($i = 1; $i <= 18; $i++) {
        $variableName = 's' . $i;  // 构建变量名
        $$variableName = $_POST["$variableName"];
    }


    //存入数据库
    for ($i = 1; $i <= 18; $i++) {
        $variableName = 's' . $i;  // 构建变量名
        if ($$variableName != 0) {
            $q_sql = "select * from product_list where product_id = '$variableName'";
            $result = $conn->query($q_sql);
            $row = mysqli_fetch_assoc($result);
            $name = $row['product_name'];
            $price = $row['product_price'];
            $id = $row['product_id'];
            $num = $$variableName;
            $date = date("Y-m-d H:i:s");
            $sum_price = $price * $$variableName;
            $i_sql = "insert into shoppcart (username,s_time,product_name,num,price,product_id,product_price) values ('$username','$date','$name','$num','$sum_price','$id','$price')";
            $conn->query($i_sql);
        }
    }

    //关闭数据库
    $conn->close();

    //判断是否选择了菜品
    $sum = 0;
    for ($i = 1; $i <= 18; $i++) {
        $variableName = 's' . $i;  // 构建变量名
        $sum += $$variableName;    // 使用变量名的值进行累加
    }
    if ($sum != 0){
        header("Location: addshoppcart.html");
    }else{
        echo "您未选择菜品";
    }
}
?>