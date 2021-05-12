<?php
include "../includes/database.php"; // Database !!
?>
<?php
    // Variables
    $time = json_decode($_POST['time']);
    $id;
    $trans_id;
    $order_id;
    // Variables
    // SQL 
    $sql_get_customers = "SELECT * FROM `tbl_customers` ORDER BY customer_id DESC LIMIT 1"; // Gets Last Customer ID !!
    $result = mysqli_query($conn, $sql_get_customers);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['customer_id'];
        }
    }
    else{
        $id = 0;
    }
    $sql_get_transactions = "SELECT * FROM `tbl_transactions` ORDER BY trans_id DESC LIMIT 1"; // Gets Last Transaction ID !!
    $result = mysqli_query($conn, $sql_get_transactions);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $trans_id = $row['trans_id'];
        }
    }
    else{
        $trans_id = 0;
    }
    $sql_get_orders = "SELECT * FROM `tbl_orders` ORDER BY order_id DESC LIMIT 1"; // Gets Last Transaction ID !!
    $result = mysqli_query($conn, $sql_get_orders);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $order_id = $row['order_id'];
        }
    }
    else{
        $order_id = 0;
    }
    // SQL 
    $id = $id + 1; // Add 1 from the Last Customer ID !!
    $trans_id = $trans_id + 1; // Add 1 from the Last Transaction ID !!
    $order_id = $order_id + 1; // Add 1 from the Last Order ID !!
    $orders = json_decode($_POST['orders'], TRUE);
    foreach($orders as $order){ // orders as order !!
        // INSERT multiple data !!
        $sql = "INSERT INTO `tbl_orders` (`order_id`, `product_id`, `customer_id`, `order_date_time`, `order_status`, `trans_id`, `order_quantity`, `order_total`) 
        VALUES ({$order_id}, '{$order['product_id']}', '{$id}', current_timestamp(), 'Pending', '{$trans_id}', {$order['product_quantity']}, {$order['product_price']} )";
        $conn->query($sql);

        $sql_add_customers = "INSERT INTO `tbl_customers`(`customer_id`, `customer_date_added`) 
        VALUES ('{$id}', current_timestamp())";
        $conn->query($sql_add_customers);

        $sql_add_transactions = "INSERT INTO `tbl_transactions`(`trans_id`, `trans_date_time` , `trans_time`) 
        VALUES ('{$trans_id}', current_timestamp(), '{$time}')";
        $conn->query($sql_add_transactions);
    }
?>
