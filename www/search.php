<?php
include "../includes/database.php"; // Database !!
?>
<?php
   $search = json_decode($_POST['search'], TRUE); // Search Function !!
   if($search === ''){
   }
   else{
   $sql = "SELECT * FROM `tbl_products` WHERE product_name 
   LIKE '%$search%' OR product_type 
   LIKE '%$search%' OR product_price 
   LIKE '%$search%'";
   $result = mysqli_query($conn, $sql);
   $queryResult = mysqli_num_rows($result);
   if ($queryResult > 0 ){
       while ($row = mysqli_fetch_assoc($result)){
            echo "<div class='menu-food' style='background-color:#d8f8b7'>";
                echo $row['product_name'];
                $row = json_encode($row);
                echo "<button class='button-add' onclick='add($row)'> <i class='fas fa-plus'></i> </button>"; // Pass Data to JSON object
            echo "</div>";
       }
   }
   }
?>
