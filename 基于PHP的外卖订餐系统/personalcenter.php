<!DOCTYPE html>
<?php
//用户账号
$username = $_COOKIE['username'];

//判断是否登录
if ($username == "" || !isset($username)){
    header("Location: notlogin.html");
}

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

// 查询shoppcart表的数据
$sql = "SELECT * FROM shoppcart WHERE username = '$username'";
$result = $conn->query($sql);

$totalAmount = 0; // 总金额变量

if ($result->num_rows > 0) {
    // 循环遍历查询结果
    while ($row = $result->fetch_assoc()) {
        // 累加价格
        $totalAmount += $row["product_price"] * $row["num"];
    }
}

// 将总金额存入 cookie
setcookie("total_amount", $totalAmount); // 设置 cookie
?>
<html>
<head>
    <title>个人中心</title>
    <meta charset="UTF-8">
    <style>
        /* 样式设置 */

        html {
            height: 100%;
        }

        body{font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* 设置背景铺满 */
            background-repeat:no-repeat;
            background-size:100%;
        }

        .container {
            height: 100%;
            background-image: linear-gradient(to right, #fbc2eb, #a6c1ee);
        }

        .container1 {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .balance {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #555;
        }

        .form-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container form {
            display: inline-block;
        }

        .form-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="button"]:hover {
            background-color: #45a049;
        }

        .form-container input[type="button"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .cart-container {
            margin-bottom: 30px;
        }

        .cart-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-container th,
        .cart-container td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .cart-container th {
            background-color: #f5f5f5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .order-container {
            margin-bottom: 30px;
        }

        .order-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-container th,
        .order-container td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .order-container th {
            background-color: #f5f5f5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .b_container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10vh;
        }

        #login_out {
            background-color: #4CAF50; /* 设置背景颜色 */
            color: white; /* 设置文本颜色 */
            padding: 10px 20px; /* 设置内边距 */
            font-size: 16px; /* 设置字体大小 */
            border: none; /* 移除边框 */
            cursor: pointer; /* 设置鼠标样式为手型 */
            border-radius: 4px; /* 设置圆角 */
            text-align: center;
        }

        #login_out:hover {
            background-color: #45a049; /* 鼠标悬停时的背景颜色 */
        }

        #return_main {
            /*background-color: rgba(232, 234, 238, 0.58);*/
            background-color: transparent;
            color: #002ee7;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        #return_main:hover {
            background-color: #45a049;
        }

        .table-cell {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .cool-button {
            border: none;
            border-radius: 20px;
            padding: 5px 10px; /* 调整按钮的内边距 */
            background-image: linear-gradient(to right, #a6c1ee, #fbc2eb);
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
<script type="text/javascript" src="jQuery//jQueryFile.js"></script>
<script>
    function remain(){
        location.href = "main.html";
    }
</script>
<div class="container">
<div>
    <button id="return_main" onclick="remain()"><<返回主界面</button>
    <script>
        function getCookie(name){
            var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
            if (arr = document.cookie.match(reg)){
                return (arr[2]);
            }else{
                return null;
            }
        }
        var username = getCookie('username');
        document.write("<h1>"+"尊敬的"+username+"用户"+"</h1>");
    </script>
</div>
<div class="container1">
    <h1>个人中心</h1>

    <div class="balance">
        <h2>账户余额</h2>
        <p id="balanceAmount">
            <?php
            // 查询user表的balance字段
            $sql = "SELECT balance FROM user where username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // 获取查询结果的第一行
                $row = $result->fetch_assoc();
                $balance = $row["balance"];

                // 输出余额
                echo $balance;
            } else {
                echo "无余额信息";
            }
            ?>
        </p>
    </div>


    <div class="form-container">
        <script>
            function showInputBox() {
                var amount = prompt("请输入充值金额：");
                if (amount !== null) {
                    // 发送 AJAX 请求到 PHP 文件
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "to_up_balance.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert(xhr.responseText); // 显示返回的结果
                            location.reload();
                        }
                    };
                    xhr.send("amount=" + encodeURIComponent(amount));
                }
            }
        </script>
        <form action="submit_cart.php" method="post">
            <h2>购物车</h2>
            <!-- 在这里添加购物车表单的字段 -->
            <input type="submit" value="提交订单" onclick="return confirmOrder()">
            <input type="button" value="充值余额" onclick="showInputBox()">
        </form>
    </div>

    <script>
        function confirmOrder() {
            function getCookie(name){
                var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
                if (arr = document.cookie.match(reg)){
                    return (arr[2]);
                }else{
                    return null;
                }
            }
            var totalAmount = getCookie('total_amount'); // 总金额变量，根据实际情况修改获取总金额的逻辑

            if (totalAmount == 0){
                alert("购物车为空，请先去选择菜品吧~");
                return false;
            }else {
                // 弹出提示框，显示总金额和确认订单信息
                var confirmation = confirm("确认支付？\n总金额：" + totalAmount);
                if (!confirmation) {
                    return false; // 取消订单提交
                }

                // 发送异步请求到服务器，检查余额是否足够
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "check_balance.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.balance_sufficient) {
                                // 余额足够，提交订单
                                submitOrder(totalAmount);
                            } else {
                                // 余额不足，显示提示信息
                                alert("余额不足");
                            }
                        } else {
                            // 处理请求错误
                            alert("请求错误：" + xhr.status);
                        }
                    }
                };
                xhr.send();

                return false; // 阻止表单的默认提交行为
            }

            function submitOrder(totalAmount) {
                // 生成订单号
                var orderNumber = generateOrderNumber();

                // 获取当前时间
                var currentTime = getCurrentTime();

                // 发送异步请求到服务器，插入订单数据并删除购物车数据
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "submit_order.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 显示提交成功信息
                            alert("支付成功");
                            //提交之后刷新界面
                            location.reload();
                        } else {
                            // 处理请求错误
                            alert("请求错误：" + xhr.status);
                        }
                    }
                };
                xhr.send("order_number=" + orderNumber + "&total_amount=" + totalAmount + "&current_time=" + currentTime);
                return false; // 阻止表单的默认提交行为
            }

            function generateOrderNumber() {
                // 生成订单号
                // 使用时间戳作为订单号
                var timestamp = Date.now();
                return "HZR" + timestamp;
            }

            function getCurrentTime() {
                // 获取当前时间的逻辑，根据实际需求进行修改
                // 示例：使用 JavaScript 内置函数获取当前时间
                var currentTime = new Date().toLocaleString("en-US", { timeZone: "Asia/Shanghai", hour12: false });
                return currentTime;
            }
        }
    </script>

    <div class="cart-container">
        <h2>购物车内容</h2>
        <table>
            <thead>
            <tr>
                <th>商品名称</th>
                <th>价格</th>
                <th>数量</th>
            </tr>
            </thead>
            <tbody>

            <script>
                function changeQuantity(username,amount,id) {
                    // 发送异步请求到后端处理数量变更
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_quantity.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // 处理成功响应后的逻辑
                            location.reload(); // 刷新页面以更新购物车显示
                        }
                    };
                    xhr.send("username=" + username + "&amount=" + amount + "&id=" + id);
                }
            </script>

            <?php
            // 查询shoppcart表的数据
            $sql = "SELECT * FROM shoppcart WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // 循环遍历查询结果
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='table-cell'>" . $row["product_name"] . "</td>";
                    echo "<td class='table-cell'>" . $row["price"] . "</td>";
                    echo "<td class='table-cell'>" . $row["num"] . "</td>";
                    echo "<td class='table-cell'>";
                    echo '<button class="cool-button" onclick="changeQuantity(\'' . $row["username"] . '\', -1, \'' . $row["product_id"] . '\')">-</button>'; // 减按钮
                    echo "<a>"."  "."</a>";
                    echo '<button class="cool-button" onclick="changeQuantity(\'' . $row["username"] . '\', 1, \'' . $row["product_id"] . '\')">+</button>'; // 加按钮
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>购物车为空</td></tr>";
            }
            ?>


            </tbody>
        </table>
    </div>


    <div class="order-container">
        <h2>历史订单</h2>
        <table>
            <thead>
            <tr>
                <th>订单号</th>
                <th>日期</th>
                <th>总金额</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // 查询u_order表的最近十条数据，按照s_time字段降序排列
            $sql = "SELECT * FROM u_order WHERE username = '$username' ORDER BY time DESC LIMIT 10";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // 循环遍历查询结果
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_number"] . "</td>";
                    echo "<td>" . $row["time"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>没有历史订单</td></tr>";
            }

            //关闭数据库连接
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
    <script>
        function logout() {
            // 清除名为 "username" 的 cookie
            document.cookie = "username=";

            // 执行其他退出登录后的操作，例如重定向到登录页面
            alert("退出成功")
            location.href = "login.html";
        }
    </script>
    <div class="b_container">
        <button id="login_out" onclick="logout()">退出登录</button>
    </div>
</div>
</div>
</body>
</html>
