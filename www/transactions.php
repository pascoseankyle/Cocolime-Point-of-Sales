<?php
 include "../includes/database.php"; // Database !!
?>
<?php
$data = array();
 $sql_trans_asc = "SELECT tbl_transactions.trans_id, tbl_orders.customer_id, tbl_orders.order_status, tbl_transactions.trans_date_time, tbl_transactions.trans_time FROM tbl_transactions INNER JOIN tbl_orders ON tbl_transactions.trans_id = tbl_orders.trans_id GROUP BY tbl_transactions.trans_date_time ASC";
 $result_trans_asc = mysqli_query($conn, $sql_trans_asc);
 if(mysqli_num_rows($result_trans_asc) > 0){
     while($row_trans_asc = mysqli_fetch_assoc($result_trans_asc)){
        array_push($data, $row_trans_asc);
     }
 }
 else
 {
 echo "no data";
 }
 echo json_encode($data);
?>