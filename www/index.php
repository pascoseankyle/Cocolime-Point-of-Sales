<?php
 include "../includes/database.php"; // Database !!
?>
<html>
    <head>
        <link rel="stylesheet" href="../styles/styles.css">
    </head>
         <!-- ---------------------------------------------------------------------------- -->
        <header><img src="../styles/cocolime.png">POS</header>
         <!-- Navigation -->
        <nav>
            <a onclick="openSales()"><i class="fas fa-shopping-cart"></i> &nbsp Sales</a>
            <a onclick="openTransactions()"><i class="fas fa-history"></i> &nbsp Transactions</a>
            <a><i class="fas fa-sign-out-alt"></i> &nbsp Logout</a>
        </nav>
         <!-- Order List -->
         <div class="div-order" id="div-order">
            <div class="div-order-left" style="height:500px">
                <h1 style="float: left;width: 25%;color:rgb(63, 63, 63)"><i class="fas fa-cart-plus"></i> Orders</h1>
                <button onclick="sendOrders()" class='button-submit'><i class="fas fa-share"></i>&nbsp <b>Add Orders</b> </button>
                <button onclick="emptyOrders()" style="float: right;width: 20%;padding: 10px;border-radius: 20px;
                background-color:rgb(252, 167, 167);" onMouseOver="this.style.background='transparent'" 
                onMouseOut="this.style.background='rgb(252, 167, 167)'"><b>Cancel Orders</b> </button>
                <br>
                <br>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <tbody id='orders'>
                    </tbody>
                </table>
                <br>
            </div>
            <div class="div-order-right">
                <h1 style="color:rgb(63, 63, 63)"><i class="fas fa-utensils"></i> Menu</h1>
                <br>
                <hr>
                <br>
                <i class="fas fa-search"></i>&nbsp<input name="search" id="search" type="text" placeholder="Search" class="search" oninput="search()">
                <br>
                <div id="result"></div>
                <br>
                <?php
                $sql = "SELECT * FROM tbl_products WHERE 1"; // Get Data !!
                $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='menu-food'>";
                        echo $row['product_name'];
                        $row = json_encode($row);
                        echo "<button class='button-add' onclick='add($row)'> <i class='fas fa-plus'></i> </button>"; // Pass Data to JSON object
                        echo "</div>";
                        }
                    }
                    else
                    {
                    echo "no data";
                    }
                ?>
            </div>
            <div style=" float: left;
                width: 300px;
                padding: 20px;
                border-radius: 25px;
                overflow: auto;
                text-align: center;">
                <h3 id='total'></h3>
            </div>
        </div>
        <!-- Transactions -->
        <div id="div-transactions" style="float: left;
        width: 80%;
        padding: 20px;
        border-radius: 20px;
        display:none;">
        <div style="float:left;width:100%;padding: 20px;">
            <h1 style="color:rgb(63, 63, 63)"><i class="fas fa-clipboard-list"></i>&nbspTransactions&nbsp<button onclick="sort_desc()" style="padding: 10px;border-radius: 20px;
                background-color:rgb(252, 167, 167);" onMouseOver="this.style.background='transparent'" 
                onMouseOut="this.style.background='rgb(252, 167, 167)'">desc<br><i class="fas fa-sort-down"></i></button>&nbsp<button onclick="sort_asc()" style="padding: 10px;border-radius: 20px;
                background-color:#DEFFE2;" onMouseOver="this.style.background='transparent'" 
                onMouseOut="this.style.background='#DEFFE2'">asc<br><i class="fas fa-sort-up"></i></button></h1>
        </div>
            <div style="float: left;
                width: 100%;
                padding: 20px;
                border-radius: 25px;
                overflow: auto;
                height: 400px;">
                <br>
                <br>
                <div id="trans-desc">
                <?php
                    $sql_trans = "SELECT tbl_transactions.trans_id, tbl_orders.customer_id, tbl_orders.order_status, tbl_transactions.trans_date_time FROM tbl_transactions INNER JOIN tbl_orders ON tbl_transactions.trans_id = tbl_orders.trans_id GROUP BY tbl_transactions.trans_date_time DESC";
                    $result_trans = mysqli_query($conn, $sql_trans);
                    if(mysqli_num_rows($result_trans) > 0){
                        while($row_trans = mysqli_fetch_assoc($result_trans)){
                            echo '<div style="float:left;padding:25px;width:95%;background: #f8f5f1;margin:5px;border-radius:15px">';
                            echo '<h3> Transaction No:';
                            echo $row_trans['trans_id'];
                            echo '</h3>';
                            echo '<hr>';
                            echo '<br>';
                            echo $row_trans['trans_date_time'];
                            echo '<br>';
                            echo '<br>';
                            echo $row_trans['order_status'];
                            echo "</div>";
                        }
                    }
                    else
                    {
                    echo "no data";
                    }
                ?>
                </div>
                <div id="trans-asc">   
                <?php
                    $sql_trans_asc = "SELECT tbl_transactions.trans_id, tbl_orders.customer_id, tbl_orders.order_status, tbl_transactions.trans_date_time FROM tbl_transactions INNER JOIN tbl_orders ON tbl_transactions.trans_id = tbl_orders.trans_id GROUP BY tbl_transactions.trans_date_time ASC";
                    $result_trans_asc = mysqli_query($conn, $sql_trans_asc);
                    if(mysqli_num_rows($result_trans_asc) > 0){
                        while($row_trans_asc = mysqli_fetch_assoc($result_trans_asc)){
                            echo '<div style="float:left;padding:25px;width:95%;background: #f8f5f1;margin:5px;border-radius:15px">';
                            echo '<h3> Transaction No:';
                            echo $row_trans_asc['trans_id'];
                            echo '</h3>';
                            echo '<hr>';
                            echo '<br>';
                            echo $row_trans_asc['trans_date_time'];
                            echo '<br>';
                            echo '<br>';
                            echo $row_trans_asc['order_status'];
                            echo "</div>";
                        }
                    }
                    else
                    {
                    echo "no data";
                    }
                ?>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/c4442c2032.js" crossorigin="anonymous"></script>
        <script src='../js/jquery-3.4.1.min.js'></script>
        <script>
            var orders = []; // Store each Food item to Array
            var data; // The Data passed from PHP
            var res;
            $( document ).ready(function() {
             show_trans();
             openSales();
            });
            function openSales(){
                $('#div-order').show();
                $('#div-transactions').hide();
            }
            function openTransactions(){
                $('#div-order').hide();
                $('#div-transactions').show();
            }
            function add(data){ // Pass Food item to orders[]
                data = data;
                orders.push(data); // Push data to orders[]
                parseProducts(orders); // Parse all numbers to Integers
                var result = orders // Group Data
                    .map((item, i, array) => {
                    const defaultValue = {
                    product_id: item.product_id,
                    product_name: item.product_name,
                    product_quantity: 0,
                    product_price: 0
                    }
                    const finalValue = array
                    .filter(other => other.product_name === item.product_name) // We filter the same items
                    .reduce((accum, currentVal) => { // We reduce them into a single entry
                        accum.product_quantity += currentVal.product_quantity;
                        accum.product_price += currentVal.product_price;
                        return accum;
                    }, defaultValue);

                    return finalValue;
                })
                .filter((item, thisIndex, array) => { // Now our new array has duplicates, lets remove them
                    const index = array.findIndex((otherItem, otherIndex) => otherItem.product_name === item.product_name && otherIndex !== thisIndex && otherIndex > thisIndex);

                    return index === -1
                })
                showAll(result);
                res = result;
                console.log(res)
            } 
            function parseProducts(array){ // Parse all numbers
                for(var i=0; i<array.length;i++){
                    array[i].product_id = parseInt(array[i].product_id);
                    array[i].product_price = parseInt(array[i].product_price);
                    array[i].product_quantity = parseInt(array[i].product_quantity);
                }
                return(array);
            }
            function sendOrders(){ // Send Orders[] to PHP array
                if(orders.length === 0)
                {
                        alert('Orders: \n No Orders!'); // Validate if empty
                } 
                    else
                    {
                        alert('Orders: \n Orders Pending!');
                        $.ajax({
                            url: "orders.php",
                            method: "POST",
                            data: { orders : JSON.stringify( res ) },
                            success: function(res){
                            console.log(res)
                        }
                        });
                    }
                var empty_orders = []; // EMPTY The ARRAY orders
                orders = empty_orders; 
                var total = 0;
                var str_html='';
                for(var i=0;i<orders.length; i++){
                    str_html+='<tr>';
                    str_html+='<td> '+orders[i].product_name+'</td>';
                    str_html+='<td>'+orders[i].product_price+'</td>';
                    str_html+='</tr>';
                    total = total + parseInt(orders[i].product_price);      
                }
                $('#orders').html(str_html);
                $('#total').html("<i class='fas fa-tag'></i>&nbspTotal Cost: &nbsp ₱"+ total);
                location.reload();
            }
            function search(){
                var search = document.getElementById("search").value;
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: { search : JSON.stringify( search ) },
                    success: function(res){
                    $('#result').html(res);
                    }
                });                
            }
            function emptyOrders(){
                var empty_orders = []; // EMPTY The ARRAY orders
                orders = empty_orders;
                var total = 0;
                var str_html='';
                for(var i=0;i<orders.length; i++){
                    str_html+='<tr>';
                    str_html+='<td> '+orders[i].product_name+'</td>';
                    str_html+='<td>'+orders[i].product_price+'</td>';
                    str_html+='<td><button class="button-delete" onclick="remove()"><i class="fas fa-trash"></i></button></td>';
                    str_html+='</tr>';
                    total = total + parseInt(orders[i].product_price);      
                }
                $('#orders').html(str_html);
                $('#total').html("<i class='fas fa-tag'></i>&nbspTotal Cost: &nbsp ₱"+ total); 
            }
            function showAll(array){
                var total = 0;
                var str_html='';
                for(var i=0;i<array.length; i++){ // Display the clicked food items from array[]
                    str_html+='<tr>';
                    str_html+='<td> '+array[i].product_name+'</td>';
                    str_html+='<td>'+array[i].product_quantity+'</td>';
                    str_html+='<td>'+array[i].product_price+'</td>';
                    str_html+='</tr>';
                    total = total + parseInt(array[i].product_price);
                }
                $('#orders').html(str_html);
                $('#total').html("<i class='fas fa-tag'></i>&nbspTotal Cost: &nbsp ₱"+ total);
            }
            function show_trans(){ // Show trans div
                   $('#trans-desc').show();
                   $('#trans-asc').hide();
            }
            function sort_desc(){ // Show transation descendng div
                   $('#trans-desc').show();
                   $('#trans-asc').hide();
            }
            function sort_asc(){ // Show transation ascendng div
                   $('#trans-desc').hide();
                   $('#trans-asc').show();
            }
        </script>
</html>